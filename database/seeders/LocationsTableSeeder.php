<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('locations')->insert([
            [
                'name' => 'Tambang 1',
                'address' => 'Jl. Raya No. 123, Jakarta, Indonesia',
            ],
            [
                'name' => 'Tambang 2',
                'address' => 'Jl. Tambang No. 45, Kalimantan, Indonesia',
            ],
            [
                'name' => 'Tambang 3',
                'address' => 'Jl. Surabaya No. 88, Surabaya, Indonesia',
            ],
            [
                'name' => 'Tambang 4',
                'address' => 'Jl. Bandung No. 78, Bandung, Indonesia',
            ],
            [
                'name' => 'Tambang 5',
                'address' => 'Jl. Gudang No. 101, Jakarta, Indonesia',
            ],
            [
                'name' => 'Tambang 6',
                'address' => 'Jl. Gudang No. 101, Jakarta, Indonesia',
            ],
        ]);
    }
}
