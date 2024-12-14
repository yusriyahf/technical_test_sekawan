<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DriversTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('drivers')->insert([
            [
                'name' => 'Yusriyah Firjatullah',
                'license_number' => 'A1234567',
                'phone' => '081234567890',
            ],
            [
                'name' => 'Jane Smith',
                'license_number' => 'B7654321',
                'phone' => '082345678901',
            ],
            [
                'name' => 'Albert Brown',
                'license_number' => 'C9876543',
                'phone' => '083456789012',
            ],
        ]);
    }
}
