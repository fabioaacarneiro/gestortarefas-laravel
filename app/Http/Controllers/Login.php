<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;

class Login extends Controller
{
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
            'username' => 'required|min:3',
            'password' => 'required|min:3',
        ], [
            'username.required' => 'O campo é obrigatório.',
            'username.min' => 'O campo deve ter no mínimo :min caracteres.',
            'password.required' => 'O campo é obrigatório',
            'password.min' => 'O campo deve ter no mínimo :min caracteres.',
        ]);

        // get form data
        $username = $request->input('username');
        $password = $request->input('password');

        // check this user on database
        $user = UserModel::where('username', $username)
            ->whereNull('deleted_at')
            ->get()
            ->first();

        if ($user->username) {
            if (password_verify($password, $user->password)) {
                session()->put([
                    'id' => $user->id,
                    'username' => $user->username,
                ]);
                return redirect()->route('task.index');
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
        session()->flush();
        return redirect()->route('login');
    }

}
