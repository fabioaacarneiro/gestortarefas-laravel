<?php

namespace App\Http\Controllers;

use App\Utils\Authenticate;
use App\Utils\GoogleClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{

    /**
     * login page
     */
    public function login()
    {

        if (Auth::check()) {
            return redirect()->route('task.userhome');
        }

        if (session()->has("user")) {
            var_dump(session()->get("user")->email);
            // return redirect()->route('tasklist');
        }

        $googleCliente = new GoogleClient;
        $googleCliente->init();

        if ($googleCliente->authorized()) {
            $auth = new Authenticate();
            return $auth->authGoogle($googleCliente->getData());
        }

        $data = [
            'title' => 'Login',
            'authUrl' => $googleCliente->generateAuthLink(),
        ];

        return view('pages.login', $data);
    }

    /**
     * submit to login
     */
    public function loginSubmit(Request $request)
    {
        // form validation
        $credentials = $request->validate([
            'email' => 'required|min:3',
            'password' => 'required|min:3',
        ], [
            'email.required' => 'O campo é obrigatório.',
            'email.min' => 'O campo deve ter no mínimo :min caracteres.',
            'password.required' => 'O campo é obrigatório',
            'password.min' => 'O campo deve ter no mínimo :min caracteres.',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('task.userhome');
        }

        // invalid login
        return back()->withErrors('login_error', 'Login inválido')->onlyInput('username');
    }

    public function logout()
    {
        if (Auth::check()) {
            return redirect()->back();
        } else {
            return redirect()->route('login');
        }
    }

    /**
     * logout submit
     */
    public function logoutSubmit(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
