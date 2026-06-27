<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::updateOrCreate(
            ['username' => 'admin'],
            [
                'password' => 'Admin@1234',
                'full_name' => 'System Administrator',
                'email' => 'admin@dormsphere.local',
                'phone' => '+41 79 000 0000',
            ]
        );
    }
}
