<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SocialAccountService;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\Pitchs;
use App\Models\Social;
class SocialController extends Controller
{
    public function getInfo($social){
         return Socialite::driver($social)->redirect();
    }
    public function checkInfo($social){
        $user = SocialAccountService::createOrGetUser(Socialite::driver($social)->user(), $social);
        $socials=Social::where('user_id',$user->id)->where('provider',$social)->first();
          if(Auth::guard('user')->attempt(['email' => $user->email, 'password' => $socials->provider_user_id,'status'=>1])){
             $pitchs = Pitchs::orderby('average_rating','DESC')->where('status',1)->paginate(8)->appends(request()->query());
               return view('pitchs.index', compact('pitchs'));  
          }else{
             return redirect()->route('show.login');  
          }
    }
}
