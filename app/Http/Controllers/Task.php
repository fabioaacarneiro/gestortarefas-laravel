<?php

namespace App\Http\Controllers;

use App\Models\TaskModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class Task extends Controller
{

    /**
     * TODO: - implementar campo "obervação" para adicionar nas tarefas.
     */

    /**
     * task index
     */
    public function index($filter = 'all')
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $data = [
            'title' => 'Minhas Tarefas',
            'datatables' => false,
            'tasks' => Task::getTasks($filter),
            'filter' => $filter,
            'name' => Auth::user()->name,
        ];

        return view('pages.main.index', $data);
    }

    /**
     * submit a new task
     */
    public function newTask(Request $request)
    {
        $request->validate([
            'text_task_name' => 'required|min:3|max:200',
            'text_task_description' => 'required|min:3|max:1000',
        ], [
            'text_task_name.required' => 'O campo é obrigatório.',
            'text_task_name.min' => 'O campo deve ter no mínimo :min caracteres.',
            'text_task_name.max' => 'O campo deve ter no máximo :max caracteres.',
            'text_task_description.required' => 'O campo é obrigatório',
            'text_task_description.min' => 'O campo deve ter no mínimo :min caracteres.',
            'text_task_description.max' => 'O campo deve ter no máximo :max caracteres.',
        ]);

        // get form data
        $task_name = $request->input('text_task_name');
        $task_description = $request->input('text_task_description');
        $task_status = $request->input('text_task_status');

        // check if there is already another task with same name for the same user
        $task = TaskModel::where('id_user', session('id'))
            ->where('task_name', $task_name)
            ->whereNull('deleted_at')
            ->first();

        if ($task) {
            return redirect()
                ->route('task.new')
                ->withInput()
                ->with('task_error', 'Já existe uma tarefa com este nome');
        }

        TaskModel::create([
            'id_user' => session('id'),
            'task_name' => $task_name,
            'task_description' => $task_description,
            'task_status' => $task_status,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('task.index');
    }

    /**
     * edit a task
     */

    public function editTask(Request $request)
    {
        $request->validate([
            'text_task_name' => 'required|min:3|max:200',
            'text_task_description' => 'required|min:3|max:1000',
            'text_task_status' => 'required',
        ], [
            'text_task_name.required' => 'O campo é obrigatório.',
            'text_task_name.min' => 'O campo deve ter no mínimo :min caracteres.',
            'text_task_name.max' => 'O campo deve ter no máximo :max caracteres.',
            'text_task_description.required' => 'O campo é obrigatório',
            'text_task_description.min' => 'O campo deve ter no mínimo :min caracteres.',
            'text_task_description.max' => 'O campo deve ter no máximo :max caracteres.',
            'text_task_status.required' => 'O campo é obrigatório',
        ]);

        $task_id = $request->task_id;
        $task_name = $request->input('text_task_name');
        $task_description = $request->input('text_task_description');
        $task_status = $request->input('text_task_status');

        // check if there is another task with the same name and from the same user
        $task = TaskModel::where('id_user', session('id'))
            ->where('task_name', $task_name)
            ->where('id', '!=', $task_id)
            ->whereNull('deleted_at')
            ->first();

        if ($task) {
            return redirect()
                ->route('task.edit', $task_id)
                ->with('task_error', 'Já existe outra tarefa com o mesmo nome.');
        }

        // update the task
        TaskModel::where('id', $task_id)
            ->update([
                'task_name' => $task_name,
                'task_description' => $task_description,
                'task_status' => $task_status,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

        return back();

    }

    /**
     * delete a task
     */
    public function deleteTask($id)
    {
        try {
            $decrypted_id = Crypt::decrypt($id);

        } catch (Exception $e) {
            return redirect()->route('task.index');
        }

        TaskModel::where('id', $decrypted_id)
            ->delete();

        return back();

    }

    /**
     * search and sort
     */
    public function searchTask($search = null)
    {
        $tasks = [];

        // get tasks
        if ($search) {
            $allTasks = TaskModel::where('id_user', session('id'))
                ->where(function ($query) use ($search) {
                    $query->where('task_name', 'like', '%' . $search . '%')
                        ->orWhere('task_description', 'like', '%' . $search . '%');
                })->whereNull('deleted_at')
                ->get();

            foreach ($allTasks as $task) {

                $tasks[] = [
                    'task_id' => $task['id'],
                    'task_name' => $task['task_name'],
                    'task_description' => $task['task_description'],
                    'task_status' => Task::statusName($task['task_status']),
                    'task_status_style' => Task::statusBadge($task['task_status']),
                ];
            }

        } else {
            $tasks = Task::getTasks();
        }

        $data = [
            'title' => 'Minhas Tarefas',
            'datatables' => false,
            'tasks' => $tasks,
        ];

        return view('pages.main.index', $data);

    }

    /**
     * get task from database
     */
    private static function getTasks($filter = 'all')
    {
        $tasks = [];

        if ($filter != 'all') {
            $allTasks = TaskModel::where('id_user', session('id'))
                ->where('task_status', $filter)
                ->whereNull('deleted_at')
                ->get();

        } else {
            $allTasks = TaskModel::where('id_user', session('id'))->get();
        }

        foreach ($allTasks as $task) {

            // $link_edit = '<a href="' . route('task.edit', ['id' => Crypt::encrypt($task->id)]) . '" class="btn btn-secondary m-1"><i class="bi bi-pencil-square"></i></a>';
            // $link_delete = '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-trash"></button>';
            // $link_delete = '<a href="' . route('task.delete', ['id' => Crypt::encrypt($task->id)]) . '" class="btn btn-secondary m-1"  data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-trash"></i></a>';

            $tasks[] = [
                'task_id' => $task->id,
                'task_name' => $task->task_name,
                'task_description' => $task->task_description,
                'task_status' => Task::statusName($task->task_status),
                'task_status_style' => Task::statusBadge($task->task_status),
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
}
