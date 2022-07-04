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

class SetPitchRepository implements SetPitchRepositoryInterface
{
    public function setPitch(Request $request,$pitchid=''){
     
      define('MINUTE',60);
      define('HAFLANHOUR',30);
      define('SECOND',60);
      define('PERCENT',100);
      
        $request->validate(
         [
          'timeStart' => 'required',
          'timeEnd' => 'required',
         ],
         [
          'timeStart.required'=>'Vui lòng chọn thời gian bắt đầu',
          'timeEnd.required'=>'Vui lòng thời gian kết thúc',
         ]
        );
        $timeStart=$request->timeStart;
        $timeEnd=$request->timeEnd;
        
        if( $timeEnd<$timeStart){
            return redirect()->route('detail.pitch',['pitchid'=>$pitchid])->with('error',"Thời gian kết thúc phải lớn hơn thời gian bắt đầu");
        }
        
        if((strtotime($timeEnd)-strtotime($timeStart))/SECOND<=HAFLANHOUR){
            return redirect()->route('detail.pitch',['pitchid'=>$pitchid])->with('error',"Thời gian của trận đấu phải lớn hơn 30 phút");
        }
        
        
        $pitch=Pitchs::where('id',$pitchid)->where('status','1')->first();
         if( $pitch==null){
            return redirect()->route('detail.pitch',['pitchid'=>$pitchid])->with('error',"Không tìm thấy sân");
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
            return redirect()->route('detail.pitch',['pitchid'=>$pitchid])->with('error',"Sân đã được đặt từ $setTimeStart đến $setTimeEnd");
        }
    
        $setPitch=new Detail_set_pitchs();
        $setPitch->picth_id=$pitchid;
        $setPitch->user_id=Auth::guard('user')->user()->id;
        $setPitch->date_event= $request->timeStart;
        $setPitch->start_time = $request->timeStart;
        $setPitch->end_time = $request->timeEnd;   
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
               $setService->total=$request->ch_for[$server_id][0]*$service->price;
               $setService->save();
            }
        }

        $successStart= date_format(date_create($request->timeStart),"Y/m/d H:i:s");
        $successEnd= date_format(date_create($request->timeEnd),"Y/m/d H:i:s");
        return redirect()->route('detail.pitch',['pitchid'=>$pitchid])->with('success',"Bạn đã đặt sân từ $successStart đến $successEnd");
    }

   public function listSetPitch(){
    foreach(Pitchs::all() as $pitch){
       $pitchs[$pitch->id]=$pitch->name;
    }
    $listSetPitch=[];
    foreach(Detail_set_pitchs::orderby('id','DESC')->where('user_id',Auth::guard('user')->user()->id)->get() as $i=>$detail_set_pitch){
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
}