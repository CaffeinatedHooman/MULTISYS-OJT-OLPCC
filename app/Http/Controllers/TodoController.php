<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoCreateRequest;
use App\Http\Requests\TodoUpdateRequest;
use App\Http\Resources\TodoResource;
use App\Repositories\TodoRepositories;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    protected $todoRepository;

    public function __construct(TodoRepositories $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    public function index()
    {
        $todos = $this->todoRepository->all();
        return TodoResource::collection($todos);
    }

    public function store(TodoCreateRequest $request)
    {
        $validatedData = $request->validated();
        $todo = $this->todoRepository->create($validatedData);

        return new TodoResource($todo);
    }

    public function show($id)
    {
        $todo = $this->todoRepository->find($id);

        if (!$todo) {
            return response()->json(['error' => 'Task does not exist'], Response::HTTP_NOT_FOUND);
        }

        // Load subtasks only if the todo item exists
        $todo->load('subtasks');

        return new TodoResource($todo);
    }

    public function update(TodoUpdateRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            $todo = $this->todoRepository->update($id, $validatedData);

            return new TodoResource($todo);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => 'Task not found'], Response::HTTP_NOT_FOUND);
        }
    }

    public function destroy($id)
    {
        try {
            $this->todoRepository->delete($id);
            return response()->json(['message' => 'Task deleted successfully'], Response::HTTP_OK);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => 'Task not found'], Response::HTTP_NOT_FOUND);
        }
    }
}
