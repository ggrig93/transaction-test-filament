<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
           'name' => 'test',
           'email' => 'test@test.com',
           'password' => bcrypt('userpass123'),
           'balance' => 50000,
           'is_admin' => 1,
        ]);
    }
}
