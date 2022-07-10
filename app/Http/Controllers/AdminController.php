<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseAdminController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pitchs;
use App\Models\Detail_set_pitchs;
use App\Models\Tickets;

class AdminController extends BaseAdminController
{
    public function __construct()
    {
       parent::__construct();
    }
    public function index(){
         $user_count=User::where('status',1)->count();
         $pitch_count=Pitchs::where('status',1)->count();
         $set_pitch_count=Detail_set_pitchs::where('ticket_id',null)->count();
         $ticket=Tickets::all()->count();
        return view('admin.home.home',compact('user_count','pitch_count','set_pitch_count','ticket'));
    }
}
