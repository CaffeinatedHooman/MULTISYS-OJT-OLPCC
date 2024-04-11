<?php

namespace App\Services;

use App\Models\Todo;
use App\Models\Subtask;

class SubtaskService
{
    public function createSubtask(Todo $todo, array $subtaskData)
    {
        // Create a new subtask instance
        $subtask = new Subtask($subtaskData);
        
        // Associate the subtask with the given todo
        $todo->subtasks()->save($subtask);
        
        return $subtask;
    }
}
