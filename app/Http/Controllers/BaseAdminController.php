<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaseAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    protected function guard()
    {
        return Auth::guard('admin');
    }
}
