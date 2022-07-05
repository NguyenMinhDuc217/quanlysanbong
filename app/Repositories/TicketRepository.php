<?php

namespace App\Repositories;

use App\Repositories\Interfaces\TicketRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Pitchs;
use App\Models\Tickets;
use App\Models\DetailTicket;
use Carbon\Carbon;

class TicketRepository implements TicketRepositoryInterface
{
  public function showTicket(){
    $now=Carbon::now()->format('Y-m-d');
       $tickets=Tickets::where('status',1)->where('timeout','>=',$now)->paginate(9)->appends(request()->query());
      return view('buy-ticket.index',compact('tickets'));
  }

  public function viewTicket(Request $request){
    $now=Carbon::now()->format('Y-m-d');
      $data=[];
      $data['ticket']=Tickets::where('id', $request->ticketid)->where('status',1)->where('timeout','>',$now)->first();
      $data['detail_ticket']=DetailTicket::where('ticket_id', $request->ticketid)->first();
      return response()->json([
        'status'=>200,
        'data'=>$data,
      ]);
  }
}