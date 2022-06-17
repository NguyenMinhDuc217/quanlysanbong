<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\AbstractProvider;

class GoogleController extends Controller
{
    public function loginUsingGoogle(Request $request){
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request){

        $userdata = Socialite::driver('google')->user();
        $user=User::where('email',$userdata->email)->first;
        if($user){
            Auth::login($user);
            return redirect()->route('list_pitch');
        }else{
            return redirect()->route('show.login');
        }

    }
}
