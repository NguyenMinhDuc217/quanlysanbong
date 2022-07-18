<?php

namespace App\Repositories;

use App\Repositories\Interfaces\TicketRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Pitchs;
use App\Models\Detail_set_pitchs;
use App\Models\Tickets;
use App\Models\DetailTicket;
use App\Models\SetService;
use App\Models\Discount;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TicketRepository implements TicketRepositoryInterface
{
  public function showTicket(){
      $now=Carbon::now()->format('Y-m-d');
      $tickets=Tickets::where('status',1)->where('ispay',0)->where('timeout','>',$now)->paginate(9)->appends(request()->query());
      $discounts=[];
      foreach(Discount::all() as $discount){
          $discounts[$discount->ticket_id]=$discount;
      }
      return view('buy-ticket.index',compact('tickets','discounts'));
  }

  public function viewTicket(Request $request){
    $now=Carbon::now()->format('Y-m-d');
      $data=[];
      $data['ticket']=Tickets::where('id', $request->ticketid)->where('status',1)->where('timeout','>',$now)->first();
      $data['detail_ticket']=DetailTicket::where('ticket_id', $request->ticketid)->first();
      $data['discount']=Discount::where('ticket_id',$request->ticketid)->first();
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
    $discounts=[];
    foreach(Discount::all() as $discount){
        $discounts[$discount->ticket_id]=$discount;
    }
    return view('ticket-detail.index',compact('data','discounts'));
  }

  public function buyTicket(Request $request){
      $ticket=Tickets::where('id', $request->ticketid)->where('ispay',1)->where('status',1)->first();
      if(!empty($ticket)){
        return response()->json([
          'status'=>-99999,
          'data'=>'Vé đã được mua',
        ]);
      }
      return response()->json([
        'status'=>200,
        'data'=>'Bạn thực muốn mua?',
      ]);
    }

    public function listBuyTicket(){
      $user_id=Auth::guard('user')->user()->id;
      $tickets=[];
       $paginate=Tickets::where('user_id',$user_id)->where('isPay',1)->paginate(10);
      foreach(Tickets::where('user_id',$user_id)->where('isPay',1)->paginate(10) as $i=>$ticket){
        $tickets[$i]['ticket']=$ticket;
        $tickets[$i]['detail_ticket']=DetailTicket::where('ticket_id',$ticket->id)->first();
      }
      return view('list-buy-ticket.index',compact('tickets','paginate'));
    } 
   public function payTicket(Request $request){
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
      $discounts=[];
      foreach(Discount::all() as $discount){
          $discounts[$discount->ticket_id]=$discount;
      }
      return view('pay-ticket.index',compact('data','discounts'));
   }
}