<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/user/login', [UserController::class,'showLogin'])->name('show.login');
Route::post('/user/login', [UserController::class,'login'])->name('login');
Route::get('/user/logout', [UserController::class,'logout'])->name('logout');


Route::get('/dang-nhap', [AdminLoginController::class,'showLoginForm'])->name('admin.show.login');


Route::get('/test', [TestController::class,'index'])->name('index');

