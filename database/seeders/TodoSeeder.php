<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Todo;
use App\Models\Subtask;

class TodoSeeder extends Seeder
{
    public function run()
    {
        // Create sample todos
        $todos = [
            [
                'id' => '1',
                'title' => 'Create a table',
                'description' => 'Create a Table, Model, then a seeder',
                'completed' => true,
            ],
            [
                'id' => '2',
                'title' => 'API',
                'description' => 'Routing',
                'completed' => false,
            ],
            [
                'id' => '3',
                'title' => 'CRUD',
                'description' => 'Show, create, and update',
                'completed' => true,
            ],
        ];

        foreach ($todos as $todoData) {
            // Create todo
            $todo = Todo::create($todoData);

            // Call the SubtaskSeeder to seed subtasks for this todo
            $this->call(SubtaskSeeder::class, ['todo_id' => $todo->id]);
        }
    }
}
