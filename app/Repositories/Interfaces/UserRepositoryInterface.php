<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;

interface UserRepositoryInterface
{
 public function register(Request $request);
 public function activeAccount(Request $request);
 public function sendForgetPassword(Request $request);
 public function changePassword(Request $request);
 public function myAccount();
 public function editInformation($id);
 public function updateInformation(Request $request, $id);
 public function editPassword($id);
 public function updatePassword(Request $request, $id);
}