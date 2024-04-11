<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subtask;

class SubtaskSeeder extends Seeder
{
    public function run()
    {
        $subtasks = [
            [
                'todo_id' => 1, // Replace with the appropriate todo_id
                'title' => 'Define database schema',
                'completed' => false,
            ],
            [
                'todo_id' => 1, // Replace with the appropriate todo_id
                'title' => 'Create migration files',
                'completed' => false,
            ],
            [
                'todo_id' => 1, // Replace with the appropriate todo_id
                'title' => 'Seed initial data',
                'completed' => true,
            ],
        ];

        // Create subtasks
        foreach ($subtasks as $subtaskData) {
            Subtask::create($subtaskData);
        }
    }
}
