<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        // Protect routes (Sanctum authentication)
        $this->middleware('auth:sanctum');
    }
    public function index()
    {

        $tasks = Task::all();
        // not found
        if ($tasks->isEmpty()) {
            return response()->json([
                'message' => 'No tasks found.',
                'data' => [],
            ], 404);
        }

        // success
        return response()->json([
            'message' => 'Tasks fetched successfully',
            'data' => $tasks,
        ], 200);
    }


    public function store(Request $request)
    {
        try {
            $user = $request->user();
            
            // Validation
            $request->validate([
                'title' => 'required|string|max:255',
                'status' => 'required|in:pending,in-progress,completed',
            ]);
        
            // Create the new task 
            $task = $user->tasks()->create([
                'title' => $request->title,
                'status' => $request->status,
            ]);
        
            // Return a success response 
            return response()->json([
                'message' => 'Task created successfully',
                'data' => $task,
            ], 201);
        
        } catch (\Exception $e) {
            // Catch unexpected errors 
            return response()->json([
                'message' => 'An error occurred while creating the task.',
                'error' => $e->getMessage(),
            ], 500);  
        }
    }

    public function update(Request $request, Task $task)
    {
        try {
            // Validation
            $request->validate([
                'title' => 'required|string|max:255', 
                'status' => 'required|in:pending,in-progress,completed', 
            ]);
        
            // Update the task with the validated data
            $task->update([
                'title' => $request->title,
                'status' => $request->status,
            ]);
        
            // Return a success response with the updated task
            return response()->json([
                'message' => 'Task updated successfully',
                'data' => $task,
            ], 200);
        
        } catch (\Exception $e) {
            // Catch unexpected errors 
            return response()->json([
                'message' => 'An error occurred while updating the task.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function destroy(Task $task)
    {
        try {
            // Delete the task
            $task->delete();
            
            // Return a success response
            return response()->json([
                'message' => 'Task deleted successfully',
            ], 200);
            
        } catch (\Exception $e) {
            // Catch unexpected errors
            return response()->json([
                'message' => 'An error occurred while deleting the task.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    

}
