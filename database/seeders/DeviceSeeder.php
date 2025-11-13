<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Device;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Device::insert([
            ['nama' => 'Lampu 1', 'status' => 0],
            ['nama' => 'Lampu 2', 'status' => 0],
            ['nama' => 'Lampu 3', 'status' => 0],
            ['nama' => 'Lampu 4', 'status' => 0],
            ['nama' => 'Lampu 5', 'status' => 0],
            ['nama' => 'Lampu 6', 'status' => 0],
        ]);
    }
}
