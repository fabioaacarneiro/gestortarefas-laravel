<?php

namespace App\Utils;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    public function authGoogle($data)
    {
        $userFound = User::where("email", $data->email)->first();

        if (!$userFound) {
            User::insert([
                "name" => $data->givenName,
                "lastName" => $data->familyName,
                "email" => $data->email,
                "avatar" => $data->picture,
                "password" => password_hash($data->id, PASSWORD_DEFAULT),
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
            ]);

            $userFound = User::where("email", $data->email)->first();
        }

        Auth::login($userFound);

        return redirect()->route("login");
    }
}
