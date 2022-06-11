<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserController extends Controller
{
    public $userRepository;
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function showRegister()
    { 
       return view('sign-up.index');
     }
    public function Register(Request $request){
        
       $this->userRepository->register($request);
    }
}
