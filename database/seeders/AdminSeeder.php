<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::updateOrCreate(
            ['email' => 'edaoncel15@gmail.com'],
            [
                'name' => 'Eda Öncel',
                'password' => Hash::make('12345678')
            ]
        );
    }
}