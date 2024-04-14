<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Main extends Controller
{
    public function index()
    {
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
}
