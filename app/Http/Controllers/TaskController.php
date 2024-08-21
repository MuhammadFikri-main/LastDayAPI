<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = auth()->user()->tasks()->orderBy('priority')->get();
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|string', // e.g., urgent-important
            'due_date' => 'nullable|date',
        ]);

        $task = auth()->user()->tasks()->create($validated);
        return response()->json($task, 201);
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|string',
            'due_date' => 'nullable|date',
        ]);

        $task->update($validated);
        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();
        return response()->json(null, 204);
    }

    public function reorder(Request $request)
    {
        // Handle drag-and-drop reordering logic here
        $tasks = $request->tasks; // Array of task IDs in new order

        foreach ($tasks as $index => $taskId) {
            Task::where('id', $taskId)->update(['sort_order' => $index]);
        }

        return response()->json(['message' => 'Tasks reordered successfully']);
    }

    public function sortByEisenhowerMatrix()
    {
        $tasks = auth()->user()->tasks()
            ->orderByRaw("FIELD(priority, 'urgent-important', 'not-urgent-important', 'urgent-not-important', 'not-urgent-not-important')")
            ->get();
        
        return response()->json($tasks);
    }

}