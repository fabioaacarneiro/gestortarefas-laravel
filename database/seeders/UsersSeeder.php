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
                'naem' => 'user1',
                'email' => 'user1@email.com',
                'password' => Hash::make('user1'),
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'naem' => 'user2',
                'email' => 'user2@email.com',
                'password' => Hash::make('user2'),
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'naem' => 'user3',
                'email' => 'user3@email.com',
                'password' => Hash::make('user3'),
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }
}
