<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Task;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = $request->get('auth_user');

            $tasks = Task::where('user_id', $user['user_id'])
                         ->where('is_delete', false)
                         ->get();

            return response()->json($tasks);

        } catch (\Exception $e) {
            return response()->json(['error'=>$e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $user = $request->get('auth_user');

            $task = Task::create([
                'title'=>$request->title,
                'user_id'=>$user['user_id']
            ]);

            return response()->json($task);

        } catch (\Exception $e) {
            return response()->json(['error'=>$e->getMessage()], 500);
        }
        
    }

    public function update(Request $request, $id)
    {
        
        try {
            $user = $request->get('auth_user');

            $task = Task::where('user_id',$user['user_id'])->findOrFail($id);

            $task->update([
                'title'=>$request->title
            ]);

            return response()->json($task);

        } catch (\Exception $e) {
            return response()->json(['error'=>$e->getMessage()], 500);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $user = $request->get('auth_user');

            $task = Task::where('user_id',$user['user_id'])->findOrFail($id);

            $task->update([
                'is_delete'=>true
            ]);

            return response()->json(['message'=>'Task deleted']);

        } catch (\Exception $e) {
            return response()->json(['error'=>$e->getMessage()], 500);
        }
    }

    public function markAsCompleted(Request $request, $id)
    {
        try {
            $user = $request->get('auth_user');

            $task = Task::where('user_id',$user['user_id'])->findOrFail($id);

            $is_completed = $task->is_complete;

            $task->update([
                'is_complete'=>!$is_completed
            ]);

            $task->save();

            return response()->json(['message'=>'Task marked as '.(!$is_completed ? 'completed' : 'incomplete')]);

        } catch (\Exception $e) {
            return response()->json(['error'=>$e->getMessage()], 500);
        }
    }

}
