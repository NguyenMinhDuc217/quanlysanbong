<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageManagerController extends Controller
{
    public function fileManager(){
        return view('admin.image.image');
    }
}
