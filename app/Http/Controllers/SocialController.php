<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;

class SocialController extends Controller
{
    public function getInfo($social){
         return Socialite::driver($social)->redirect();
    }
    public function checkInfo($social){
        $user=Socialite::driver($social)->user();
        dd($user->getEmail());
    }
}
