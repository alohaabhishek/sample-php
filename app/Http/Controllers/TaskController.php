<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('user_id', session('user_id'))
                     ->where('is_delete', false)
                     ->get();

        return view('tasks', compact('tasks'));
    }

    public function store(Request $request)
    {
        Task::create([
            'title'=>$request->title,
            'user_id'=>session('user_id')
        ]);

        return redirect('/tasks');
    }

    public function update(Request $request, $id)
    {
        $task = Task::where('user_id',session('user_id'))->findOrFail($id);

        $task->update(['title'=>$request->title]);

        return redirect('/tasks');
    }

    public function delete($id)
    {
        $task = Task::where('user_id',session('user_id'))->findOrFail($id);

        $task->update(['is_delete'=>true]);

        return redirect('/tasks');
    }
}