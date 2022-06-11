<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminLoginController;

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


Route::get('/user/login', [UserLoginController::class,'showLogin'])->name('show.login');
Route::post('/user/login', [UserLoginController::class,'login'])->name('login');
Route::get('/user/logout', [UserLoginController::class,'logout'])->name('logout');

Route::get('/user/register', [UserController::class,'showRegister'])->name('show.register');

Route::get('/dang-nhap', [AdminLoginController::class,'showLoginForm'])->name('admin.show.login');
Route::post('/dang-nhap', [AdminLoginController::class,'login'])->name('admin.login');
Route::get('/logout', [AdminLoginController::class,'logout'])->name('admin.logout');

Route::get('/dashboard', [AdminController::class,'index'])->name('admin.index');


