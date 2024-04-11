<?php

use App\Http\Middleware\AuthMiddleware;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\SubtaskController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Authentication Routes
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::get('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

// Main data routes
Route::middleware('auth:api')->group(function () {
    Route::get('todos', [TodoController::class, 'index']);
    Route::post('todos', [TodoController::class, 'store']);
    Route::get('subtasks', [SubtaskController::class, 'indexSubtasks']);
    Route::delete('subtasks/{subtask}', [SubtaskController::class, 'deleteSubtask']);

    Route::prefix('todos/{todo}')->group(function () {
        Route::get('/', [TodoController::class, 'show']);
        Route::put('/', [TodoController::class, 'update']);
        Route::delete('/', [TodoController::class, 'destroy']);

        Route::prefix('subtasks')->group(function () {
            // Route::get('/{subtask}', [SubtaskController::class, 'showSubtasks']);
            Route::post('/', [SubtaskController::class, 'storeSubtask']);
            Route::put('/{subtask}', [SubtaskController::class, 'updateSubtask']);
        });
    });

    // Route to retrieve authenticated user information
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
