<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailTransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_trans' => 1,
                'id_paket' => 1,
                'quantity' => 3.5,
                'subtotal' => 35000.00,
            ],
            [
                'id_trans' => 2,
                'id_paket' => 2,
                'quantity' => 2,
                'subtotal' => 30000.00,
            ],
            [
                'id_trans' => 2,
                'id_paket' => 3,
                'quantity' => 1,
                'subtotal' => 25000.00,
            ],
        ];
        
        DB::table('detail_transaksi')->insert($data);
    }
}
