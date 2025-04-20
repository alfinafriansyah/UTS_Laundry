<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaketModel;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class PaketController extends Controller
{
        public function index()
    {
        $activeMenu = 'paket';

        $page = (object) [
            'title' => 'Paket',
            'card' => 'Daftar paket yang terdaftar',
        ];

        // Mengambil semua data jenis dari tabel paket 
        $jenis = PaketModel::select('jenis')->distinct()->pluck('jenis');

        return view('admin.paket.index', ['activeMenu' => $activeMenu, 'page' => $page, 'jenis' => $jenis]);
    }

    // Ambil data paket dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $pakets = PaketModel::select('id_paket', 'kode_paket', 'nama_paket', 'jenis', 'harga');

        // Filter berdasarkan jenis jika ada
        if ($request->has('jenis') && $request->jenis != '') {
            $pakets->where('jenis', $request->jenis);
        }

        return DataTables::of($pakets)
            // Menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($paket) { 
                $btn = '<button onclick="modalAction(\'' . url('/admin/paket/' . $paket->id_paket . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';

                $btn .= '<button onclick="modalAction(\'' . url('/admin/paket/' . $paket->id_paket . '/delete') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                
                return $btn;
            })
            ->rawColumns(['aksi']) // Memberitahu bahwa kolom aksi adalah HTML
            ->make(true);
    }

    public function create()
    {
        return view('admin.paket.create');
    }

    public function store(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kode_paket' => 'required|string|max:20|unique:paket,kode_paket',
                'nama_paket' => 'required|string|min:3|max:100',
                'jenis' => 'required|string|in:kiloan,selimut,bedcover',
                'harga' => 'required|string|min:3|max:255',
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
                $paketData = $request->all();
                
                PaketModel::create($paketData);
        
                return response()->json([
                    'status' => true,
                    'message' => 'Data paket berhasil disimpan',
                ]);
        
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
                ], 500);
            }
        }

        return redirect('admin/paket');
    }

    public function edit(string $id)
    {
        $paket = PaketModel::find($id);

        return view('admin.paket.edit', ['paket' => $paket]);
    }

    public function update(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kode_paket' => 'required|string|max:20|unique:paket,kode_paket,' . $id . ',id_paket',
                'nama_paket' => 'required|string|min:3|max:100',
                'jenis' => 'required|string|in:kiloan,selimut,bedcover',
                'harga' => 'required|string|min:3|max:255',
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
                $paket = PaketModel::findOrFail($id);
                $paketData = $request->all();

                $paket->update($paketData);
        
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
        return redirect('admin/paket');
    }

    public function confirm(string $id)
    {
        $paket = PaketModel::find($id);

        return view('admin.paket.confirm', ['paket' => $paket]);
    }

    public function delete(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $paket = PaketModel::find($id);

            if ($paket) {
                $paket->delete();
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
        return redirect('admin/paket');
    }
}
