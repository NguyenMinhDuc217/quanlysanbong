<?php

namespace App\Repositories;

use App\Repositories\Interfaces\SetPitchRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Pitchs;
use App\Models\Detail_set_pitchs;
use Illuminate\Support\Facades\Auth;

class SetPitchRepository implements SetPitchRepositoryInterface
{
    public function setPitch(Request $request,$pitchid){
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
        $setPitch->service_id= $request->service;
        $setPitch->date_event= $request->timeStart;
        $setPitch->start_time = $request->timeStart;
        $setPitch->end_time = $request->timeEnd;   
        $setPitch->total=0;   
        $setPitch->save();

        $successStart= date_format(date_create($request->timeStart),"Y/m/d H:i:s");
        $successEnd= date_format(date_create($request->timeEnd),"Y/m/d H:i:s");
        return redirect()->route('detail.pitch',['pitchid'=>$pitchid])->with('success',"Bạn đã đặt sân từ $successStart đến $successEnd");
    }

}