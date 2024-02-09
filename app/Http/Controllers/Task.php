<?php

namespace App\Http\Controllers;

use App\Models\TasklistModel;
use App\Models\TaskModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Task extends Controller
{

    /**
     * TODO: - implementar campo "obervação" para adicionar nas tarefas.
     */

    /**
     * task index
     */
    public function index($tasklistId, $filter = 'all')
    {

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $tasklist = TasklistModel::where('id', $tasklistId)->first();
        $amountOfCompletedTasks = TaskModel::where('tasklist_id', $tasklistId)
            ->where('status', 'completed')
            ->count();

        ['lvl' => $lvl, 'exp' => $exp] = Task::getLevelAndExp($amountOfCompletedTasks);

        $data = [
            'title' => 'Minhas Tarefas',
            'datatables' => false,
            'tasks' => Task::getTasks($tasklistId, $filter),
            'filter' => $filter,
            'user_id' => Auth::user()->id,
            'tasklist_id' => $tasklistId,
            'tasklist_name' => $tasklist->name,
            'user_level' => $lvl,
            'user_experience' => $exp,
            'user_name' => Auth::user()->name,
        ];

        return view('pages.main.index', $data);
    }

    /**
     * submit a new task
     */
    public function newTask($tasklistId, Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:200',
            'description' => 'max:1000',
        ], [
            'name.required' => 'O campo é obrigatório.',
            'name.min' => 'O campo deve ter no mínimo :min caracteres.',
            'name.max' => 'O campo deve ter no máximo :max caracteres.',
            'description.max' => 'O campo deve ter no máximo :max caracteres.',
        ]);

        // get form data
        $name = $request->input('name');
        $description = $request->input('description');

        // check if there is already another task with same name for the same user
        $task = TaskModel::where('tasklist_id', $tasklistId)
            ->where('name', $name)
            ->whereNull('deleted_at')
            ->first();

        if ($task) {
            return redirect()
                ->back()
                ->withInput()
                ->with('task_error', 'Já existe uma tarefa com este nome');
        }

        TaskModel::create([
            'tasklist_id' => $tasklistId,
            'name' => $name,
            'description' => $description,
            'status' => 'new',
            'commentary' => null,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return back();
    }

    /**
     * edit a task
     */

    public function editTask($tasklistId, Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:200',
            'description' => 'max:1000',
        ], [
            'name.required' => 'O campo é obrigatório.',
            'name.min' => 'O campo deve ter no mínimo :min caracteres.',
            'name.max' => 'O campo deve ter no máximo :max caracteres.',
            'description.max' => 'O campo deve ter no máximo :max caracteres.',
        ]);

        $id = $request->id;
        $name = $request->input('name');
        $description = $request->input('description');
        $status = $request->input('status');

        // check if there is another task with the same name and from the same user
        $taskToCheckDuplicate = TaskModel::where('tasklist_id', $tasklistId)
            ->where('name', $name)
            ->where('id', '!=', $id)
            ->whereNull('deleted_at')
            ->first();

        if ($taskToCheckDuplicate) {
            return redirect()
                ->route('task.edit', $id)
                ->withInput()
                ->with('task_error', 'Já existe outra tarefa com o mesmo nome.');
        }

        // update the task
        TaskModel::where('id', $id)->update([
            'name' => $name,
            'description' => $description,
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return back();
    }

    /**
     * delete a task
     */
    public function deleteTask($tasklistId, $id)
    {
        try {
            TaskModel::where('id', $id)
                ->where('tasklist_id', $tasklistId)
                ->delete();

        } catch (Exception $e) {
            return redirect()->route('task.index');
        }

        return back();
    }

    /**
     * search and sort
     */
    public function searchTask($tasklistId, $search = null)
    {
        $tasks = [];
        $tasklist = TasklistModel::where('id', $tasklistId)->first();
        $amountOfCompletedTasks = TaskModel::where('tasklist_id', $tasklistId)
            ->where('status', 'completed')
            ->count();

        ['lvl' => $lvl, 'exp' => $exp] = Task::getLevelAndExp($amountOfCompletedTasks);

        // get tasks
        if ($search) {
            $allTasks = TaskModel::where('tasklist_id', $tasklistId)
                ->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%')
                        ->orderBy('created_at', 'DESC');
                })->whereNull('deleted_at')
                ->get();

            foreach ($allTasks as $task) {

                $tasks[] = [
                    'id' => $task['id'],
                    'name' => $task['name'],
                    'description' => $task['description'],
                    'status' => Task::statusName($task['status']),
                    'status_style' => Task::statusBadge($task->status),
                    'tasklist_id' => $task->tasklist_id,
                    'commentary' => $task->commentary,
                ];
            }

        } else {
            $tasks = Task::getTasks($tasklistId);
        }

        $data = [
            'title' => 'Minhas Tarefas',
            'datatables' => false,
            'user_name' => Auth::user()->name,
            'tasklist_name' => $tasklist->name,
            'tasklist_id' => $tasklistId,
            'user_level' => $lvl,
            'user_experience' => $exp,
            'tasks' => $tasks,
        ];

        return view('pages.main.index', $data);

    }

    public function setCommentary($taskId, Request $request)
    {
        $newCommentary = $request->input('commentary');

        try {
            TaskModel::where('id', $taskId)->update([
                'commentary' => $newCommentary,
            ]);
        } catch (\Throwable $th) {
            $th->getMessage();
            dd($taskId);
        }

        return back();
    }

    /**
     * get task from database
     */
    private static function getTasks($id = null, $filter = 'all')
    {
        $tasks = [];
        $userId = Auth::user()->id;

        if ($filter != 'all' && $id != null) {
            $allTasks = TaskModel::where('tasklist_id', $id)
                ->where('status', $filter)
                ->orderBy('created_at', 'DESC')
                ->whereNull('deleted_at')
                ->get();

        } else {
            $allTasks = TaskModel::where('tasklist_id', $id)
                ->orderBy('created_at', 'DESC')
                ->whereNull('deleted_at')
                ->get();
        }

        foreach ($allTasks as $task) {

            // $link_edit = '<a href="' . route('task.edit', ['id' => Crypt::encrypt($task->id)]) . '" class="btn btn-secondary m-1"><i class="bi bi-pencil-square"></i></a>';
            // $link_delete = '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-trash"></button>';
            // $link_delete = '<a href="' . route('task.delete', ['id' => Crypt::encrypt($task->id)]) . '" class="btn btn-secondary m-1"  data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-trash"></i></a>';

            $tasks[] = [
                'id' => $task->id,
                'name' => $task->name,
                'description' => $task->description,
                'status' => Task::statusName($task->status),
                'status_style' => Task::statusBadge($task->status),
                'tasklist_id' => $task->tasklist_id,
                'commentary' => $task->commentary,
                'user_id' => $userId,
                // 'task_actions' => $link_edit . $link_delete,
            ];
        }

        return $tasks;
    }

    /**
     * private methods
     */

    private static function statusName($status)
    {
        $status_collection = [
            'all' => 'Minhas Tarefas',
            'new' => 'Nova',
            'in_progress' => 'Em progresso',
            'cancelled' => 'Cancelada',
            'completed' => 'Concluída',
        ];

        if (key_exists($status, $status_collection)) {
            return $status_collection[$status];
        } else {
            return 'Desconhecido';
        }
    }

    private static function statusBadge($status)
    {
        $status_collection = [
            'new' => 'badge bg-success',
            'in_progress' => 'badge bg-info',
            'cancelled' => 'badge bg-danger',
            'completed' => 'badge bg-secondary',
        ];

        if (key_exists($status, $status_collection)) {
            return $status_collection[$status];
        } else {
            return 'badge bg-secondary';
        }
    }

    public static function getLevelAndExp($completedTasksAmount)
    {
        $lvl = (int) ($completedTasksAmount / 100) + 1;
        $exp = $completedTasksAmount % 100;

        return ['lvl' => $lvl, 'exp' => $exp];
    }
}
