<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseUserController;

class TestController extends BaseUserController
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index(){
        return view('welcome');
    }
}
