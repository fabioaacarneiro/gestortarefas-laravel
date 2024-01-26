<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'user1',
                'email' => 'user1@email.com',
                'password' => Hash::make('user1'),
                'created_at' => date('Y-m-d H:i:s'),
                'tasklist_id' => 1,
            ],
        ]);
    }
}
