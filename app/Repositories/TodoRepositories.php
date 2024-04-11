<?php

namespace App\Repositories;

use App\Models\Todo;
use App\Models\Subtask;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;

class TodoRepositories
{
    public function all(): Collection 
    {
        return Todo::all();
    }

    public function create(array $data)
    {
        // Extract subtask data if provided
        $subtaskData = $data['subtasks'] ?? [];

        // Remove subtask data from the main data array
        unset($data['subtasks']);

        // Validate the main todo data
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            // Add more validation rules as needed
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // Handle validation errors
            throw new \InvalidArgumentException('Invalid todo data');
        }

        // Create the Todo item
        $todo = Todo::create($data);

        // Create subtasks if provided and validate the subtask data
        foreach ($subtaskData as $subtaskDatum) {
            // Validate the subtask data
            $validator = Validator::make($subtaskDatum, [
                'title' => 'required|string|max:255',
                // Add more validation rules as needed
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                // Handle validation errors
                throw new \InvalidArgumentException('Invalid subtask data');
            }

            // Create and save the subtask
            $subtask = new Subtask($subtaskDatum);
            $todo->subtasks()->save($subtask);
        }

        return $todo;
    }

    public function find($id): ?Todo
    {
        try {
            return Todo::with('subtasks')->findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return null;
        }
    }

    public function update($id, array $data)
    {
        $todo = Todo::findOrFail($id);
        $todo->update($data);

        // Update subtasks if provided and validate the subtask data
        if (isset($data['subtasks']) && is_array($data['subtasks'])) {
            foreach ($data['subtasks'] as $subtaskData) {
                $subtaskId = $subtaskData['id'] ?? null;
                if ($subtaskId) {
                    $subtask = $todo->subtasks()->find($subtaskId);
                    if ($subtask) {
                        $subtask->update($subtaskData);
                    }
                } else {
                    // Handle creating new subtask if it doesn't have an id
                    $subtask = new Subtask($subtaskData);
                    $todo->subtasks()->save($subtask);
                }
            }
        }

        return $todo;
    }
    
    public function deleteSubtask($todoId, $subtaskId)
    {
        $todo = Todo::findOrFail($todoId);
        $subtask = Subtask::findOrFail($subtaskId);
        
        // Ensure the subtask is associated with the given todo item
        if ($todo->subtasks->contains($subtask)) {
            $subtask->delete();
        }
    }

    public function delete($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->subtasks()->delete(); // Delete associated subtasks
        $todo->delete();
        return true;
    }

    public function updateSubtask($todoId, $subtaskId, array $data)
    {
        $todo = Todo::findOrFail($todoId);

        // Ensure the todo has the specified subtask
        $subtask = $todo->subtasks()->findOrFail($subtaskId);

        // Validate the provided data
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            // Add more validation rules as needed
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // Handle validation errors
            throw new \InvalidArgumentException('Invalid subtask data');
        }

        // Update the subtask
        $subtask->update($data);

        return $subtask;
    }
    public function allSubtasks(): Collection 
    {
        return Subtask::all(); // Change this if you need to apply specific conditions
    }

    public function findWithSubtasks($id): ?Todo
    {
        return Todo::with('subtasks')->find($id); // Load subtasks eagerly
    }
}