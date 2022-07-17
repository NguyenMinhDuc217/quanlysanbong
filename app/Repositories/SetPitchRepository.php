<?php

namespace App\Repositories;

use App\Repositories\Interfaces\SetPitchRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Pitchs;
use App\Models\Detail_set_pitchs;
use App\Models\Services;
use App\Models\SetService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use League\OAuth1\Client\Server\Server;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\Bill;
use App\Models\DetailTicket;
use App\Models\Discount;

class SetPitchRepository implements SetPitchRepositoryInterface
{
    public function setPitch(Request $request,$pitchid='')
    {
        define('MINUTE',60);
        define('HAFLANHOUR',30);
        define('SECOND',60);
        define('PERCENT',100);

        $validator = Validator::make($request->all(),
        [
            'timeStart' => 'required',
            'timeEnd' => 'required',
           ],
           [
            'timeStart.required'=>'Vui lòng chọn thời gian bắt đầu',
            'timeEnd.required'=>'Vui lòng thời gian kết thúc',
           ]
        );
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()->all()]);
        }

        $timeStart=$request->timeStart;
        $timeEnd=$request->timeEnd;
  
        $dayStart= date_format(date_create($request->timeStart),"d");
        $dayEnd= date_format(date_create($request->timeEnd),"d"); 
        if($dayStart<$dayEnd){
            return response()->json(['status' => 401, 'error' => "Sân bóng hoạt động từ 7h00 đến 23h59"]); 
        }

        $hourStart= date_format(date_create($request->timeStart),"H:i");
        $hourEnd= date_format(date_create($request->timeEnd),"H:i");
      
        $timeStartNo=date('H:i',mktime(0,0));
        $timeEndNo=date('H:i',mktime(7,0));
       

        if($timeStartNo<=$hourStart&&$hourStart<=$timeEndNo){
            return response()->json(['status' => 401, 'error' => "Sân bóng hoạt động từ 7h00 đến 23h59"]);
        }

        if($timeStartNo<=$hourEnd&&$hourEnd<=$timeEndNo){
            return response()->json(['status' => 401, 'error' => "Sân bóng hoạt động từ 7h00 đến 23h59"]);
        }

        if($timeStartNo<=$hourStart&&$hourEnd<=$timeEndNo){
            return response()->json(['status' => 401, 'error' => "Sân bóng hoạt động từ 7h00 đến 23h59"]);
        }

        if($timeStartNo>=$hourStart&&$hourEnd>=$timeEndNo){
            return response()->json(['status' => 401, 'error' => "Sân bóng hoạt động từ 7h00 đến 23h59"]);
        }
      
        if( $timeEnd<$timeStart){
            return response()->json(['status' => 401, 'error' => "Thời gian kết thúc phải lớn hơn thời gian bắt đầu"]);
        }
        
        if((strtotime($timeEnd)-strtotime($timeStart))/SECOND<=HAFLANHOUR){
            return response()->json(['status' => 402, 'error' => "Thời gian của trận đấu phải lớn hơn 30 phút"]);
        }

        if(strtotime(Carbon::now()->format('Y-m-d H:i:s'))-strtotime($timeStart)>0||strtotime(Carbon::now()->format('Y-m-d H:i:s'))-strtotime($timeEnd)>0){
            return response()->json(['status' => 402, 'error' => "Thời gian của trận đấu phải lớn hơn thời gian hiện tại"]);
        }
        
        $pitch=Pitchs::where('id',$pitchid)->where('status','1')->first();
         if($pitch==null){
            return response()->json(['status' => 400, 'error' => "Không tìm thấy sân Hoặc sân không hoạt động"]); 
        }

        $timeSoccer= (strtotime($timeEnd)-strtotime($timeStart))/(MINUTE*SECOND);
        
        $checkTimes=Detail_set_pitchs::where('picth_id',$pitchid)->where(function ($query) use ($timeStart, $timeEnd) {
            $query->where('start_time','<=',$timeStart)->where('end_time','>=', $timeEnd);
        })->get();
        if($checkTimes->count()==0){
            $checkTimes=Detail_set_pitchs::where('picth_id',$pitchid)->where(function ($query) use ($timeStart, $timeEnd) {
                $query->whereBetween('start_time', [$timeStart, $timeEnd])->orwhereBetween('end_time', [$timeStart, $timeEnd]);
            })->get();
        }
        
        if($checkTimes->count()>0){
            foreach ($checkTimes as $checkTime) {
                $setTimeStart=$checkTime->start_time;
                $setTimeEnd=$checkTime->end_time;
            }
            return response()->json(['status' => 400, 'error' => "Sân đã được đặt từ $setTimeStart đến $setTimeEnd"]);
        }

        if($request->ch_name!=null){
            foreach($request->ch_name as $server_id){
                if($request->ch_for[$server_id][0]<1||$request->ch_for[$server_id][0]>300){
                    return response()->json(['status' => 400, 'error' => "Số lượng đặt chỉ từ 1 đến 300"]);
                }
            }
          }


        $now=Carbon::now()->format('Y-m-d');

        $discount=Discount::where('pitch_id',$pitchid)->where('end_discount','>=',$now)->first();
        
        if(!empty($discount)){
            $discount=$discount->discount;
        }else{
            $discount=0;
        }
        $setPitch=new Detail_set_pitchs();
        $setPitch->picth_id=$pitchid;
        $setPitch->user_id=Auth::guard('user')->user()->id;
        $setPitch->date_event= $request->timeStart;
        $setPitch->start_time = $request->timeStart;
        $setPitch->end_time = $request->timeEnd;   
        $setPitch->price_pitch= $pitch->price*$timeSoccer*((PERCENT-$discount)/PERCENT);   
        $setPitch->total= $pitch->price*$timeSoccer*((PERCENT-$discount)/PERCENT);   
        $setPitch->save();

        if($request->ch_name!=null){
            foreach($request->ch_name as $server_id){
               $service=Services::where('id',$server_id)->first();
               $setService=new SetService();
               $setService->set_pitch_id= $setPitch->id;
               $setService->service_id=$server_id;
               $setService->name= $service->name;
               $setService->quantity=$request->ch_for[$server_id][0];
               if($service->type==1){
                $setService->total=$request->ch_for[$server_id][0]*$timeSoccer*$service->price;
               }else{
                $setService->total=$request->ch_for[$server_id][0]*$service->price;
               }
               $setService->save();
            }
        }
        $totalService=SetService::where('set_pitch_id',$setPitch->id)->sum('total');
        $setPitch->total= $setPitch->total+$totalService;
        $setPitch->save();
        $successStart= date_format(date_create($request->timeStart),"d/m/Y H:i");
        $successEnd= date_format(date_create($request->timeEnd),"d/m/Y H:i");

        return response()->json(['status'=> 200,'success'=>"Bạn đã đặt sân từ $successStart đến $successEnd"]);
    }

   public function listSetPitch(){
    foreach(Pitchs::all() as $pitch){
       $pitchs[$pitch->id]=$pitch->name;
    }

    foreach(Bill::all() as $bill){
            $bills[$bill->detail_set_pitch_id]=$bill->transaction_id;
     }
    $listSetPitch=[];
    $paginate=Detail_set_pitchs::orderby('start_time','DESC')->where('user_id',Auth::guard('user')->user()->id)->paginate(10);
    foreach(Detail_set_pitchs::orderby('start_time','DESC')->where('user_id',Auth::guard('user')->user()->id)->paginate(10) as $i=>$detail_set_pitch){
       $listSetPitch[$i]['detail_set_pitch']=$detail_set_pitch;
       $listSetPitch[$i]['name']=$pitchs[$detail_set_pitch->picth_id];
       foreach(SetService::where('set_pitch_id',$detail_set_pitch->id)->get() as $k=>$setService){
        $listSetPitch[$i]['service'][$k]= $setService;
       }
         
       $listSetPitch[$i]['transaction_id']=$bills[$detail_set_pitch->id]??null;

    }

    return view('list-set-pitch.index',compact('listSetPitch','paginate'));
   }

   public function deleteSetPitch(Request $request){ 
    $pitch = Detail_set_pitchs::where('id', $request->set_pitch_id)->first();
    $detail_set_pitch=Detail_set_pitchs::find($request->set_pitch_id);
    $bill=Bill::where('detail_set_pitch_id', $detail_set_pitch->id)->first();
    $deleteService=SetService::where('set_pitch_id',$detail_set_pitch->id)->get();
    if(Carbon::now()->format('Y-m-d H:i:s')>$pitch->start_time){
        return redirect()->route('list.set.pitch')->with('error',"Thời gian đã diễn ra không thể hủy");
    }
    if(abs(strtotime($pitch->start_time)-strtotime(Carbon::now()->format('Y-m-d H:i:s')))/(60)<120){
  
        return redirect()->route('list.set.pitch')->with('error',"Không thể huỷ sân trước 120p");
    }

    if(abs(strtotime($pitch->start_time)-strtotime(Carbon::now()->format('Y-m-d H:i:s')))/(60)>=120){
        if( $detail_set_pitch->ispay==0){
            $detail_set_pitch->delete();
            foreach($deleteService as $delete){
                $delete->delete();
            }
           
            return redirect()->route('list.set.pitch')->with('success',"Bạn đã hủy thành công");
        }else{
            $detail_set_pitch->delete();
            $subject =null;
            $details = [
                'title' => 'Hướng dẫn chi tiết cách nhận lại tiền khi đã thanh toán',
                'name' => Auth::guard('user')->user()->username,
                'body'=>"Mã giao dịch của bạn là $bill->transaction_id. Bạn vui lòng gửi email lại cho chúng tôi về số tài khoản ngân hàng,số momo hoặc số 
                tài khoản Paypal. Với cú pháp là Tên Sân _Ngày giờ đặt_Mã giao dịch_Số tiền số tài khoản của bạn. 
                Ví dụ: SânA_7/7/2022-4h00_7/7/2022-5h00_MAGIAODICH99_120.000 9704198526191432198 $bill->transaction_id",
                
            ];
             $email=Auth::guard('user')->user()->email;
            Mail::to( $email)->send(new SendMail($details, $subject));
            return redirect()->route('list.set.pitch')->with('success',"Bạn đã hủy thành công, vui lòng xem Email để biết cách nhận lại tiền");
        }
      
    }
  
   }

   public function detailService(Request $request)
   {
       $service=SetService::where('id',$request->serviceid)->first();
       return response()->json([
        'status'=>200,
        'data'=>$service,
      ]);
   }
   public function showUpdateSetPitch($id=''){  
    $setPitch=Detail_set_pitchs::where('id',$id)->first();
    $setServices=SetService::where('set_pitch_id',$setPitch->id)->get();
    $pitchs=Pitchs::all();
    $services=Services::get();

    foreach($services as $i=>$service){
        foreach($setServices as $setservice){
             if($service->id==$setservice->service_id){
               unset($services[$i]);
             }
        }  
    }
    return view('update-set-pitch.index',compact('setPitch','setServices','pitchs','services'));
   }

   public function updateSetPitch(Request $request,$id='')
   {
    define('MINUT',60);
    define('HAFLANHOU',30);
    define('SECON',60);
    define('PERCEN',100);
      $validator = Validator::make($request->all(),
      [
          'timeStart' => 'required',
          'timeEnd' => 'required',
         ],
         [
          'timeStart.required'=>'Vui lòng chọn thời gian bắt đầu',
          'timeEnd.required'=>'Vui lòng thời gian kết thúc',
         ]
      );
      if ($validator->fails()) {
          return response()->json(['status' => 400, 'errors' => $validator->errors()->all()]);
      }

      $timeStart=$request->timeStart;
      $timeEnd=$request->timeEnd;

      $dayStart= date_format(date_create($request->timeStart),"d");
      $dayEnd= date_format(date_create($request->timeEnd),"d"); 
      if($dayStart<$dayEnd){
          return response()->json(['status' => 401, 'error' => "Sân bóng hoạt động từ 7h00 đến 23h59"]); 
      }

      $hourStart= date_format(date_create($request->timeStart),"H:i");
      $hourEnd= date_format(date_create($request->timeEnd),"H:i");
    
      $timeStartNo=date('H:i',mktime(0,0));
      $timeEndNo=date('H:i',mktime(7,0));
     

      if($timeStartNo<=$hourStart&&$hourStart<=$timeEndNo){
          return response()->json(['status' => 401, 'error' => "Sân bóng hoạt động từ 7h00 đến 23h59"]);
      }

      if($timeStartNo<=$hourEnd&&$hourEnd<=$timeEndNo){
          return response()->json(['status' => 401, 'error' => "Sân bóng hoạt động từ 7h00 đến 23h59"]);
      }

      if($timeStartNo<=$hourStart&&$hourEnd<=$timeEndNo){
          return response()->json(['status' => 401, 'error' => "Sân bóng hoạt động từ 7h00 đến 23h59"]);
      }

      if($timeStartNo>=$hourStart&&$hourEnd>=$timeEndNo){
          return response()->json(['status' => 401, 'error' => "Sân bóng hoạt động từ 7h00 đến 23h59"]);
      }

      if( $timeEnd<$timeStart){
          return response()->json(['status' => 401, 'error' => "Thời gian kết thúc phải lớn hơn thời gian bắt đầu"]);
      }
      
      if((strtotime($timeEnd)-strtotime($timeStart))/SECON<=HAFLANHOU){
          return response()->json(['status' => 402, 'error' => "Thời gian của trận đấu phải lớn hơn 30 phút"]);
      }
      
      if(abs(strtotime($timeStart)-strtotime(Carbon::now()->format('Y-m-d H:i:s')))/(60)<120){
        return response()->json(['status' => 402, 'error' => "Không thể thay đổi trước 120p"]);
    }
    
    if(strtotime(Carbon::now()->format('Y-m-d H:i:s'))-strtotime($timeStart)>0||strtotime(Carbon::now()->format('Y-m-d H:i:s'))-strtotime($timeEnd)>0){
        return response()->json(['status' => 402, 'error' => "Thời gian của trận đấu phải lớn hơn thời gian hiện tại"]);
    }
      
      $pitch=Pitchs::where('id',$request->pitchid)->where('status','1')->first();
       if( $pitch==null){
          return response()->json(['status' => 400, 'error' => "Không tìm thấy sân Hoặc sân không hoạt động"]); 
      }

      $timeSoccer= (strtotime($timeEnd)-strtotime($timeStart))/(MINUT*SECON);
      
      $checkTimes=Detail_set_pitchs::where('picth_id',$request->pitchid)->where('id','!=',$id)->where(function ($query) use ($timeStart, $timeEnd) {
          $query->where('start_time','<=',$timeStart)->where('end_time','>=', $timeEnd);
      })->get();
      if($checkTimes->count()==0){
          $checkTimes=Detail_set_pitchs::where('picth_id',$request->pitchid)->where('id','!=',$id)->where(function ($query) use ($timeStart, $timeEnd) {
              $query->whereBetween('start_time', [$timeStart, $timeEnd])->orwhereBetween('end_time', [$timeStart, $timeEnd]);
          })->get();
      }
      
      if($checkTimes->count()>0){
          return response()->json(['status' => 400, 'error' => "Vui lòng chọn sân khác"]);
      }
      
      if($request->ch_name!=null){
        foreach($request->ch_name as $server_id){
            if($request->ch_for[$server_id][0]<1||$request->ch_for[$server_id][0]>300){
                return response()->json(['status' => 400, 'error' => "Số lượng đặt chỉ từ 1 đến 300"]);
            }
        }
      }

      $setPitch=Detail_set_pitchs::find($id);
      
      $dayCreate= date_format(date_create($setPitch->created_at),"Y-m-d");
      $checkSetActiveDis=Discount::where('pitch_id',$request->pitchid)->where('start_discount','<=',$dayCreate)->where('end_discount','>=',$dayCreate)->first();
      $discount=0;
      if(!empty($checkSetActiveDis)){
        $now=Carbon::now()->format('Y-m-d');
        $discount=Discount::where('pitch_id',$request->pitchid)->where('end_discount','>=',$now)->first();
        if(!empty($discount)){
            $discount=$discount->discount;
        }else{
            $discount=0;
        }
      }

      $setPitch->picth_id=$request->pitchid;
      $setPitch->user_id=Auth::guard('user')->user()->id;
      $setPitch->date_event= $request->timeStart;
      $setPitch->start_time = $request->timeStart;
      $setPitch->end_time = $request->timeEnd;   
      $setPitch->price_pitch= $pitch->price*$timeSoccer*((PERCEN-$discount)/PERCEN);   
      $setPitch->total= $pitch->price*$timeSoccer*((PERCEN-$discount)/PERCEN);   
      $setPitch->save();

      $deleteService=SetService::where('set_pitch_id',$id)->get();
      foreach($deleteService as $setService){
          foreach($request->ch_name as $service_id){
                unset($deleteService[$service_id-1]);
        }
      }
      foreach($deleteService as $delete){
        $delete->delete();
      }

      if($request->ch_name!=null){
          foreach($request->ch_name as $server_id){
              $service=Services::where('id',$server_id)->first();
              $setService=SetService::where('set_pitch_id',$id)->where('service_id',$server_id)->first();
             if(!empty($setService)){
                $setService->set_pitch_id= $setPitch->id;
                $setService->service_id=$server_id;
                $setService->name= $service->name;
                $setService->quantity=$request->ch_for[$server_id][0];
                if($service->type==1){
                 $setService->total=$request->ch_for[$server_id][0]*$timeSoccer*$service->price;
                }else{
                 $setService->total=$request->ch_for[$server_id][0]*$service->price;
                }
                $setService->save();
             }else{
                $setService=new SetService();
                $setService->set_pitch_id= $setPitch->id;
                $setService->service_id=$server_id;
                $setService->name= $service->name;
                $setService->quantity=$request->ch_for[$server_id][0];
                if($service->type==1){
                 $setService->total=$request->ch_for[$server_id][0]*$timeSoccer*$service->price;
                }else{
                 $setService->total=$request->ch_for[$server_id][0]*$service->price;
                }
                $setService->save();
             }
          
          }
      }

      $totalService=SetService::where('set_pitch_id',$setPitch->id)->sum('total');
      $setPitch->total= $setPitch->total+$totalService;
      $setPitch->save();
      return response()->json(['status'=> 200,'success'=>"Bạn đã thay đổi thành công"]);
   }
}