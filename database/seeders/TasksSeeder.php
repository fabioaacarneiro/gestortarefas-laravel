<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tasks')->insert([
            [
                'name' => 'prova de java',
                'description' => 'primeira prova do semestre, preciso estudar',
                'status' => 'new',
            ],
        ]);
    }
}
