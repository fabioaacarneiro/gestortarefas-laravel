<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;

class Main extends Controller
{
    /**
     * main page
     */
    public function index()
    {

        $data = [
            'title' => 'Gestor de Tarefas',
            'tasks' => Task::getTasks(),
            'datatables' => true,
        ];
        // 'tasks' => $this->_get_tasks(),

        return view('pages.main.index', $data);
    }

    /**
     * login page
     */
    public function login()
    {
        $data = [
            'title' => 'Login',
        ];
        return view('pages.login', $data);
    }

    /**
     * submit to login
     */
    public function loginSubmit(Request $request)
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
                return redirect()->route('main.index');
            }
        }

        // invalid login
        return redirect()->route('main.login')->with('login_error', 'Login inválido');

    }

    /**
     * logout submit
     */
    public function logout()
    {
        session()->forget('username');
        return redirect()->route('main.login');
    }

}
