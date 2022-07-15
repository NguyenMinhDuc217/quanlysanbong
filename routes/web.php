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
use App\Http\Controllers\BuyTicketController;
use App\Models\Detail_set_pitchs;
use Carbon\Carbon;

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
//my account
Route::get('/my-account', [UserController::class,'myAccount'])->name('my.account');
Route::get('/my-account/{id}/edit-information', [UserController::class,'editInformation'])->name('edit.information');
Route::post('/my-account/{id}/edit-information', [UserController::class,'updateInformation'])->name('update.information');
Route::get('/my-account/{id}/edit-password', [UserController::class,'editPassword'])->name('edit.password');
Route::post('/my-account/{id}/edit-password', [UserController::class,'updatePassword'])->name('update.password');
//notification 
Route::get('/notification', [NotificationController::class,'listNotification'])->name('notification');
Route::get('/search-notification', [NotificationController::class,'searchNotification'])->name('search.notification');



//listpitch
Route::get('/', [PitchController::class,'ListPitch'])->name('list_pitch');
Route::get('/search-pitch', [PitchController::class,'Search'])->name('search.pitch');

//detailpitch
Route::get('/detail-pitch/{pitchid}', [PitchController::class,'DetailPitch'])->name('detail.pitch');
Route::post('/detail-pitch/{id}/ajax', [PitchController::class,'commentAjax'])->name('pitch.detail.comment.ajax');
Route::post('/send-phone', [PitchController::class,'sendPhone'])->name('send.phone');

//set pitch
Route::post('/detail-pitch/{pitchid}', [SetPitchController::class,'setPitch'])->name('search.time');
//list set pitch
Route::get('/list-set-pitch', [SetPitchController::class,'listSetPitch'])->name('list.set.pitch');
//show update
Route::post('/set-pitch/update/{id}', [SetPitchController::class,'showUpdateSetPitch'])->name('show.update.set.pitch');
//show update
Route::post('/update/{id}/set-pitch', [SetPitchController::class,'updateSetPitch'])->name('update.set.pitch');
//delete
Route::post('/delete-set-pitch', [SetPitchController::class,'deleteSetPitch'])->name('delete.set.pitch');
//show dich vu dat san
Route::get('/view-service', [SetPitchController::class,'detailService'])->name('detail.service');
//thanh toan VNPAY
Route::post('/vnpay-payment', [PayController::class,'vnpay_payment'])->name('vnpay.payment');
Route::get('/return-vnpay', [PayController::class,'return'])->name('return.payment');
//thanh toan VNPAY
Route::post('/vnpay-payment-ticket', [PayTicketController::class,'vnpay_payment'])->name('vnpay.payment.ticket');
Route::get('/return-vnpay-ticket', [PayTicketController::class,'return'])->name('return.payment.ticket');
//list_ticket
Route::get('/ticket', [TicketController::class,'showTicket'])->name('show.ticket');
//view
Route::get('/view-ticket', [TicketController::class,'viewTicket'])->name('view.ticket');
//detail
Route::get('/detail-ticket', [TicketController::class,'detailTicket'])->name('detail.ticket');
//buy ticket
Route::post('/buy-ticket', [BuyTicketController::class,'buyTicket'])->name('buy.ticket');
//list-buy-ticket
Route::get('/list-buy-ticket', [BuyTicketController::class,'listBuyTicket'])->name('list.buy.ticket');
//pay
Route::get('/pay-ticket', [BuyTicketController::class,'payTicket'])->name('pay.ticket');
//Team
   //create
Route::get('/create-team', [TeamController::class,'showCreateTeam'])->name('show.create.team');
Route::post('/create-team', [TeamController::class,'createTeam'])->name('create.team');
   //list
Route::get('/list-team', [TeamController::class,'listTeam'])->name('list.team');
Route::get('/my-team', [TeamController::class,'myTeam'])->name('my.team');
Route::get('/my-team/{id}/edit', [TeamController::class,'editTeam'])->name('my.team.edit');
Route::post('/my-team/{id}/edit', [TeamController::class,'updateTeam'])->name('my.team.update');
// Route::get('/apps/{id}/edit', 'ApplicationManagerController@edit')->name('admin.apps.edit');
// Route::put('/apps/{id}/edit', 'ApplicationManagerController@update')->name('admin.apps.update');
  //search
Route::get('/search-team', [ListTeamController::class,'searchTeam'])->name('search.team');

Route::get('/login', [AdminLoginController::class,'showLoginForm'])->name('admin.show.login');
Route::post('/login', [AdminLoginController::class,'login'])->name('admin.login');
Route::get('/logout', [AdminLoginController::class,'logout'])->name('admin.logout');


Route::prefix('admin')->group(function () {
   Route::get('/home', [AdminController::class,'index'])->name('admin.index');
   Route::get('/my-account', [AdminController::class,'myAccount'])->name('admin.my.account');
   Route::get('/my-account/{id}/edit-information', [AdminController::class,'editInformation'])->name('admin.my.edit.information');
   Route::post('/my-account/{id}/edit-information', [AdminController::class,'updateInformation'])->name('admin.my.update.information');
   Route::get('/my-account/{id}/edit-password', [AdminController::class,'editPassword'])->name('admin.my.account.edit.password');
   Route::post('/my-account/{id}/edit-password', [AdminController::class,'updatepassword'])->name('admin.my.account.update.password');
   Route::resource('/users', UserManagerController::class);
   Route::resource('/pitchs', PitchManagerController::class);
   Route::resource('/set_pitchs', SetPitchManagerController::class);
   Route::resource('/tickets', TicketManagerController::class);
   Route::resource('/services', ServiceManagerController::class);
   Route::post('/services/delete', [ServiceManagerController::class,'destroy'])->name('services.delete');
   Route::resource('/bills', BillsManagerController::class);
   Route::get('/image', [ImageManagerController::class,'fileManager'])->name('admin.image');
   Route::get('/chart-set-pitch', [StatisticManagerController::class,'showChartSetPitch'])->name('show.chart.set.pitch');
   Route::get('/chart/set-pitch', [StatisticManagerController::class,'chartSetPitch'])->name('chart.set.pitch');
   Route::get('/chart-bill-set-pitch', [StatisticManagerController::class,'showChartBillSetPitch'])->name('show.chart.bill.set.pitch');
   Route::get('/chart/bill-set-pitch', [StatisticManagerController::class,'chartBillSetPitch'])->name('chart.bill.set.pitch');

});

