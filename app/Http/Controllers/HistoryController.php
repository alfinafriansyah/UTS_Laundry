<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PelangganModel;
use App\Models\PaketModel;
use App\Models\TransaksiModel;
use App\Models\DetailTransaksiModel;
use Yajra\DataTables\DataTables;

class HistoryController extends Controller
{
    public function index()
    {
        $activeMenu = 'history';

        $page = (object) [
            'title' => 'History',
            'card' => 'History Transaksi',
        ];

        // Mengambil semua data nama dari tabel pelanggan
        $pelanggan = PelangganModel::select('nama_pelanggan')->distinct()->pluck('nama_pelanggan');

        return view('admin.history.index', ['activeMenu' => $activeMenu, 'page' => $page, 'pelanggan' => $pelanggan]);
    }

    // Ambil data pelanggan dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        // Query untuk join tabel
        $history = TransaksiModel::select([
            't.id_trans',
            't.kode_trans',
            't.tanggal',
            't.batas_waktu',
            't.status',
            'p.nama_pelanggan',
            'pk.nama_paket',
            'dt.quantity',
            'dt.harga_satuan',
            'dt.subtotal'
        ])
        ->from('transaksi as t')
        ->join('pelanggan as p', 't.id_pelanggan', '=', 'p.id_pelanggan')
        ->join('detail_transaksi as dt', 't.id_trans', '=', 'dt.id_trans')
        ->join('paket as pk', 'dt.id_paket', '=', 'pk.id_paket');

        // Filter berdasarkan nama pelanggan jika ada
        if ($request->has('nama_pelanggan') && $request->nama_pelanggan != '') {
            $history->where('p.nama_pelanggan', 'like', '%' . $request->nama_pelanggan . '%');
        }

        return DataTables::of($history)
            // Menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($transaksi) { 
                $btn = '';
    
                if ($transaksi->status == 'baru') {
                    $btn .= '<button class="btn btn-sm btn-warning btn-proses" data-id="'.$transaksi->id_trans.'">Proses</button> ';
                    $btn .= '<button class="btn btn-sm btn-danger btn-hapus" data-id="'.$transaksi->id_trans.'">Hapus</button>';
                } 
                elseif ($transaksi->status == 'diproses') {
                    $btn .= '<button class="btn btn-sm btn-success btn-selesai" data-id="'.$transaksi->id_trans.'">Selesai</button> ';
                    $btn .= '<button class="btn btn-sm btn-danger btn-hapus" data-id="'.$transaksi->id_trans.'">Hapus</button>';
                }
                elseif ($transaksi->status == 'selesai') {
                    $btn .= '<button class="btn btn-sm btn-danger btn-hapus" data-id="'.$transaksi->id_trans.'">Hapus</button>';
                }

                return $btn;
            })
            ->rawColumns(['aksi']) // Memberitahu bahwa kolom aksi adalah HTML
            ->make(true);
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id_trans' => 'required|exists:transaksi,id_trans',
            'status' => 'required|in:baru,diproses,selesai'
        ]);

        try {
            $transaksi = TransaksiModel::find($request->id_trans);
            $transaksi->status = $request->status;
            $transaksi->save();

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal update status: '.$e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $transaksi = TransaksiModel::findOrFail($id);

            $transaksi->detailTransaksi()->delete();

            $transaksi->delete();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil dihapus permanen'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus transaksi: ' . $e->getMessage()
            ], 500);
        }
    }    
}
