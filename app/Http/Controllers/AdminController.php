<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseAdminController;
use Illuminate\Http\Request;

class AdminController extends BaseAdminController
{
    public function __construct()
    {
       parent::__construct();
    }
    public function index(){
        return view('layouts.admin');
    }
}
