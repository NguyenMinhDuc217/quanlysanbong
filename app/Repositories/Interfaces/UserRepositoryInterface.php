<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;

interface UserRepositoryInterface
{
 public function register(Request $request);
}