<?php

namespace App\Http\Controllers;

use App\Models\DetailTicket;
use App\Models\Pitchs;
use App\Models\Services;
use App\Models\Tickets;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;

class TicketManagerController extends Controller
{
    public function index()
    {
        $tickets = Tickets::all();

        return View('admin.ticket.index', compact('tickets'));
    }
    public function create()
    {
        // $months = ['1','2','3','4','5','6','7','8','9','10','11','12'];
        $services = Services::all();
        $pitchs = Pitchs::all();
        return View('admin.ticket.create', compact('services','pitchs'));
    }
    public function store(Request $request)
    {
        define('MINUTE',60);
        define('HAFLANHOUR',30);
        define('SECOND',60);
        define('PERCENT',100);
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'describe' => 'required|max:500',
            'number_day' => 'required|digits:1,7',
            'timeOut' => 'required',
            'timeStart' => 'required',
            'timeEnd' => 'required',
            'timeDay' => 'required',
        ],[
            'name.required'=>'Vui lòng nhập tên vé',
            'name.max'=>'Vui lòng nhập tên vé không quá 255 ký tự',
            'describe.required' => 'Vui lòng nhập thông tin',
            'describe.max'=>'Vui lòng nhập tên sân không quá 500 ký tự',
            'price.required'=>'Vui lòng nhập giá',
            'price.numeric'=>'Giá phải là số',
            'number_day.required' => 'Vui lòng nhập số ngày',
            'number_day.digits'=>'Vui lòng nhập số ngày trong khoảng từ 1 đến 7',
            'timeOut.required'=>'Vui lòng chọn thời gian bắt đầu',
            'timeStart.required'=>'Vui lòng chọn thời gian bắt đầu',
            'timeEnd.required'=>'Vui lòng thời gian kết thúc',
            'timeDay.required'=>'Vui lòng thời gian đá hàng tuần',
        ]);
        $now=Carbon::now()->format('Y-m-d');
        $month = $request->month;
        $timeOut=$request->timeOut;
        $timeStart=$request->timeStart;
        $timeEnd=$request->timeEnd;
        $timeDay=$request->timeDay;

        //kiểm tra vé đã tồn tại hay chưa (ticket)
        $checkTicket = Tickets::where('name',$request->name)->first();
        if(!empty($checkTicket)){
            return redirect()->route('tickets.create')->with('error',"Vé đã tồn tại");
        }

        if( $timeOut<$now){
            return redirect()->route('tickets.create')->with('error',"Thời gian hạn đặt vé phải lớn hơn hoặc bầng thời gian hiện tại");
        }
        if((abs(strtotime($timeStart) - strtotime($timeOut))/(SECOND*MINUTE*24)) < 3){
            return redirect()->route('tickets.create')->with('error',"Thời gian hạn đặt vé phải lớn hơn thời gian bắt đầu 3 ngày");
        }
        if( $timeEnd<$timeStart){
            return redirect()->route('tickets.create')->with('error',"Thời gian kết thúc phải lớn hơn thời gian bắt đầu");
        }
        if( $timeDay<$timeStart){
            return redirect()->route('tickets.create')->with('error',"Thời gian đá hàng tuần phải lớn hơn hoặc bằng thời gian bắt đầu");
        }
        if($month == 1){
            if((abs(strtotime($timeEnd) - strtotime($timeStart))/(SECOND*MINUTE*24)) < 30 || (abs(strtotime($timeEnd) - strtotime($timeStart))/(SECOND*MINUTE*24)) > 30){
                return redirect()->route('tickets.create')->with('error',"Bạn đã trọn ".$month." tháng nên thời gian hiệu lực của vé phải là 31 ngày");
            }
        }elseif($month == 2){
            if((abs(strtotime($timeEnd) - strtotime($timeStart))/(SECOND*MINUTE*24)) < 60 || (abs(strtotime($timeEnd) - strtotime($timeStart))/(SECOND*MINUTE*24)) > 60){
                return redirect()->route('tickets.create')->with('error',"Bạn đã trọn ".$month." tháng nên thời gian hiệu lực của vé phải là 62 ngày");
            }
        }elseif($month == 3){
            if((abs(strtotime($timeEnd) - strtotime($timeStart))/(SECOND*MINUTE*24)) < 90 || (abs(strtotime($timeEnd) - strtotime($timeStart))/(SECOND*MINUTE*24)) > 90){
                return redirect()->route('tickets.create')->with('error',"Bạn đã trọn ".$month." tháng nên thời gian hiệu lực của vé phải là 93 ngày");
            }
        }
        //lấy phần tử cuối cùng trong mảng
        $ticketsTemp = Tickets::all()->toArray();
        $ticketsTemp = end($ticketsTemp);

        $detailTicket = new DetailTicket();
        $detailTicket->ticket_id = $ticketsTemp["id"]+1;
        $detailTicket->pitch_id = $request->pitch_id;
        $detailTicket->description = $request->describe;
        $detailTicket->sercive_id = $request->type_service;
        $detailTicket->start_time = $request->timeStart;
        $detailTicket->end_time = $request->timeEnd;
        $detailTicket->status = $request->get('status');
        
        $tickets = new Tickets();
        $tickets->user_id = 0;
        $tickets->name = $request->name;
        //avartar
        if ($request->hasFile('cover')) {
            $image = $request->file('cover');
            $filename = $tickets->name . '.' . 'jpg';
            $location = public_path('/images/tickets/' . $filename);
            Image::make($image)->resize(300, 200)->save($location);
            $tickets->image = $filename;
        } else {
            $path = $request->get('cover');
            $filename = $tickets->name . '.jpg';
            Image::make($path)->resize(350, 228)->save(public_path('/images/tickets' . $filename));
            $tickets->image = $filename;
        }
        $tickets->code_ticket = "D".$timeDay."M".$month."P".$detailTicket->pitch_id."-".$detailTicket->ticket_id;
        $tickets->number_day_of_week = $request->number_day;
        // $timeDay;
        $tickets->timeout = $request->timeOut;
        $tickets->price = $request->price;
        $tickets->month = $request->month;
        $tickets->discount = $request->discount;
        $tickets->status = $request->get('status');
        
        $detailTicket->save();
        if($tickets->save()){
            return redirect()->route('tickets.create')->with('success','Thêm vé mới thành công');
          }
           return redirect()->route('tickets.create')->with('error','Xử lí thêm thất bại');
    }
    public function edit($id)
    {
        $pitchs = Pitchs::where('id', $id)->first();
        return View('admin.set_pitch.edit',compact('pitchs'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'describe' => 'required|max:500',
        ],[
            'name.required'=>'Vui lòng nhập tên sân',
            'name.max'=>'Vui lòng nhập tên sân không quá 255 ký tự',
            'price.required'=>'Vui lòng nhập số điện thoại',
            'price.numeric'=>'Số điện thoại phải là số',
            'describe.required' => 'Vui lòng nhập thông tin',
            'describe.max'=>'Vui lòng nhập tên sân không quá 500 ký tự',
        ]);
        $pitch = Pitchs::where('id', $id)->first();

        $$detail_set_pitch = Detail_set_pitchs::all();
        $users = [];
        foreach($detail_set_pitch as $i => $detail){
            $users = User::where("id",$detail['user_id'])->first();
            $services = Services::where("id",$detail["service_id"])->first();
            $pitchs = Pitchs::where("id",$detail["picth_id"])->first();
            $detail['pitch_name'] = isset($pitchs['name']) ? $pitchs['name'] : "";
            $detail['username'] = isset($users['username']) ? $users['username'] : "";
            $detail['service_name'] = isset($services['name']) ? $services['name'] : "";
        }
        if($pitch->save()){
            return redirect()->route('pitchs.edit',['pitch'=>$pitch->id])->with('success','Cập nhật sân thành công');
          }
           return redirect()->route('pitchs.edit',['pitch'=>$pitch->id])->with('error','Xử lí cập nhật thất bại');
    }
}
