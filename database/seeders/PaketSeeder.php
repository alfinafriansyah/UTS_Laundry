<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kode_paket' => 'PKT001',
                'nama_paket' => 'Cuci Kering Kiloan',
                'jenis' => 'kiloan',
                'harga' => 10000.00,
            ],
            [
                'kode_paket' => 'PKT002',
                'nama_paket' => 'Cuci Setrika Kiloan',
                'jenis' => 'kiloan',
                'harga' => 15000.00,
            ],
            [
                'kode_paket' => 'PKT003',
                'nama_paket' => 'Selimut',
                'jenis' => 'selimut',
                'harga' => 25000.00,
            ],
            [
                'kode_paket' => 'PKT004',
                'nama_paket' => 'Bed Cover',
                'jenis' => 'bedcover',
                'harga' => 35000.00,
            ],
        ];
        
        DB::table('paket')->insert($data);
    }
}
