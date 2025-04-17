<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_user' => 'Admin Laundry',
                'username' => 'admin',
                'password' => Hash::make('admin'),
                'role' => 'admin',
            ],
            [
                'nama_user' => 'Staff Laundry',
                'username' => 'staff',
                'password' => Hash::make('123'),
                'role' => 'staff',
            ],
        ];
        
        DB::table('users')->insert($data);
    }
}
