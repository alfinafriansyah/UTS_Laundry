<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffWelcomeController extends Controller
{
    public function index()
    {
        $activeMenu = 'dashboard';

        return view('staff.welcome', ['activeMenu' => $activeMenu]);
    }
}
