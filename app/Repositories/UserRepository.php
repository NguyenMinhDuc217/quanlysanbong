<?php

namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
 public function register(Request $request){
      dd($request->all());
     $user = User::create([
          'username' => $request->name,
          'email' => $request->email,
          'password' => bcrypt($request->password)
     ]);;
      return $user;
 }
}