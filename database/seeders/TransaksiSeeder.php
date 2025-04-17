<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kode_trans' => 'TRX-' . time(),
                'id_pelanggan' => 1,
                'tanggal' => Carbon::now()->subDays(2),
                'batas_waktu' => Carbon::now()->addDays(1),
                'status' => 'selesai',
                'pembayaran' => 'lunas',
            ],
            [
                'kode_trans' => 'TRX-' . (time() + 1),
                'id_pelanggan' => 2,
                'tanggal' => Carbon::now()->subDay(),
                'batas_waktu' => Carbon::now()->addDays(2),
                'status' => 'diproses',
                'pembayaran' => 'belum',
            ],
        ];
        
        DB::table('transaksi')->insert($data);
    }
}
