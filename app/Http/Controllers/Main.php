<?php

namespace App\Http\Controllers;

use App\Models\TaskModel;
use App\Models\UserModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class Main extends Controller
{
    /**
     * main page
     */
    public function index()
    {
        $data = [
            'title' => 'Gestor de Tarefas',
            'datatables' => true,
        ];
        // 'tasks' => $this->_get_tasks(),

        // check there is a search
        if (session('search')) {
            $data['search'] = session('search');
            $data['tasks'] = $this->_get_tasks(session('tasks'));

            // cleaning session
            session()->forget('search');
            session()->forget('tasks');

        } else if (session('filter')) {
            $data['filter'] = session('filter');
            $data['tasks'] = $this->_get_tasks(session('tasks'));

            // cleaning session
            session()->forget('filter');
            session()->forget('tasks');

        } else {
            $tasks = TaskModel::where('id_user', session('id'))
                ->whereNull('deleted_at')
                ->get();

            $data['tasks'] = $this->_get_tasks($tasks);
        }

        return view('main', $data);
    }

    /**
     * login page
     */
    public function login()
    {
        $data = [
            'title' => 'Login',
        ];
        return view('login_frm', $data);
    }

    /**
     * submit to login
     */
    public function login_submit(Request $request)
    {
        // form validation
        $request->validate([
            'text_username' => 'required|min:3',
            'text_password' => 'required|min:3',
        ], [
            'text_username.required' => 'O campo é obrigatório.',
            'text_username.min' => 'O campo deve ter no mínimo :min caracteres.',
            'text_password.required' => 'O campo é obrigatório',
            'text_password.min' => 'O campo deve ter no mínimo :min caracteres.',
        ]);

        // get form data
        $username = $request->input('text_username');
        $password = $request->input('text_password');

        // check this user on database
        $user = UserModel::where('username', $username)
            ->whereNull('deleted_at')
            ->first();

        if ($user) {
            // check password is correct
            if (password_verify($password, $user->password)) {
                $session_data = [
                    'id' => $user->id,
                    'username' => $user->username,
                ];

                session()->put($session_data);
                return redirect()->route('index');
            }
        }

        // invalid login
        return redirect()->route('login')->with('login_error', 'Login inválido');

    }

    /**
     * logout submit
     */
    public function logout()
    {
        session()->forget('username');
        return redirect()->route('login');
    }

    /**
     * new task verb get
     */
    public function new_task()
    {
        $data = [
            'title' => 'Nova tarefa',
        ];

        return view('new_task_frm', $data);
    }

    /**
     * submit a new task
     */
    public function new_task_submit(Request $request)
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
                ->route('new_task')
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

        return redirect()->route('index');
    }

    /**
     * edit a task
     */

    public function edit_task($id)
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

        return view('edit_task_frm', $data);

    }

    /**
     * submit for edit the task
     */
    public function edit_task_submit(Request $request)
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
            return redirect()->route('index');
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
                ->route('edit_task', ['id' => Crypt::encrypt($decrypted_id)])
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

        return redirect()->route('index');

    }

    /**
     * delete a task
     */
    public function delete_task($id)
    {
        try {
            $decrypted_id = Crypt::decrypt($id);
        } catch (Exception $e) {
            return redirect()->route('index');
        }

        $task = TaskModel::where('id', $decrypted_id)->first();

        if (!$task) {
            return redirect()->route('index');
        }

        $data = [
            'title' => 'Excluir Tarefa',
            'task' => $task,
        ];

        return view('delete_task', $data);
    }

    /**
     * confirm delete a task
     */
    public function delete_task_confirm($id)
    {
        try {
            $decrypted_id = Crypt::decrypt($id);
        } catch (Exception $e) {
            return redirect()->route('index');
        }

        TaskModel::where('id', $decrypted_id)
            ->update(['deleted_at' => date('Y-m-d H:i:s')]);

        return redirect()->route('index');
    }

    /**
     * search and sort
     */
    public function search_submit(Request $request)
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

        return redirect()->route('index');
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

        session()->put('tasks', $tasks);
        session()->put('filter', $decrypted_status);

        return redirect()->route('index');
    }

    /**
     * private methods
     */
    private function _get_tasks($tasks)
    {

        $collection = [];
        foreach ($tasks as $task) {

            $link_edit = '<a href="' . route('edit_task', ['id' => Crypt::encrypt($task->id)]) . '" class="btn btn-secondary m-1"><i class="bi bi-pencil-square"></i></a>';
            $link_delete = '<a href="' . route('delete_task', ['id' => Crypt::encrypt($task->id)]) . '" class="btn btn-secondary m-1"><i class="bi bi-trash"></i></a>';

            $collection[] = [
                // 'task_name' => $task->task_name,
                'task_name' => '<span class="task-title">' . $task->task_name . '</span><br><small class="opacity-50">' . $task->task_description . '</small>',
                'task_status' => $this->_status_name($task->task_status),
                'task_actions' => $link_edit . $link_delete,
            ];
        }

        return $collection;
    }

    private function _status_name($status)
    {
        $status_collection = [
            'new' => 'Nova',
            'in_progress' => 'Em progresso',
            'cancelled' => 'Cancelada',
            'completed' => 'Concluída',
        ];

        if (key_exists($status, $status_collection)) {
            return '<span class="' . $this->_status_badge($status) . '">' . $status_collection[$status] . '</span>';
        } else {
            return '<span class="' . $this->_status_badge('Desconhecido') . '">Desconhecido</span>';
        }
    }

    private function _status_badge($status)
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
