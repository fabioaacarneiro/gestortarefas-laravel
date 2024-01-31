<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('tasklists')->insert([
            [
                'id' => 1,
                'name' => 'tarefas da faculdade',
                'description' => 'Projetos, provas e outras coisas da faculdade',
                'user_id' => 1,
                'deleted_at' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'name' => 'tarefas de casa',
                'description' => 'Tarefas para fazer em casa',
                'user_id' => 1,
                'deleted_at' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 3,
                'name' => 'tarefas do trabalho',
                'description' => 'Tarefas para no trabalho',
                'user_id' => 2,
                'deleted_at' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 4,
                'name' => 'tarefas da escola',
                'description' => 'Tarefas para fazer na escola',
                'user_id' => 2,
                'deleted_at' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ]);

        DB::table('tasks')->insert([
            [
                'tasklist_id' => 1,
                'name' => 'prova de java',
                'description' => 'primeira prova do semestre, preciso estudar',
                'status' => 'new',
                'deleted_at' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tasklist_id' => 1,
                'name' => 'prova de php',
                'description' => 'primeira prova do semestre, preciso estudar',
                'status' => 'new',
                'deleted_at' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tasklist_id' => 2,
                'name' => 'lavar roupas',
                'description' => 'lavar roupas',
                'status' => 'new',
                'deleted_at' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tasklist_id' => 2,
                'name' => 'fazer compras',
                'description' => 'fazer compras',
                'status' => 'new',
                'deleted_at' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tasklist_id' => 3,
                'name' => 'reunião',
                'description' => 'reunião',
                'status' => 'new',
                'deleted_at' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tasklist_id' => 4,
                'name' => 'dever de casa',
                'description' => 'dever de casa',
                'status' => 'new',
                'deleted_at' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }
}
