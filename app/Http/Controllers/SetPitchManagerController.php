<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseAdminController;
use App\Models\Detail_set_pitchs;
use App\Models\Pitchs;
use App\Models\Services;
use App\Models\SetService;
use App\Models\User;
use App\Models\Setting;
use App\Models\Tickets;
use App\Models\Bill;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
// use Image;
use Carbon\Carbon;


class SetPitchManagerController extends BaseAdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /** Create a new controller instance. */
    public function __construct()
    {
    }

    public function index()
    {
        $list_detail_set_pitch = Detail_set_pitchs::all();
        foreach($list_detail_set_pitch as $d){
            if($d->end_time != null){
                if((strtotime(Carbon::now()->format('Y-m-d H:i:s'))- strtotime($d->end_time))/(60*60*24)>365){
                    $d->delete();
                }
            }
        }
        foreach(Pitchs::all() as $pitch){
            $pitchs[$pitch->id]=$pitch->name;
         }
         foreach(User::all() as $user){
            $users[$user->id]=$user->username;
         }
        // dd($pitchs, $users);
        $detail_set_pitch = [];
        foreach ($list_detail_set_pitch as $i => $detail) {
            $services = Services::all();
            $setServices = [];
            $detail_set_pitch[$i]['detail']= $detail;
            $detail_set_pitch[$i]['name']=$pitchs[$detail->picth_id];
            if($detail->user_id == 0){
                $detail_set_pitch[$i]['username'] = "";
            }
            else{
                $detail_set_pitch[$i]['username'] = isset($users[$detail->user_id]) ? $users[$detail->user_id] : "";
            }

            foreach(SetService::where('set_pitch_id',$detail['id'])->get() as $s => $set){
                $detail_set_pitch[$i]['service'][$s]= $set;
            }
            // $pitchs = Pitchs::where("id", $detail["picth_id"])->first();
            // $detail['pitch_name'] = isset($pitchs['name']) ? $pitchs['name'] : "";
            // $detail['username'] = isset($users['username']) ? $users['username'] : "";
            // $detail['service_name'] = isset($services['name']) ? $services['name'] : "";
        }
        return View('admin.set_pitch.index', compact('detail_set_pitch'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     return View('admin.set_pitchs.create');
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {

    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    public function pay(Request $request)
    {
        $detail_set_pitch = Detail_set_pitchs::where('id',$request->setpitch)->first();
        $bill = Bill::where('detail_set_pitch_id', $detail_set_pitch->id)->where('status',1)->first();
        if(!empty($bill)){
            return redirect()->route('set_pitchs.index')->with('error', "Hoá đơn đã tồn tại");
        }
        $detail_set_pitch->ispay = '1';
        $detail_set_pitch->save();

        $bill= new Bill();
        $bill->detail_set_pitch_id = $detail_set_pitch->id;
        $bill->user_id = $detail_set_pitch->user_id;
        $bill->transaction_id=Str::random(8);
        $bill->bill_number = rand(0,99999999);
        $bill->trace_number=Str::random(8);
        $bill->price = $detail_set_pitch->total;
        $bill->createdate = Carbon::now();
        $bill->bank = '';
        $bill->transfer_content = 'Thanh toán tiền sân từ '. $detail_set_pitch->start_time . ' đến '. $detail_set_pitch->end_time;
        $bill->status='1';
        $bill->save();
        $setPitch=Detail_set_pitchs::where('id',$bill->detail_set_pitch_id)->first();
        $setPitch->ispay='1';
        $setPitch->save();
        if($bill->save()){
            return redirect()->route('set_pitchs.index')->with('success', "Thanh toán thành công");
        }
        return redirect()->route('set_pitchs.index')->with('error','Xử lí thanh toán thất bại');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     // $pitchs = Pitchs::where('id', $id)->first();
    //     $detail_set_pitch = Detail_set_pitchs::where('id', $id)->first();
    //     $type_pitchs = Pitchs::all();
    //     $ticket = Tickets::where('id', $detail_set_pitch["ticket_id"])->first();
    //     $user = User::where('id', $detail_set_pitch->user_id)->first();
    //     $services=Services::get();
    //     $setServices=SetService::where('set_pitch_id',$detail_set_pitch->id)->get();
    //     foreach($services as $i=>$service){
    //         foreach($setServices as $setservice){
    //             if($service->id==$setservice->service_id){
    //                 unset($services[$i]);
    //             }
    //         }  
    //     }
    //     return View('admin.set_pitch.edit', compact('detail_set_pitch', 'type_pitchs', 'ticket', 'user','services','setServices'));
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        define('MINUTE', 60);
        define('HAFLANHOUR', 30);
        define('SECOND', 60);
        define('PERCENT', 100);
        // dd($id);die;

        $request->validate(
            [
                // 'ticket' => 'required',
                'type_pitch' => 'required',
                // 'user' => 'required',
                // 'date_event' => 'required',
                'timeStart' => 'required',
                'timeEnd' => 'required',
                // 'price_pitch' => 'required|digits_between:50000,999999',
                // 'total' => 'required|digits_between:50000,999999',
                'ispay' => 'required',
            ],
            [
                // 'ticket.required' => 'Vui lòng chọn vé',
                'type_pitch.required' => 'Vui lòng chọn sân',
                // 'user.required' => 'Vui lòng chọn user',
                // 'date_event.required' => 'Vui lòng chọn thời gian ngày diễn ra',
                'timeStart.required' => 'Vui lòng chọn thời gian bắt đầu',
                'timeEnd.required' => 'Vui lòng thời gian kết thúc',
                // 'price_pitch.required' => 'Vui lòng nhập giá sân',
                // 'price_pitch.digits_between' => 'Giá tiền phải là số, phải lớn hơn hoặc bằng 50 000 và nhỏ hơn hoặc bằng 999 999',
                // 'total.required' => 'Vui lòng nhập tổng tiền',
                // 'total.digits_between' => 'Giá tiền phải là số, phải lớn hơn hoặc bằng 50 000 và nhỏ hơn hoặc bằng 999 999',
                'ispay.required' => 'Vui lòng chọn thanh toán',
            ],
        );
        $timeStart = $request->timeStart;
        $timeEnd = $request->timeEnd;
        $detail_set_pitch = Detail_set_pitchs::where('id', $id)->get(); 

        if ($timeEnd < $timeStart) {
            return redirect()->route('admin.set_pitch.edit', ['id' => $id])->with('error', "Thời gian kết thúc phải lớn hơn thời gian bắt đầu");
        }

        if ((strtotime($timeEnd) - strtotime($timeStart)) / SECOND <= HAFLANHOUR) {
            return redirect()->route('admin.set_pitch.edit', ['id' => $id])->with('error', "Thời gian của trận đấu phải lớn hơn 30 phút");
        }
        $pitch = Pitchs::where('id', $id)->where('status', '1')->first();
        if ($pitch == null) {
            return redirect()->route('admin.set_pitch.edit', ['id' => $id])->with('error', "Không tìm thấy sân");
        }

        $timeSoccer = (strtotime($timeEnd) - strtotime($timeStart)) / (MINUTE * SECOND);

        $checkTimes = Detail_set_pitchs::where('picth_id', $id)->where(function ($query) use ($timeStart, $timeEnd) {
            $query->where('start_time', '<=', $timeStart)->where('end_time', '>=', $timeEnd);
        })->get();
        if ($checkTimes->count() == 0) {
            $checkTimes = Detail_set_pitchs::where('picth_id', $id)->where(function ($query) use ($timeStart, $timeEnd) {
                $query->whereBetween('start_time', [$timeStart, $timeEnd])->orwhereBetween('end_time', [$timeStart, $timeEnd]);
            })->get();
        }

        if ($checkTimes->count() > 0) {
            foreach ($checkTimes as $checkTime) {
                $setTimeStart = $checkTime->start_time;
                $setTimeEnd = $checkTime->end_time;
            }
            return redirect()->route('admin.set_pitch.edit', ['id' => $id])->with('error', "Sân đã được đặt từ $setTimeStart đến $setTimeEnd");
        }
        dd($checkTimes);
        if($pitch->save()){
            return redirect()->route('pitchs.edit',['pitch'=>$pitch->id])->with('success','Cập nhật sân thành công');
          }
           return redirect()->route('pitchs.edit',['pitch'=>$pitch->id])->with('error','Xử lí cập nhật thất bại');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->id;
            $pitch = Pitchs::where('id', $id)->first();
            if (!empty($pitch->avartar)) {
                if (file_exists(public_path() . '/images/pitch/' . $pitch->avartar)) {
                    @unlink(public_path() . '/images/pitch/' . $pitch->avartar);
                }
            }
            if (!empty($pitch->screenshort)) {
                $screenshort = json_decode($pitch->screenshort);
                foreach ($screenshort as $v) {
                    if (file_exists(public_path() . '/images/pitch/' . $v)) {
                        @unlink(public_path() . '/images/pitch/' . $v);
                    }
                }
            }
            Pitchs::where('id', $id)->delete();
            // Clear cache
            Cache::flush();
            return response()->json([
                'status' => true,
                'message' => 'Data deleted successfully!'
            ]);
        }
    }
}
