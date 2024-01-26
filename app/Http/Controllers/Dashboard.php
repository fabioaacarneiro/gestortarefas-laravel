<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'datatables' => false,
            'name' => Auth::user()->name,
        ];

        return view('pages.dashboard', $data);
    }
}
