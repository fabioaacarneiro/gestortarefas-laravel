<?php

namespace App\Http\Controllers;

use App\Models\TaskModel;
use Illuminate\Http\Request;

class TaskApi extends Controller
{
    
    public function updateTaskTime(Request $request)
    {
        $request->validate([
            'task_id' => 'required|integer|exists:tasks,id',
            'elapsed_time'=> 'required|integer|min:0',
            'is_running'=> 'required|boolean',
        ]);

        $task = TaskModel::find($request->input('task_id'));

        if (!$task) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tarefa não encontrada.',
            ], 404);
        }

        $task->elapsed_time = $request->input('elapsed_time');
        $task->is_running = $request->input('is_running');
        $task->save();

        return response()->json([
            'status'=> 'success',
            'message' => 'tempo atualizado com sucesso',
            'data' => $task,
        ]);
    }

    public function getTaskTime(Request $request)
    {
        $request->validate([
            'task_id' => 'required|integer|exists:tasks,id',
        ]);

        $task = TaskModel::find($request->input('task_id'));

        
        if (!$task) {
            return response()->json([
                'status'=> 'error',
                'message'=> 'task is not exist on database',
            ], 404);
        }

        return response()->json([
            'status'=> 'success',
            'data'=> $task,
        ], 200);
    }
}
