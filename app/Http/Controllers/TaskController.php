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
            'title' => 'required|string',
            'status' => 'required|in:pending,in-progress,completed'
        ]);

        return Task::create([
            'title' => $request->title,
            'status' => $request->status,
            'user_id' => Auth::id(),
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->validate([
            'title' => 'required|string',
            'status' => 'required|in:pending,in-progress,completed'
        ]);

        $task->update($request->only(['title', 'status']));

        return $task;
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return response()->json(['message' => 'Task deleted']);
    }
}
