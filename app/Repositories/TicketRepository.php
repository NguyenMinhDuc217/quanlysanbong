<?php

namespace App\Repositories;

use App\Repositories\Interfaces\TicketRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Pitchs;
use App\Models\Detail_set_pitchs;
use App\Models\Tickets;
use App\Models\DetailTicket;
use App\Models\SetService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TicketRepository implements TicketRepositoryInterface
{
  public function showTicket(){
      $now=Carbon::now()->format('Y-m-d');
      $tickets=Tickets::where('status',1)->where('ispay',0)->where('timeout','>',$now)->paginate(9)->appends(request()->query());
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

  public function detailTicket(Request $request){
    $now=Carbon::now()->format('Y-m-d');
    foreach(Pitchs::all() as $pitch){
      $pitchs[$pitch->id]=$pitch->name;
   }
    $data=[];
    $data['ticket']=Tickets::where('id', $request->ticketid)->where('status',1)->where('timeout','>',$now)->first();
    $data['detail_ticket']=DetailTicket::where('ticket_id', $request->ticketid)->first();
    foreach(Detail_set_pitchs::where('ticket_id', $request->ticketid)->get() as $i=>$setPitch){
      $data['setPitch'][$i]['setPitch']=$setPitch;
      $data['setPitch'][$i]['pitch']=$pitchs[$setPitch->picth_id];
    }
    foreach(SetService::where('ticket_id', $request->ticketid)->get() as $i=>$service){
      $data['service'][$i]=$service;
    }
    return view('ticket-detail.index',compact('data'));
  }

  public function buyTicket(Request $request){
      $ticket=Tickets::where('id', $request->ticketid)->where('status',1)->first();
      if(empty($ticket)){
        return response()->json([
          'status'=>-99999,
          'data'=>'Vé đã được mua',
        ]);
      }
      $ticket->user_id=Auth::guard('user')->user()->id;
      $ticket->status=0;
      $ticket->save();
      $listSetPitch=Detail_set_pitchs::where('ticket_id', $request->ticketid)->get();
      if(!empty($listSetPitch)){
        foreach($listSetPitch as $setPitch){
          $setPitch->user_id=Auth::guard('user')->user()->id;
          $setPitch->save();
        }
      }  
      return response()->json([
        'status'=>200,
        'data'=>'Bạn đã mua vé thành công, vui lòng vào mục quản lý vé tháng để thanh toán.',
      ]);
    }

    public function detailBuyTicket(){
      
      return view('detail-buy-ticket.index',compact('data'));
    } 
  
}