<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_pelanggan' => 'Budi Santoso',
                'telp' => '081234567890',
                'alamat' => 'Jl. Merdeka No. 10',
            ],
            [
                'nama_pelanggan' => 'Ani Wijaya',
                'telp' => '082345678901',
                'alamat' => 'Jl. Sudirman No. 25',
            ],
            [
                'nama_pelanggan' => 'Citra Dewi',
                'telp' => '083456789012',
                'alamat' => 'Jl. Gatot Subroto No. 5',
            ],
        ];
        DB::table('pelanggan')->insert($data);
    }
}
