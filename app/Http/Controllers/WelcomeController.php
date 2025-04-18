<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $activeMenu = 'dashboard';

        return view('admin.welcome', ['activeMenu' => $activeMenu]);
    }
}
