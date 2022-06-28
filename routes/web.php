<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\UserManagerController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\SetPitchController;

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

Route::get('/getinfo-fb/{social}', [SocialController::class,'getInfo'])->name('show.login.fb');
Route::get('/checkinfo-fb/{social}', [SocialController::class,'checkInfo'])->name('check.login.fb');


Route::get('/user/register', [UserController::class,'showRegister'])->name('show.register');
Route::post('/user/register', [UserController::class,'register'])->name('register');
Route::get('/user/active', [UserController::class,'activeAccount'])->name('user.active.account');
Route::get('/user/forget-password', [UserController::class,'showForgetPassword'])->name('show.forgetpassword');
Route::post('/user/forget-password', [UserController::class,'sendForgetPassword'])->name('send.forgetpassword');
Route::get('/user/change-password', [UserController::class,'changeForgetPassword'])->name('change.forgetpassword');
Route::post('/user/change-password', [UserController::class,'test'])->name('change.password');
//listpitch
Route::get('/', [PitchController::class,'ListPitch'])->name('list_pitch');
Route::get('/search-pitch', [PitchController::class,'Search'])->name('search.pitch');

//detailpitch
Route::get('/detail-pitch/{pitchid}', [PitchController::class,'DetailPitch'])->name('detail.pitch');

//set pitch
Route::post('/detail-pitch/{pitchid}', [SetPitchController::class,'setPitch'])->name('search.time');


Route::get('/dang-nhap', [AdminLoginController::class,'showLoginForm'])->name('admin.show.login');
Route::post('/dang-nhap', [AdminLoginController::class,'login'])->name('admin.login');
Route::get('/logout', [AdminLoginController::class,'logout'])->name('admin.logout');

Route::get('/dashboard', [AdminController::class,'index'])->name('admin.index');

Route::prefix('admin')->group(function () {
   Route::resource('/users', UserManagerController::class);
});

