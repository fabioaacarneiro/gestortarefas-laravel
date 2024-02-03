<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'fabio',
                'email' => 'fabio@email.com',
                'password' => Hash::make('fabio'),
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ]);

    }
}
