<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'username' => 'admin',
                'password' => bcrypt('admin'),
                'role' => 'admin',
                'full_name' => 'admin',
                'email' => 'admin@gmail.com',
                'position' => 'Admin',
            ],
            [
                'username' => 'yusriyahf',
                'password' => bcrypt('approver'),
                'role' => 'approver',
                'full_name' => 'Yusriyah Firjatullah',
                'email' => 'yusriyahf@gmail.com',
                'position' => 'Manager',
            ],
            [
                'username' => 'ucing',
                'password' => bcrypt('approver'),
                'role' => 'approver',
                'full_name' => 'ucing firjatullah',
                'email' => 'ucing@gmail.com',
                'position' => 'Direktur',
            ],

        ]);
    }
}
