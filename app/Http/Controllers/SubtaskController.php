<?php

namespace App\Http\Controllers;

use App\Models\Subtask;
use App\Http\Requests\SubtaskCreateRequest;
use App\Http\Requests\SubtaskUpdateRequest;
use App\Http\Resources\SubtaskResource;
use App\Repositories\TodoRepositories;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SubtaskController extends Controller
{
    protected $todoRepository;

    public function __construct(TodoRepositories $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    public function indexSubtasks()
    {
        $subtasks = Subtask::all();

        return response()->json(['subtasks' => $subtasks]);
    }

    // public function showSubtasks($todoId, $subtaskId)
    // {
    //     $todo = $this->todoRepository->find($todoId);

    //     if (!$todo) {
    //         return response()->json(['error' => 'Task does not exist'], Response::HTTP_NOT_FOUND);
    //     }

    //     $subtask = $todo->subtasks()->find($subtaskId);

    //     if (!$subtask) {
    //         return response()->json(['error' => 'Subtask does not exist'], Response::HTTP_NOT_FOUND);
    //     }

    //     return new SubtaskResource($subtask);
    // }

    public function storeSubtask(SubtaskCreateRequest $request, $id)
    {
        $todo = $this->todoRepository->find($id);

        if (!$todo) {
            return response()->json(['error' => 'Task does not exist'], Response::HTTP_NOT_FOUND);
        }

        $subtaskData = $request->validated();
        $subtask = $todo->subtasks()->create($subtaskData);

        return new SubtaskResource($subtask); // Return the created subtask
    }

    public function updateSubtask(SubtaskUpdateRequest $request, $todoId, $subtaskId)
    {
        try {
            $validatedData = $request->validated();
            $subtask = $this->todoRepository->updateSubtask($todoId, $subtaskId, $validatedData);
            return new SubtaskResource($subtask); // Return the updated subtask
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => 'Task or subtask not found'], Response::HTTP_NOT_FOUND);
        } catch (\InvalidArgumentException $exception) {
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
    public function deleteSubtask($subtaskId)
    {
        try {
            $subtask = Subtask::findOrFail($subtaskId);
            $subtask->delete();
            return response()->json(['message' => 'Subtask deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
