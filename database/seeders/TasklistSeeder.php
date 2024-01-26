<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TasklistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tasklists')->insert([
            [
                'name' => 'tarefas da faculdade',
                'task_id' => 1,
            ],
        ]);
    }
}
