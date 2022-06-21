<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SocialAccountService;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class SocialController extends Controller
{
    public function getInfo($social){
         return Socialite::driver($social)->redirect();
    }
    public function checkInfo($social){
        $user = SocialAccountService::createOrGetUser(Socialite::driver($social)->user(), $social);
        Auth::guard('user')->login($user);
        return redirect()->intended(route('list_pitch'));
    }
}
