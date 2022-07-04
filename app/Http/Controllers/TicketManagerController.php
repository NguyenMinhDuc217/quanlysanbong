<?php

namespace App\Http\Controllers;

use App\Models\Pitchs;
use App\Models\Services;
use App\Models\Tickets;
use Illuminate\Http\Request;

class TicketManagerController extends Controller
{
    public function index()
    {
        $tickets = Tickets::all();

        return View('admin.ticket.index', compact('tickets'));
    }
    public function create()
    {
        $months = ['1','2','3','4','5','6','7','8','9','10','11','12'];
        $services = Services::all();
        $pitchs = Pitchs::all();
        return View('admin.ticket.create', compact('months', 'services','pitchs'));
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
            'timeStart' => 'required',
            'timeEnd' => 'required',
        ],[
            'name.required'=>'Vui lòng nhập tên vé',
            'name.max'=>'Vui lòng nhập tên vé không quá 255 ký tự',
            'describe.required' => 'Vui lòng nhập thông tin',
            'describe.max'=>'Vui lòng nhập tên sân không quá 500 ký tự',
            'price.required'=>'Vui lòng nhập giá',
            'price.numeric'=>'Giá phải là số',
            'number_day.required' => 'Vui lòng nhập số ngày',
            'number_day.digits'=>'Vui lòng nhập số ngày trong khoảng từ 1 đến 7',
            'timeStart.required'=>'Vui lòng chọn thời gian bắt đầu',
            'timeEnd.required'=>'Vui lòng thời gian kết thúc',
        ]);

        $timeStart=$request->timeStart;
        $timeEnd=$request->timeEnd;
        if( $timeEnd<$timeStart){
            return redirect()->route('tickets.create')->with('error',"Thời gian kết thúc phải lớn hơn thời gian bắt đầu");
        }
        

        $pitch = new Pitchs();
        $pitch->name = $request->name;
        $pitch->price = $request->price;
        $pitch->describe = $request->describe;
        //avartar
        if ($request->hasFile('cover')) {
            $image = $request->file('cover');
            $filename = $pitch->name . '.' . 'jpg';
            $location = public_path('/images/pitch/' . $filename);
            Image::make($image)->resize(350, 228)->save($location);
            $pitch->avartar = $filename;
        } else {
            $path = $request->get('cover');
            $filename = $request->appid . '.jpg';
            Image::make($path)->resize(350, 228)->save(public_path('/images/pitch' . $filename));
            $pitch->avartar = $filename;
        }
        $pitch->type_pitch = $request->get('type_pitch');
        $pitch->status = $request->get('status');
        $count_s = [];
        if ($request->hasFile('images')) {
            $screenshots = $request->file('images');

            foreach ($screenshots as $k => $v) {
                if ($v->isValid()) {
                    // $filename = $request->appid . '_up_' . $k . '.' . $v->extension();
                    $filename = $request->name . 'sc' . $k . '.' . 'jpg';
                    $v->move(public_path() . '/images/pitch/', $filename);
                    $count_s[] = $filename;
                }
            }
        }
        if (isset($request->preScreenshots) && count($request->preScreenshots) > 0) {
            if ($this->screenshot_save->value == 1) {
                foreach ($request->preScreenshots as $k => $v) {
                    if ($v->isValid()) {
                        // $filename = $request->appid . '_' . $k . '.' . $v->extension();
                        $filename = $request->name . '_sc' . $k . '.' . 'jpg';
                        Image::make($v)->save(public_path('images/pitch/' . $filename));
                        $count_s[] = $filename;
                    }
                }
            } else {
                $count_s = $request->preScreenshots;
            }
        }
        $pitch->screenshort = json_encode($count_s);
        if($pitch->save()){
            return redirect()->route('pitchs.create')->with('success','Thêm User mới thành công');
          }
           return redirect()->route('pitchs.create')->with('error','Xử lí thêm thất bại');
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
