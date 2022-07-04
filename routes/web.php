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
use App\Http\Controllers\TicketController;

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
Route::post('/detail-pitch/{id}/ajax', [PitchController::class,'commentAjax'])->name('pitch.detail.comment.ajax');

//set pitch
Route::post('/detail-pitch/{pitchid}', [SetPitchController::class,'setPitch'])->name('search.time');
//list set pitch
Route::get('/list-set-pitch', [SetPitchController::class,'listSetPitch'])->name('list.set.pitch');
//delete
Route::post('/delete-set-pitch', [SetPitchController::class,'deleteSetPitch'])->name('delete.set.pitch');
//thanh toan VNPAY
Route::post('/vnpay-payment', [PayController::class,'vnpay_payment'])->name('vnpay.payment');
Route::get('/return-vnpay', [PayController::class,'return'])->name('return.payment');
//list_ticket
Route::get('/ticket', [TicketController::class,'showTicket'])->name('show.ticket');
//view
Route::get('/view-ticket', [TicketController::class,'viewTicket'])->name('view.ticket');
//detail
Route::get('/detail-ticket', [TicketController::class,'detailTicket'])->name('detail.ticket');

Route::get('/dang-nhap', [AdminLoginController::class,'showLoginForm'])->name('admin.show.login');
Route::post('/dang-nhap', [AdminLoginController::class,'login'])->name('admin.login');
Route::get('/logout', [AdminLoginController::class,'logout'])->name('admin.logout');

Route::get('/dashboard', [AdminController::class,'index'])->name('admin.index');

Route::prefix('admin')->group(function () {
   Route::resource('/users', UserManagerController::class);
   Route::resource('/pitchs', PitchManagerController::class);
   Route::resource('/set_pitchs', SetPitchManagerController::class);
});

