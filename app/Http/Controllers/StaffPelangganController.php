<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PelangganModel;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class StaffPelangganController extends Controller
{
    public function index()
    {
        $activeMenu = 'pelanggan';

        $page = (object) [
            'title' => 'Pelanggan',
            'card' => 'Daftar pelanggan yang terdaftar',
        ];

        // Mengambil semua data nama dari tabel pelanggan 
        $nama = PelangganModel::select('nama_pelanggan')->distinct()->pluck('nama_pelanggan');

        return view('staff.pelanggan.index', ['activeMenu' => $activeMenu, 'page' => $page, 'nama' => $nama]);
    }

    // Ambil data pelanggan dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $pelanggans = PelangganModel::select('id_pelanggan', 'nama_pelanggan', 'telp','alamat');

        // Filter berdasarkan nama jika ada
        if ($request->has('nama_pelanggan') && $request->nama_pelanggan != '') {
            $pelanggans->where('nama_pelanggan', $request->nama_pelanggan);
        }

        return DataTables::of($pelanggans)
            // Menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($pelanggan) { 
                $btn = '<button onclick="modalAction(\'' . url('/staff/pelanggan/' . $pelanggan->id_pelanggan . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';

                $btn .= '<button onclick="modalAction(\'' . url('/staff/pelanggan/' . $pelanggan->id_pelanggan . '/delete') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                
                return $btn;
            })
            ->rawColumns(['aksi']) // Memberitahu bahwa kolom aksi adalah HTML
            ->make(true);
    }

    public function create()
    {
        return view('staff.pelanggan.create');
    }

    public function store(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_pelanggan' => 'required|string|min:3|max:100',
                'telp' => 'required|min:11|max:15',
                'alamat' => 'required|string|min:3|max:255',
            ];

            // Validasi input
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'errors' => $validator->errors()->toArray()
                ], 422);
            }
        
            try {
                $pelangganData = $request->all();
                
                PelangganModel::create($pelangganData);
        
                return response()->json([
                    'status' => true,
                    'message' => 'Data pelanggan berhasil disimpan',
                ]);
        
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
                ], 500);
            }
        }

        return redirect('staff/pelanggan');
    }

    public function edit(string $id)
    {
        $pelanggan = PelangganModel::find($id);

        return view('staff.pelanggan.edit', ['pelanggan' => $pelanggan]);
    }

    public function update(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_pelanggan' => 'required|string|min:3|max:100',
                'telp' => 'required|min:11|max:15',
                'alamat' => 'required|string|min:3|max:255',
            ];
            
            // Validasi input
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()->toArray()
                ], 422);
            }
        
            try {
                $pelanggan = PelangganModel::findOrFail($id);
                $pelangganData = $request->all();

                $pelanggan->update($pelangganData);
        
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate',
                ]);
        
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
                ], 500);
            }
        }
        return redirect('staff/pelanggan');
    }

    public function confirm(string $id)
    {
        $pelanggan = PelangganModel::find($id);

        return view('staff.pelanggan.confirm', ['pelanggan' => $pelanggan]);
    }

    public function delete(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $pelanggan = PelangganModel::find($id);

            if ($pelanggan) {
                $pelanggan->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('staff/pelanggan');
    }
}
