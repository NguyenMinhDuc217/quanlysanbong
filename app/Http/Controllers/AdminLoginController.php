<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminLoginController extends Controller
{
    public function showLoginForm(){
        return view('admin.login.login');
    }
}
