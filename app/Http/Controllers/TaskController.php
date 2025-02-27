<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        return Task::where('user_id', Auth::id())->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:tasks|max:255',
            'description' => 'nullable',
            'due_date' => 'required|date',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'pending',
            'due_date' => $request->due_date,
            'user_id' => Auth::id(),
        ]);

        return response()->json($task, 201);
    }

    public function update(Request $request, $id)
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'title' => 'sometimes|required|unique:tasks,title,' . $task->id,
            'description' => 'nullable',
            'status' => 'sometimes|in:pending,in_progress,completed',
            'due_date' => 'sometimes|required|date',
        ]);

        $task->update($request->all());

        return response()->json($task);
    }

    public function destroy($id)
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);
        $task->delete();

        return response()->json(null, 204);
    }
}