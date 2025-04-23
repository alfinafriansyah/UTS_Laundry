<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksiModel;
use Illuminate\Http\Request;
use App\Models\PelangganModel;
use App\Models\PaketModel;
use App\Models\TransaksiModel;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    public function index()
    {
        $activeMenu = 'transaksi';

        $page = (object) [
            'title' => 'Transaksi',
            'card' => 'Entri Transaksi',
        ];

        $kode = $this->generateKode();
        $pelanggan = PelangganModel::all();
        $paket = PaketModel::all();

        return view('admin.transaksi.index', ['activeMenu' => $activeMenu, 'page' => $page, 'kode' => $kode, 'pelanggan' => $pelanggan, 'paket' => $paket]);
    }

    public function generateKode()
    {
        $prefix = 'TRX-';
        $datePart = date('ymd'); // Tahun 2 digit, bulan, tanggal
        // Mencari record terakhir dengan kode yang sesuai pola tanggal
        $lastRecord = TransaksiModel::where('kode_trans', 'like', $prefix . $datePart . '%')
                        // Mengambil record terakhir
                        ->orderBy('kode_trans', 'desc')
                        ->first();
        
        // Menentukan nomor urut berikutnya
        $sequence = $lastRecord ? (int) substr($lastRecord->kode_trans, 6) + 1 : 1;
            
        return $prefix . $datePart . str_pad($sequence, 3, '0', STR_PAD_LEFT);
    }

    public function store(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kode_trans' => 'required|unique:transaksi,kode_trans',
                'id_pelanggan' => 'required|exists:pelanggan,id_pelanggan',
                'tanggal' => 'required|date',
                'batas_waktu' => 'required|date|after_or_equal:tanggal',
                'status' => 'required|in:baru,proses,selesai',
                'id_paket' => 'required|exists:paket,id_paket',
                'quantity' => 'required|numeric|min:1',
                'harga_satuan' => 'required|numeric|min:1',
                'subtotal' => 'required|numeric|min:1',
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
                //  Simpan data transaksi  
                $transaksi = TransaksiModel::create([
                    'kode_trans' => $request->kode_trans,
                    'id_pelanggan' => $request->id_pelanggan,
                    'tanggal' => $request->tanggal,
                    'batas_waktu' => $request->batas_waktu,
                    'status' => $request->status
                ]);

                // Simpan detail transaksi
                DetailTransaksiModel::create([
                    'id_trans' => $transaksi->id_trans,
                    'id_paket' => $request->id_paket,
                    'quantity' => $request->quantity,
                    'harga_satuan' => $request->harga_satuan,
                    'subtotal' => $request->subtotal
                ]);
        
                return response()->json([
                    'status' => true,
                    'message' => 'Data Transaksi berhasil disimpan',
                ]);
        
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
                ], 500);
            }
        }

        return redirect('admin/transaksi');
    }
}
