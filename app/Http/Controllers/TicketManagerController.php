<?php

namespace App\Http\Controllers;

use App\Models\Detail_set_pitchs;
use App\Models\DetailTicket;
use App\Models\Notifications;
use App\Models\Pitchs;
use App\Models\Services;
use App\Models\Tickets;
use App\Models\User;
use App\Models\Discount;
use App\Models\SetService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
        return View('admin.ticket.create', compact('services', 'pitchs'));
    }
    public function store(Request $request)
    {
        // dd($request->ch_name,$request->ch_for);
        define('MINUTE', 60);
        define('HAFLANHOUR', 30);
        define('SECOND', 60);
        define('PERCENT', 100);
        $request->validate([
            'name' => 'required|max:255',
            'describe' => 'required|max:500',
            'number_day' => 'required|digits:1,7',
            'timeOut' => 'required',
            'timeStart' => 'required',
            'timeEnd' => 'required',
            'timeDay' => 'required',
        ], [
            'name.required' => 'Vui lòng nhập tên vé',
            'name.max' => 'Vui lòng nhập tên vé không quá 255 ký tự',
            'describe.required' => 'Vui lòng nhập thông tin',
            'describe.max' => 'Vui lòng nhập thông tin không quá 500 ký tự',
            'number_day.required' => 'Vui lòng nhập số ngày',
            'number_day.digits' => 'Vui lòng nhập số ngày trong khoảng từ 1 đến 7',
            'timeOut.required' => 'Vui lòng chọn thời gian hạn đặt vé',
            'timeStart.required' => 'Vui lòng chọn thời gian bắt đầu',
            'timeEnd.required' => 'Vui lòng thời gian kết thúc',
            'timeDay.required' => 'Vui lòng thời gian đá hàng tuần',
        ]);
        $now = Carbon::now()->format('Y-m-d');
        $month = $request->month;
        $timeOut = $request->timeOut;
        $timeStart = $request->timeStart;
        $timeEnd = $request->timeEnd;
        $timeDay = $request->timeDay;

    

        $timeStartDay = $request->timeDay;
        $timeEndDay = date('d-m-Y H:i:s', strtotime('+1 Hour', strtotime($request->timeDay)));

        $dayStart = date_format(date_create($timeStartDay), "d");
        $dayEnd = date_format(date_create($timeEndDay), "d");
        if ($dayStart < $dayEnd) {
            return response()->json(['status' => 401, 'error' => "Sân bóng hoạt động từ 7h00 đến 23h59"]);
        }

        $hourStart = date_format(date_create($timeStartDay), "H:i");
        $hourEnd = date_format(date_create($timeEndDay), "H:i");

        $timeStartNo = date('H:i', mktime(0, 0));
        $timeEndNo = date('H:i', mktime(7, 0));


        if ($timeStartNo <= $hourStart && $hourStart <= $timeEndNo) {
            return response()->json(['status' => 401, 'error' => "Sân bóng hoạt động từ 7h00 đến 23h59"]);
        }

        if ($timeStartNo <= $hourEnd && $hourEnd <= $timeEndNo) {
            return response()->json(['status' => 401, 'error' => "Sân bóng hoạt động từ 7h00 đến 23h59"]);
        }

        if ($timeStartNo <= $hourStart && $hourEnd <= $timeEndNo) {
            return response()->json(['status' => 401, 'error' => "Sân bóng hoạt động từ 7h00 đến 23h59"]);
        }

        if ($timeOut < $now) {
            return redirect()->route('tickets.create')->with('error', "Thời gian hạn đặt vé phải lớn hơn hoặc bầng thời gian hiện tại");
        }
        if ((abs(strtotime($timeStart) - strtotime($timeOut)) / (SECOND * MINUTE * 24)) < 3) {
            return redirect()->route('tickets.create')->with('error', "Thời gian hạn đặt vé phải lớn hơn thời gian bắt đầu 3 ngày");
        }
        if ($timeEnd < $timeStart) {
            return redirect()->route('tickets.create')->with('error', "Thời gian kết thúc phải lớn hơn thời gian bắt đầu");
        }
        if ($timeDay < $timeStart) {
            return redirect()->route('tickets.create')->with('error', "Thời gian đá hàng tuần phải lớn hơn hoặc bằng thời gian bắt đầu");
        }
        if ($month == 1) {
            if ((abs(strtotime($timeEnd) - strtotime($timeStart)) / (SECOND * MINUTE * 24)) < 30 || (abs(strtotime($timeEnd) - strtotime($timeStart)) / (SECOND * MINUTE * 24)) > 30) {
                return redirect()->route('tickets.create')->with('error', "Bạn đã trọn " . $month . " tháng nên thời gian hiệu lực của vé phải là 31 ngày");
            }
        } elseif ($month == 2) {
            if ((abs(strtotime($timeEnd) - strtotime($timeStart)) / (SECOND * MINUTE * 24)) < 60 || (abs(strtotime($timeEnd) - strtotime($timeStart)) / (SECOND * MINUTE * 24)) > 60) {
                return redirect()->route('tickets.create')->with('error', "Bạn đã trọn " . $month . " tháng nên thời gian hiệu lực của vé phải là 62 ngày");
            }
        } elseif ($month == 3) {
            if ((abs(strtotime($timeEnd) - strtotime($timeStart)) / (SECOND * MINUTE * 24)) < 90 || (abs(strtotime($timeEnd) - strtotime($timeStart)) / (SECOND * MINUTE * 24)) > 90) {
                return redirect()->route('tickets.create')->with('error', "Bạn đã trọn " . $month . " tháng nên thời gian hiệu lực của vé phải là 93 ngày");
            }
        }
        $pitchs = Pitchs::where('id', $request->pitch_id)->first();
        //lấy từng dịch vụ
        $services = [];
        // if($request->ch_name == null){

        // }
        foreach ($request->ch_name as $i => $id_service) {
            $service = Services::where('id', $id_service)->first();
            $services[$i] = $service;
        }

        $tickets = new Tickets();
        $tickets->user_id = 0;
        $tickets->name = $request->name;
        //avartar
        if ($request->hasFile('cover')) {
            $image = $request->file('cover');
            $filename = Str::random(12). '.' . 'jpg';
            $location = public_path('/images/tickets/' . $filename);
            Image::make($image)->resize(300, 200)->save($location);
            $tickets->image = $filename;
        } else {
            $path = $request->get('cover');
            $filename = $tickets->name . '.jpg';
            Image::make($path)->resize(350, 228)->save(public_path('/images/tickets' . $filename));
            $tickets->image = $filename;
        }
        $tickets->code_ticket = "D" . date('d', strtotime($timeDay)) . "M" . date('m', strtotime($month)) . "P" . $request->pitch_id . "-" . $tickets->id;
        $tickets->number_day_of_week = $request->number_day;
        $tickets->timeout = $request->timeOut;
        // $tickets->price = $pitchs["price"] * $request->number_day * $request->month * 4;
        $tickets->price = 0;
        $tickets->month = $request->month;
        $tickets->status = $request->get('status');
        $tickets->save();
        $tickets->code_ticket = "D" . date('d', strtotime($timeDay)) . "M" . date('m', strtotime($month)) . "P" . $request->pitch_id . "-" . $tickets->id;


        //lấy phần tử cuối cùng trong mảng
        // $ticketsTemp = Tickets::all()->toArray();
        // $ticketsTemp = end($ticketsTemp);

        $detailTicket = new DetailTicket();
        $detailTicket->ticket_id = $tickets->id;
        $detailTicket->pitch_id = $request->pitch_id;
        $detailTicket->description = $request->describe;
        $detailTicket->sercive_id = '';
        $detailTicket->start_time = $request->timeStart;
        $detailTicket->end_time = $request->timeEnd;
        $detailTicket->status = $request->get('status');

        $timeDaystart = $timeDay;
        $timeDayend = date('d-m-Y H:i:s', strtotime('+1 Hour', strtotime($timeDay)));

        $times[0]['timeDaystart'] = date('Y-m-d H:i:s', (strtotime($timeDaystart)));
        $times[0]['timeDayend'] = date('Y-m-d H:i:s', (strtotime($timeDayend)));

        $a = date('Y-m-d H:i:s', strtotime('+7 day', strtotime($timeDaystart)));
        $b = date('Y-m-d H:i:s', strtotime('+7 day', strtotime($timeDayend)));
        for ($i = 1; $i <= 3; $i++) {
            $times[$i]['timeDaystart'] = $a;
            $times[$i]['timeDayend'] = $b;
            $a = date('Y-m-d H:i:s', strtotime('+7 day', strtotime($a)));
            $b = date('Y-m-d H:i:s', strtotime('+7 day', strtotime($b)));
        }
        foreach ($times as $time) {
            $timeStart = $time['timeDaystart'];
            $timeEnd = $time['timeDayend'];
            $pitch = Pitchs::where('id', $detailTicket->pitch_id)->where('status', '1')->first();
            if ($pitch == null) {
                return redirect()->route('detail.pitch', ['pitchid' => $pitch->id])->with('error', "Không tìm thấy sân");
            }

            $timeSoccer = (strtotime($timeEnd) - strtotime($timeStart)) / (MINUTE * SECOND);

            $checkTimes = Detail_set_pitchs::where('picth_id', $detailTicket->pitch_id)->where(function ($query) use ($timeStart, $timeEnd) {
                $query->where('start_time', '<=', $timeStart)->where('end_time', '>=', $timeEnd);
            })->get();


            if ($checkTimes->count() == 0) {
                $checkTimes = Detail_set_pitchs::where('picth_id', $detailTicket->pitch_id)->where(function ($query) use ($timeStart, $timeEnd) {
                    $query->whereBetween('start_time', [$timeStart, $timeEnd])->orwhereBetween('end_time', [$timeStart, $timeEnd]);
                })->get();
            }

            if ($checkTimes->count() > 0) {
                foreach ($checkTimes as $checkTime) {
                    $setTimeStart = $checkTime->start_time;
                    $setTimeEnd = $checkTime->end_time;
                }
                return redirect()->route('tickets.create')->with('error', "Sân đã được đặt từ $setTimeStart đến $setTimeEnd");
            }
        }
        $detailTicket->detail_time_of_week = json_encode($times);

        // lưu thông tin vô bảng detail set pitch
        foreach ($times as $time) {
            $detail_set_pitch[] = array(
                'ticket_id' => $detailTicket->ticket_id,
                'picth_id' => $detailTicket->pitch_id,
                'user_id' => 0,
                'date_event' => date('Y-m-h', strtotime($timeDay)),
                'start_time' => $time["timeDaystart"],
                'end_time' => $time["timeDayend"],
                'price_pitch' => $pitchs["price"],
                'total' => $pitchs["price"],
                'ispay' => '0',
            );
        }
        Detail_set_pitchs::insert($detail_set_pitch);

        $checkDetailSetPitch = Detail_set_pitchs::where('ticket_id', $tickets->id)->get();
        foreach ($checkDetailSetPitch as $detailSetPitch) {
            if ($request->ch_name != null) {
                foreach ($request->ch_name as $server_id) {
                    $service = Services::where('id', $server_id)->first();
                    $setService = new SetService();
                    $setService->ticket_id = $tickets->id;
                    $setService->set_pitch_id = $detailSetPitch['id'];
                    $setService->service_id = $server_id;
                    $setService->name = $service->name;
                    $setService->quantity = $request->ch_for[$server_id][0];
                    if ($service->type == 1) {
                        $setService->total = $request->ch_for[$server_id][0] * $timeSoccer * $service->price;
                    } else {
                        $setService->total = $request->ch_for[$server_id][0] * $service->price;
                    }
                    $setService->save();
                }
            }
            $checkSetService = SetService::where('set_pitch_id', $detailSetPitch['id'])->get();
            $totalService = 0;
            foreach ($checkSetService as $setService) {
                $totalService = $totalService + $setService['total'];
            }
            $detailSetPitch->update([
                'total' => $detailSetPitch['price_pitch'] + $totalService,
            ]);
            $detailSetPitch->save();
            $tickets->price = $tickets->price + $detailSetPitch['total'];
        }
        $detailTicket->save();

        $notification = new Notifications();
        $notification->title = 'Vé ' . $tickets->name . ' mới được tạo';
        $notification->content = 'Với mức giá chỉ ' . number_format($tickets->price) . ' vnd bạn đã có thể sở hữu chiếc vé "' . $tickets->name . '" có mã là "' . $tickets->code_ticket . '" có thời hạn từ ' . date('d-m-Y', strtotime($detailTicket->start_time)) . ' đến ' . date('d-m-Y', strtotime($detailTicket->end_time)) . ' để có thể thoả mãn đam mê với trái bóng tròn của mình';
        $notification->save();

        if ($tickets->save()) {         
            $discount=new Discount();
            $discount->pitch_id='';
            $discount->ticket_id=$tickets->id;
            $discount->discount=0;
            $discount->start_discount=Carbon::now()->subDays(1)->format('Y-m-d');
            $discount->end_discount=Carbon::now()->subDays(1)->format('Y-m-d');
            $discount->save();
            return redirect()->route('tickets.create')->with('success', 'Thêm vé mới thành công');
        }
        return redirect()->route('tickets.create')->with('error', 'Xử lí thêm thất bại');
    }

    public function edit($id)
    {
        $services = Services::all();
        $pitchs = Pitchs::all();
        $tickets = Tickets::where('id',$id)->first();
        $detailTicket = DetailTicket::where('ticket_id',$tickets->id)->first();
        $detail_set_pitch = Detail_set_pitchs::where('ticket_id', $tickets->id)->get();
        // $setService = SetService::where('set_pitch_id', )
        return View('admin.ticket.edit', compact('services', 'pitchs'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'describe' => 'required|max:500',
        ], [
            'name.required' => 'Vui lòng nhập tên sân',
            'name.max' => 'Vui lòng nhập tên sân không quá 255 ký tự',
            'price.required' => 'Vui lòng nhập số điện thoại',
            'price.numeric' => 'Số điện thoại phải là số',
            'describe.required' => 'Vui lòng nhập thông tin',
            'describe.max' => 'Vui lòng nhập tên sân không quá 500 ký tự',
        ]);
        $pitch = Pitchs::where('id', $id)->first();

        $$detail_set_pitch = Detail_set_pitchs::all();
        $users = [];
        foreach ($detail_set_pitch as $i => $detail) {
            $users = User::where("id", $detail['user_id'])->first();
            $services = Services::where("id", $detail["service_id"])->first();
            $pitchs = Pitchs::where("id", $detail["picth_id"])->first();
            $detail['pitch_name'] = isset($pitchs['name']) ? $pitchs['name'] : "";
            $detail['username'] = isset($users['username']) ? $users['username'] : "";
            $detail['service_name'] = isset($services['name']) ? $services['name'] : "";
        }
        if ($pitch->save()) {
            return redirect()->route('pitchs.edit', ['pitch' => $pitch->id])->with('success', 'Cập nhật sân thành công');
        }
        return redirect()->route('pitchs.edit', ['pitch' => $pitch->id])->with('error', 'Xử lí cập nhật thất bại');
    }
}
