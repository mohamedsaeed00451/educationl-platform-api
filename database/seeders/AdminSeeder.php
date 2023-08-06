<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->delete();

        $admin = [
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make(12345678),
            'phone' => '01010101010',
            'address' => 'admin address'
        ];

        Admin::create($admin);
    }
}
