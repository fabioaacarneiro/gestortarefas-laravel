<?php

namespace App\Http\Controllers;

use App\Models\TaskModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class Task extends Controller
{
    /**
     * task index
     */
    public function index()
    {
        $data = [
            'title' => 'Minhas Tarefas',
            'datatables' => false,
            'tasks' => self::getTasks(),
        ];

        return view('pages.main.index', $data);
    }

    /**
     * new task verb get
     */
    public function newTask()
    {
        $data = [
            'title' => 'Nova tarefa',
        ];

        return view('pages.task.new_task', $data);
    }

    /**
     * submit a new task
     */
    public function newTaskSubmit(Request $request)
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

        $new_task = new TaskModel;

        $new_task->id_user = session('id');
        $new_task->task_name = $task_name;
        $new_task->task_description = $task_description;
        $new_task->task_status = 'new';
        $new_task->created_at = date('Y-m-d H:i:s');
        $new_task->save();

        return redirect()->route('task.index');
    }

    /**
     * edit a task
     */

    public function editTask($id)
    {
        try {
            $decrypted_id = Crypt::decrypt($id);
        } catch (Exception $e) {
            return redirect()->route('index');
        }

        // get tast data
        $task = TaskModel::where('id', $decrypted_id)->first();

        // check if task exists
        if (empty($task)) {
            return redirect()->route('index');
            echo 'não existe esta task';
        }

        $data = [
            'title' => 'Editar tarefa',
            'task' => $task,
        ];

        return view('pages.task.edit_task', $data);

    }

    /**
     * submit for edit the task
     */
    public function editTaskSubmit(Request $request)
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

        // get form data
        try {
            $decrypted_id = Crypt::decrypt($request->input('task_id'));
        } catch (Exception $e) {
            return redirect()->route('task.index');
        }

        $task_name = $request->input('text_task_name');
        $task_description = $request->input('text_task_description');
        $task_status = $request->input('text_task_status');

        // check if there is another task with the same name and from the same user
        $task = TaskModel::where('id_user', session('id'))
            ->where('task_name', $task_name)
            ->where('id', '!=', $decrypted_id)
            ->whereNull('deleted_at')
            ->first();

        if ($task) {
            return redirect()
                ->route('task.edit', ['id' => Crypt::encrypt($decrypted_id)])
                ->with('task_error', 'Já existe outra tarefa com o mesmo nome.');
        }

        // update the task
        TaskModel::where('id', $decrypted_id)
            ->update([
                'task_name' => $task_name,
                'task_description' => $task_description,
                'task_status' => $task_status,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

        return redirect()->route('task.index');

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

        $task = TaskModel::where('id', $decrypted_id)->first();

        if (!$task) {
            return redirect()->route('task.index');
        }

        $data = [
            'title' => 'Excluir Tarefa',
            'task' => $task,
        ];

        return $data;
    }

    /**
     * confirm delete a task
     */
    public function deleteTaskConfirm($id)
    {
        try {
            $decrypted_id = Crypt::decrypt($id);

        } catch (Exception $e) {
            return redirect()->route('task.index');
        }

        TaskModel::where('id', $decrypted_id)
            ->update(['deleted_at' => date('Y-m-d H:i:s')]);

        return redirect()->route('task.index');

    }

    /**
     * search and sort
     */
    public function searchSubmit(Request $request)
    {
        // get data from form
        $search = $request->input('text_search');

        // get tasks
        // $model = new TaskModel();

        if ($search == '') {
            $tasks = TaskModel::where('id_user', session('id'))
                ->whereNull('deleted_at')
                ->get();
        } else {

            $tasks = TaskModel::where('id_user', session('id'))
                ->where(function ($query) use ($search) {
                    $query->where('task_name', 'like', '%' . $search . '%')
                        ->orWhere('task_description', 'like', '%' . $search . '%');
                })->whereNull('deleted_at')
                ->get();

        }

        session()->put('tasks', $tasks);
        session()->put('search', $search);

        return redirect()->route('main.index');
    }

    public function filter($status)
    {
        // decrypt status
        try {
            $decrypted_status = Crypt::decrypt($status);
        } catch (Exception $e) {
            return redirect()->route('index');
        }

        // get tasks
        if ($decrypted_status == 'all') {
            $tasks = TaskModel::where('id_user', session('id'))
                ->whereNull('deleted_at')
                ->get();
        } else {
            $tasks = TaskModel::where('id_user', session('id'))
                ->where('task_status', $decrypted_status)
                ->whereNull('deleted_at')
                ->get();
        }

        return redirect()->route('main.index', $tasks);
    }

    private static function getTasks($status = null)
    {
        $tasks = [];

        // check there is a search
        if ($status) {
            $allTasks = TaskModel::where('id_user', session('id'))
                ->where('task_status', $status)
                ->whereNull('deleted_at')
                ->get();

        } else {
            $allTasks = TaskModel::where('id_user', session('id'))
                ->whereNull('deleted_at')
                ->get();
        }

        foreach ($allTasks as $task) {

            // $link_edit = '<a href="' . route('task.edit', ['id' => Crypt::encrypt($task->id)]) . '" class="btn btn-secondary m-1"><i class="bi bi-pencil-square"></i></a>';
            // $link_delete = '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-trash"></button>';
            // $link_delete = '<a href="' . route('task.delete', ['id' => Crypt::encrypt($task->id)]) . '" class="btn btn-secondary m-1"  data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-trash"></i></a>';

            $tasks[] = [
                // 'task_name' => $task->task_name,
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
            'new' => 'Nova',
            'in_progress' => 'Em progresso',
            'cancelled' => 'Cancelada',
            'completed' => 'Concluída',
        ];

        // if (key_exists($status, $status_collection)) {
        //     return '<span class="' . Task::statusBadge($status) . '">' . $status_collection[$status] . '</span>';
        // } else {
        //     return '<span class="' . Task::statusBadge('Desconhecido') . '">Desconhecido</span>';
        // }

        if (key_exists($status, $status_collection)) {
            return $status_collection[$status];
        } else {
            return 'Desconhecido';
        }
    }

    private static function statusBadge($status)
    {
        $status_collection = [
            'new' => 'badge bg-primary',
            'in_progress' => 'badge bg-success',
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
