<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('orders')->insert([
            [
                'vehicle_id' => 1,
                'driver_id' => 1,
                'approver1_id' => 2,
                'approver2_id' => 3,
                'location_id' => 1,
                'start_date' => Carbon::now()->format('Y-m-d'),
                'end_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
                'reason' => 'pengajuan',
                'status' => 'pending',
            ],
            [
                'vehicle_id' => 1,
                'driver_id' => 1,
                'approver1_id' => 2,
                'approver2_id' => 3,
                'location_id' => 3,
                'start_date' => Carbon::now()->format('Y-m-d'),
                'end_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
                'reason' => 'pengajuan',
                'status' => 'pending',
            ],

        ]);
    }
}
