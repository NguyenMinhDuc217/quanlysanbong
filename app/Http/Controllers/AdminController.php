<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
       parent::middleware('admin');
    }
    public function index(){
        return view('layouts.admin');
    }
}
