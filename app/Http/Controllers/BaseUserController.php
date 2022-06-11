<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaseUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user');
    }
    
    protected function guard()
    {
        return Auth::guard('user');
    }

    protected function user()
    {
        return $this->guard()->user();
    }
}
