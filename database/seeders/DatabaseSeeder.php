<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
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

        DB::table('tasklists')->insert([
            [
                'name' => 'tarefas da faculdade',
                'description' => 'Projetos, provas e outras coisas da faculdade',
                'user_id' => 1,
                'deleted_at' => null,
            ],
            [
                'name' => 'tarefas de casa',
                'description' => 'Tarefas para fazer em casa',
                'user_id' => 1,
                'deleted_at' => null,
            ],
        ]);

        DB::table('tasks')->insert([
            [
                'tasklist_id' => 1,
                'user_id' => 1,
                'name' => 'prova de java',
                'description' => 'primeira prova do semestre, preciso estudar',
                'status' => 'new',
                'deleted_at' => null,
            ],
            [
                'tasklist_id' => 1,
                'user_id' => 1,
                'name' => 'prova de php',
                'description' => 'primeira prova do semestre, preciso estudar',
                'status' => 'new',
                'deleted_at' => null,
            ],
            [
                'tasklist_id' => 1,
                'user_id' => 1,
                'name' => 'prova de python',
                'description' => 'primeira prova do semestre, preciso estudar',
                'status' => 'new',
                'deleted_at' => null,
            ],
            [
                'tasklist_id' => 1,
                'user_id' => 1,
                'name' => 'prova de sql',
                'description' => 'primeira prova do semestre, preciso estudar',
                'status' => 'new',
                'deleted_at' => null,
            ],
            [
                'tasklist_id' => 2,
                'user_id' => 1,
                'name' => 'fazer compras',
                'description' => 'o mês chegou no fim e os mantimentos também',
                'status' => 'new',
                'deleted_at' => null,
            ],
            [
                'tasklist_id' => 2,
                'user_id' => 1,
                'name' => 'fazer faxina',
                'description' => 'fim de semana preciso fazer uma faxina enorme',
                'status' => 'new',
                'deleted_at' => null,
            ],
            [
                'tasklist_id' => 2,
                'user_id' => 1,
                'name' => 'lavar o carro',
                'description' => 'no domingo preciso lavar o carro',
                'status' => 'new',
                'deleted_at' => null,
            ],
        ]);
    }
}
