<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function sugnUpSubmit(Request $request)
    {

    }
}
