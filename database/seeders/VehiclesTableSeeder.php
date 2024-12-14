<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehiclesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('vehicles')->insert([
            [
                'vehicle_number' => 'AB1234CD', // Nomor kendaraan
                'vehicle_name' => 'Truck', // Nomor kendaraan
                'type' => 'personal', // Jenis kendaraan
                'fuel_consumption' => 12.5, // Konsumsi BBM dalam km/l
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'vehicle_number' => 'EF5678GH',
                'vehicle_name' => 'Pickup',
                'type' => 'rental',
                'fuel_consumption' => 9.8,
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'vehicle_number' => 'IJ9012KL',
                'vehicle_name' => 'Bus',
                'type' => 'personal',
                'fuel_consumption' => 14.0,
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
