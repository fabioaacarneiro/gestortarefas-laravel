<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SignUp extends Controller
{
    public function signUp()
    {
        $data = [
            'title' => 'Cadastro',
            'datatables' => false,
        ];

        return view('pages.signup', $data);
    }

    public function signUpSubmit(Request $request)
    {

        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|same:email_confirm',
            'email_confirm' => 'required|same:email',
            'password' => 'required|min:3|same:password_confirm',
            'password_confirm' => 'required|min:3|same:password',
        ], [
            'name.required' => 'O campo é obrigatório.',
            'name.min' => 'O campo deve ter no mínimo :min caracteres.',

            'email.required' => 'O campo é obrigatório',
            'email.min' => 'O campo deve ter no mínimo :min caracteres.',
            'email.same' => 'E-Mail e a confirmação são diferentes',

            'email_confirm.min' => 'O campo deve ter no mínimo :min caracteres.',
            'email_confirm.required' => 'O campo é obrigatório',
            'email_confirm.same' => 'E-Mail e a confirmação são diferentes',

            'password.min' => 'O campo deve ter no mínimo :min caracteres.',
            'password.required' => 'O campo é obrigatório',
            'password.same' => 'A senha e a confirmação são diferentes',

            'password_confirm.min' => 'O campo deve ter no mínimo :min caracteres.',
            'password_confirm.required' => 'O campo é obrigatório',
            'password_confirm.same' => 'A senha e a confirmação são diferentes',
        ]);

        $newUser = [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'emailConfirm' => $request->get('email_confirm'),
            'password' => $request->get('password'),
            'passwordConfirm' => $request->get('password_confirm'),
        ];

        //  check if email has exists
        $user = UserModel::where('email', $request->get('email'))
            ->whereNull('deleted_at')
            ->first();

        if ($user) {
            return redirect()->back()
                ->withInput(['name', 'email', 'email_confirm'])
                ->with('signup_error', 'Já existe um usuário com esse "email"');
        } else {

            UserModel::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'level' => 1,
                'experience' => 0,
                'created_count' => 0,
                'deleted_count' => 0,
                'completed_count' => 0,
                'canceled_count' => 0,
                'list_created_count' => 0,
                'list_deleted_count' => 0,
                'password' => Hash::make($newUser['password']),
            ]);

            return redirect()->route('login')->with('signup_success', 'Conta cadastrada consucesso, redirecionando para o login');
        }

    }
}
