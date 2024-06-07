<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Main extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('task.userhome');
        }

        $data = [
            'title' => 'RamTask',
        ];

        return view('pages.home', $data);
    }

    public function resources()
    {
        $data = [
            'title' => 'RamTask',
        ];

        return view('pages.resources', $data);
    }

    public function contact()
    {
        $data = [
            'title' => 'RamTask',
        ];

        return view('pages.contact', $data);
    }

    public function developer()
    {
        $data = [
            'title' => 'RamTask',
        ];

        return view('pages.about_developer', $data);
    }
}
