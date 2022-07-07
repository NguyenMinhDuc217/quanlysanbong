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

class SetPitchRepository implements SetPitchRepositoryInterface
{
    public function setPitch(Request $request,$pitchid=''){
     
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
     
        if( $timeEnd<$timeStart){
            return response()->json(['status' => 401, 'error' => "Thời gian kết thúc phải lớn hơn thời gian bắt đầu"]);
        }
        
        if((strtotime($timeEnd)-strtotime($timeStart))/SECOND<=HAFLANHOUR){
            return response()->json(['status' => 402, 'error' => "Thời gian của trận đấu phải lớn hơn 30 phút"]);
        }
        
        
        $pitch=Pitchs::where('id',$pitchid)->where('status','1')->first();
         if( $pitch==null){
            return response()->json(['status' => 400, 'error' => "Không tìm thấy sân or sân không hoạt động"]); 
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
    
        $setPitch=new Detail_set_pitchs();
        $setPitch->picth_id=$pitchid;
        $setPitch->user_id=Auth::guard('user')->user()->id;
        $setPitch->date_event= $request->timeStart;
        $setPitch->start_time = $request->timeStart;
        $setPitch->end_time = $request->timeEnd;   
        $setPitch->price_pitch= $pitch->price*$timeSoccer*((PERCENT-$pitch->discount)/PERCENT);   
        $setPitch->total= $pitch->price*$timeSoccer*((PERCENT-$pitch->discount)/PERCENT);   
        $setPitch->save();

        if($request->ch_name!=null){
            foreach($request->ch_name as $server_id){
               $service=Services::where('id',$server_id)->first();
               $setService=new SetService();
               $setService->set_pitch_id= $setPitch->id;
               $setService->service_id=$server_id;
               $setService->name= $service->name;
               $setService->quantity=$request->ch_for[$server_id][0];
               if($server_id==4){
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
        $successStart= date_format(date_create($request->timeStart),"Y/m/d H:i:s");
        $successEnd= date_format(date_create($request->timeEnd),"Y/m/d H:i:s");
        return response()->json(['status'=> 200,'success'=>"Bạn đã đặt sân từ $successStart đến $successEnd"]);
    }

   public function listSetPitch(){
    foreach(Pitchs::all() as $pitch){
       $pitchs[$pitch->id]=$pitch->name;
    }
    $listSetPitch=[];
    foreach(Detail_set_pitchs::orderby('id','DESC')->where('user_id',Auth::guard('user')->user()->id)->where('ticket_id',null)->get() as $i=>$detail_set_pitch){
       $listSetPitch[$i]['detail_set_pitch']=$detail_set_pitch;
       $listSetPitch[$i]['name']=$pitchs[$detail_set_pitch->picth_id];
       foreach(SetService::where('set_pitch_id',$detail_set_pitch->id)->get() as $k=>$setService){
        $listSetPitch[$i]['service'][$k]= $setService;
       }
    }
    return view('list-set-pitch.index',compact('listSetPitch'));
   }

   public function deleteSetPitch(Request $request){ 
    $pitch = Detail_set_pitchs::where('id', $request->set_pitch_id)->first();
    $detail_set_pitch=Detail_set_pitchs::find($request->set_pitch_id);
    if(Carbon::now()->format('Y-m-d H:i:s')>$pitch->start_time){
        return redirect()->route('list.set.pitch')->with('error',"Thời gian đã diễn ra không thể hủy");
    }
    if(abs(strtotime($pitch->start_time)-strtotime(Carbon::now()->format('Y-m-d H:i:s')))/(60)>=120){
        $detail_set_pitch->delete();
        $listSetPitch=Detail_set_pitchs::where('user_id',Auth::guard('user')->user()->id)->get();
        return redirect()->route('list.set.pitch')->with('success',"Bạn đã hủy thành công");
    }
    if(abs(strtotime($pitch->start_time)-strtotime(Carbon::now()->format('Y-m-d H:i:s')))/(60)<120){
        $detail_set_pitch->delete();
        $refund=$pitch->total*0.8;
        return redirect()->route('list.set.pitch')->with('error',"Bạn đã hủy thành công, số tiền bạn nhận lại là  $refund vnd");
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
}