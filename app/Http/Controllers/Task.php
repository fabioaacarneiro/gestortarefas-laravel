<?php

namespace App\Http\Controllers;

use App\Models\TasklistModel;
use App\Models\TaskModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Task extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return route('pages.userhome');
    }

    public function userhome()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $amountOfCompletedTasks = TaskModel::where('status', 'completed')->count();

        ['lvl' => $lvl, 'exp' => $exp] = Task::getLevelAndExp($amountOfCompletedTasks);

        $tasks = TaskModel::where('user_id', Auth::user()->id)
            ->where('tasklist_id', null)
            ->orderBy('created_at', 'DESC')
            ->take(5)
            ->get();

        // dd($tasks);

        $lists = TasklistModel::where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'DESC')
            ->take(15)
            ->get();

        $status = ["completed", "cancelled", "in_progress", "new", "total"];

        foreach ($lists as $list) {
            foreach ($status as $value) {

                if ($value == "total") {
                    $list[$value] = TaskModel::where('tasklist_id', $list->id)->count();
                } else {

                    $list[$value] = TaskModel::where('tasklist_id', $list->id)
                        ->where('status', $value)->count();
                }
            }
        }

        $data = [
            'title' => 'Página do Usuário',
            'user_id' => Auth::user()->id,
            'tasks' => $tasks,
            'lists' => $lists,
            'user_level' => $lvl,
            'user_experience' => $exp,
            'user_name' => Auth::user()->name,
        ];

        return view('pages.userhome', $data);
    }

    public function searchTaskWithList($tasklistId = null, $search = 'all')
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // dd($tasklistId, $search);

        $tasklist = TasklistModel::where('id', $tasklistId)->first();
        $tasks = Task::getTasksBySearch(userId: Auth::user()->id, tasklistId: $tasklistId, search: $search);

        ['lvl' => $lvl, 'exp' => $exp] = Task::getLevelAndExp(Task::getCompletedTasks());

        $data = [
            'title' => 'Minhas Tarefas',
            'tasks' => $tasks,
            // 'filter' => $filter,
            'user_id' => Auth::user()->id,
            'list_id' => $tasklistId,
            'list_name' => $tasklist->name,
            'list_description' => $tasklist->description,
            'user_level' => $lvl,
            'user_experience' => $exp,
            'user_name' => Auth::user()->name,
        ];

        return view('pages.user.tasksWithList', $data); // mostra as tarefas escolhidas
    }

    public function filterTaskWithList($tasklistId = null, $filter = 'all')
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // dd($tasklistId, $search);

        $tasklist = TasklistModel::where('id', $tasklistId)->first();
        $tasks = Task::getTaskByFilter($tasklistId, $filter);

        ['lvl' => $lvl, 'exp' => $exp] = Task::getLevelAndExp(Task::getCompletedTasks());

        $data = [
            'title' => 'Minhas Tarefas',
            'tasks' => $tasks,
            'filter' => $filter,
            'user_id' => Auth::user()->id,
            'list_id' => $tasklistId,
            'list_name' => $tasklist->name,
            'list_description' => $tasklist->description,
            'user_level' => $lvl,
            'user_experience' => $exp,
            'user_name' => Auth::user()->name,
        ];

        return view('pages.user.tasksWithList', $data); // mostra as tarefas escolhidas
    }


    public function tasks(string $filter = 'all')
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $amountOfCompletedTasks = TaskModel::where('status', 'completed')->count();

        ['lvl' => $lvl, 'exp' => $exp] = Task::getLevelAndExp($amountOfCompletedTasks);

        $tasks = Task::getTasksBySearch(userId: Auth::user()->id, tasklistId: null, search: $filter);

        $data = [
            'title' => 'Minhas Tarefas',
            'tasks' => $tasks,
            'filter' => $filter,
            'user_id' => Auth::user()->id,
            'list_name' => 'Tarefas sem lista',
            'list_id' => '',
            'user_level' => $lvl,
            'user_experience' => $exp,
            'user_name' => Auth::user()->name,
        ];

        return view('pages.user.tasks', $data);
    }

    /**
     * submit a new task
     */
    public function newTaskWithList($tasklistId, Request $request)
    {
        $request->validate([
            'name' => 'required|unique:tasks|min:3|max:200',
            'description' => 'max:1000',
        ], [
            'name.required' => 'O campo é obrigatório.',
            'name.unique' => 'Já existe uma tarefa com este nome.',
            'name.min' => 'O campo deve ter no mínimo :min caracteres.',
            'name.max' => 'O campo deve ter no máximo :max caracteres.',
            'description.max' => 'O campo deve ter no máximo :max caracteres.',
        ]);

        TaskModel::create([
            'tasklist_id' => $tasklistId,
            'name' => $request->input('name'),
            'user_id' => Auth::user()->id,
            'description' => $request->input('description'),
            'status' => 'new',
            'commentary' => null,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return back();
    }

    /**
     * submit a new task
     */
    public function newTask(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:tasks|min:3|max:200',
            'description' => 'max:1000',
        ], [
            'name.required' => 'O campo é obrigatório.',
            'name.unique' => 'Já existe uma tarefa com este nome.',
            'name.min' => 'O campo deve ter no mínimo :min caracteres.',
            'name.max' => 'O campo deve ter no máximo :max caracteres.',
            'description.max' => 'O campo deve ter no máximo :max caracteres.',
        ]);

        TaskModel::create([
            'tasklist_id' => null,
            'name' => $request->input('name'),
            'user_id' => Auth::user()->id,
            'description' => $request->input('description'),
            'status' => 'new',
            'commentary' => null,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return back();
    }

    /**
     * edit a task
     */

    public function editTask($taskId, Request $request)
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

        // update the task
        TaskModel::where('id', $request->id)
            ->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'status' => $request->input('status'),
                'tasklist_id' => $request->input('list') === 'null' ? null : $request->input('list'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

        return back();
    }

    /**
     * edit a task in list
     *
     * @param $list_id
     * @param Request $request
     * @return void
     */
    public function editTaskWithList($list_id, Request $request)
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

        // update the task
        TaskModel::where('id', $request->id)
            ->where('tasklist_id', $list_id)
            ->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'status' => $request->input('status'),
                'tasklist_id' => $request->input('list') === 'null' ? null : $request->input('list'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

        return back();
    }

    /**
     * delete a task in list
     *
     * @param $tasklistId
     * @param $id
     * @return void
     */
    public function deleteTaskWithList($tasklistId, $id)
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
     * delete task without list
     *
     * @param $id
     * @return void
     */
    public function deleteTask($id)
    {
        try {
            TaskModel::find($id)->delete();
        } catch (Exception $e) {
            return redirect()->route('task.index');
        }

        return back();
    }

    /**
     * search task based a text
     *
     * @param string $search
     * @return void
     */
    public function searchTask($search = 'all')
    {
        $tasks = Task::getTasksBySearch(null, $search);

        // dd($tasks);
        ['lvl' => $lvl, 'exp' => $exp] = Task::getLevelAndExp(Task::getCompletedTasks());

        $data = [
            'title' => 'Minhas Tarefas',
            'datatables' => false,
            'user_name' => Auth::user()->name,
            'list_name' => 'Tarefas sem lista',
            // 'list_id' => $tasklistId,
            'user_level' => $lvl,
            'user_experience' => $exp,
            'tasks' => $tasks,
        ];

        return view('pages.user.tasks', $data);
    }


    /**
     * search task based a text
     *
     * @param string $search
     * @return void
     */
    public function filterTask($filter = 'all')
    {
        $tasks = Task::getTaskByFilter(null, $filter);

        // dd($tasks);
        ['lvl' => $lvl, 'exp' => $exp] = Task::getLevelAndExp(Task::getCompletedTasks());

        $data = [
            'title' => 'Minhas Tarefas',
            'datatables' => false,
            'user_name' => Auth::user()->name,
            'list_name' => 'Tarefas sem lista',
            'filter' => $filter,
            'user_level' => $lvl,
            'user_experience' => $exp,
            'tasks' => $tasks,
        ];

        return view('pages.user.tasks', $data);
    }

    /**
     * update commentary of task
     *
     * @param $taskId
     * @param Request $request
     * @return void
     */
    public function setCommentaryTask($taskId, Request $request)
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
     * search tasks based in text
     *
     * @param $tasklist_id
     * @param string $filter
     */
    private static function getTaskByFilter($tasklist_id = null, string $filter = 'all')
    {
        $tasks = [];
        $allTasks = [];

        ['lvl' => $lvl, 'exp' => $exp] = Task::getLevelAndExp(Task::getCompletedTasks());

        if ($filter != 'all') {
            $allTasks = TaskModel::where('tasklist_id', $tasklist_id)
                ->where('status', $filter)
                ->orderBy('created_at', 'DESC')
                ->whereNull('deleted_at')
                ->get();
        } else {
            $allTasks = TaskModel::where('tasklist_id', $tasklist_id)
                ->orderBy('created_at', 'DESC')
                ->whereNull('deleted_at')
                ->get();
        }

        foreach ($allTasks as $task) {

            $tasks[] = [
                'id' => $task->id,
                'name' => $task->name,
                'description' => $task->description,
                'status' => Task::statusName($task->status),
                'status_style' => Task::statusBadge($task->status),
                'tasklist_id' => $task->tasklist_id,
                'commentary' => $task->commentary,
                'user_id' => Auth::user()->id,
                // 'task_actions' => $link_edit . $link_delete,
            ];
        }

        return $tasks;
    }

    /**
     * get task from database
     */
    private static function getTasksBySearch($userId = null, $tasklistId = null, $search = 'all')
    {

        $tasks = [];
        $allTasks = [];
        // get tasks

        if ($search != 'all') {
            $allTasks = TaskModel::where('user_id', $userId)
                ->where('tasklist_id', $tasklistId)
                ->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%')
                        ->orderBy('created_at', 'DESC');
                })->whereNull('deleted_at')->get();
        } else {
            $allTasks = TaskModel::where('user_id', $userId)
                ->where('tasklist_id', $tasklistId)
                ->orderBy('created_at', 'DESC')
                ->whereNull('deleted_at')->get();
        }

        foreach ($allTasks as $task) {

            $tasks[] = [
                'id' => $task['id'],
                'name' => $task['name'],
                'description' => $task['description'],
                'status' => Task::statusName($task['status']),
                'status_style' => Task::statusBadge($task['status']),
                'tasklist_id' => $task['tasklist_id'],
                'user_id' => $task['user_id'],
                'commentary' => $task['commentary'],
            ];
        }

        return $tasks;
    }

    /**
     * private methods
     */

    private static function statusName(string $status): string
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

    private static function statusBadge(string $status): string
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

    static function getLevelAndExp(int $completedTasksAmount): array
    {
        $lvl = (int) ($completedTasksAmount / 100) + 1;
        $exp = $completedTasksAmount % 100;

        return ['lvl' => $lvl, 'exp' => $exp];
    }

    static function getCompletedTasks(): int
    {
        return TaskModel::where('user_id', Auth::user()->id)
            ->where('status', 'completed')
            ->count();
    }
}
