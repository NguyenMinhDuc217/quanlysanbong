<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discount;
use App\Models\Pitchs;
use App\Models\Tickets;
use Carbon\Carbon;

class DiscountManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discounts=Discount::orderby('created_at','DESC')->get();
        $pitchs=[];
        $tickets=[];
        foreach(Pitchs::all() as $pitch){
            $pitchs[$pitch->id]=$pitch;
        }
        foreach(Tickets::all() as $ticket){
            $tickets[$ticket->id]=$ticket;
        }
        return view('admin.discount.index',compact('discounts','pitchs','tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $discounts = Discount::find($id);
        $pitchs=[];
        $tickets=[];
        foreach(Pitchs::all() as $pitch){
            $pitchs[$pitch->id]=$pitch;
        }
        foreach(Tickets::all() as $ticket){
            $tickets[$ticket->id]=$ticket;
        }
        if ($discounts == null) {
            abort(404);
        }

        return view('admin.discount.edit', compact('discounts','pitchs','tickets'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'discount' => 'required|min:0|max:100',
            'datestart' => 'required',
            'dateend' => 'required',

        ],[
            'discount.required'=>'Vui lòng nhập khuyến mãi',
            'discount.min'=>'Giá trị nhỏ nhất là 0',
            'discount.max'=>'Giá trị lớn nhất 100',
            'datestart.required'=>'Vui lòng nhập ngày bắt đầu',
            'dateend.required'=>'Vui lòng nhập ngày kết thúc',
        ]);

        $discount = Discount::find($id);
        if ($discount == null) {
            abort(404);
        }
        $timeStart=$request->datestart;
        $timeEnd=$request->dateend;

        if($timeStart>$timeEnd){
            return redirect()->route('discounts.index')->with('error','Thời gian kết thúc phải lớn hơn thời gian bắt đầu');
        }

        if(Carbon::now()->format('d/m/Y')>$timeStart||Carbon::now()->format('d/m/Y')>$timeEnd){
            return redirect()->route('discounts.index')->with('error','Thời gian khuyến mãi phải lớn hơn thời gian hiện tại');
        }
        $discount->discount=$request->discount;
        $myDateStart=date('Y-m-d', strtotime($timeStart));
        $myDateEnd= date('Y-m-d', strtotime($timeEnd));
        $discount->start_discount=$myDateStart;
        $discount->end_discount=$myDateEnd;
        if($discount->save()){
            return redirect()->route('discounts.index')->with('success','Sửa khuyến mãi thành công');
          }
           return redirect()->route('discounts.index')->with('error','Xử lí sửa khuyến mãi thất bại');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function showUpdatePitch()
    {
        $pitchs=Pitchs::where('status',1)->get();
        return view('admin.discount.discount-pitch',compact('pitchs'));
    }
    public function updatePitch(Request $request)
    {
       
     
        $request->validate([
            'discount' => 'required|min:0|max:100',
            'datestart' => 'required',
            'dateend' => 'required',
        ],[
            'discount.required'=>'Vui lòng nhập khuyến mãi',
            'discount.min'=>'Giá trị nhỏ nhất là 0',
            'discount.max'=>'Giá trị lớn nhất 100',
            'datestart.required'=>'Vui lòng nhập ngày bắt đầu',
            'dateend.required'=>'Vui lòng nhập ngyaf kết thúc',
        ]);

        $timeStart=$request->datestart;
        $timeEnd=$request->dateend;
        
        $checkDateStart=date('d/m/Y', strtotime($timeStart));
        $checkDateEnd= date('d/m/Y', strtotime($timeEnd));
        if($timeStart>$timeEnd){
            return redirect()->route('show.discount.pitch')->with('error','Thời gian kết thúc phải lớn hơn thời gian bắt đầu');
        }

        if(Carbon::now()->format('d/m/Y')>$checkDateStart||Carbon::now()->format('d/m/Y')>$checkDateEnd){
            return redirect()->route('show.discount.pitch')->with('error','Thời gian khuyến mãi phải lớn hơn thời gian hiện tại');
        }

        $myDateStart=date('Y-m-d', strtotime($timeStart));
        $myDateEnd= date('Y-m-d', strtotime($timeEnd));

        $discounts = Discount::where('pitch_id','!=','')->get();
        if(empty($request->namepitc)){
            return redirect()->route('show.discount.pitch')->with('error','Bạn chưa chọn sân để khuyến mãi');
        }

        foreach($discounts as $discount){
            foreach($request->namepitch as $id){
                if($discount->pitch_id==$id){
                    $discount->pitch_id=$id;
                    $discount->ticket_id='';
                    $discount->discount=$request->discount;
                    $discount->start_discount=$myDateStart;
                    $discount->end_discount=$myDateEnd;
                    $discount->save();
                }
            
            }
        }
    
        return redirect()->route('discounts.index')->with('success','Tạo khuyến mãi thành công');

    }

    public function showUpdateTicket()
    {
        $tickets=Tickets::where('status',1)->where('ispay','!=',1)->get();
        return view('admin.discount.discount-ticket',compact('tickets'));
    }
    public function updateTicket(Request $request)
    {
       
        $request->validate([
            'discount' => 'required|min:0|max:100',
            'datestart' => 'required',
            'dateend' => 'required',
        ],[
            'discount.required'=>'Vui lòng nhập khuyến mãi',
            'discount.min'=>'Giá trị nhỏ nhất là 0',
            'discount.max'=>'Giá trị lớn nhất 100',
            'datestart.required'=>'Vui lòng nhập ngày bắt đầu',
            'dateend.required'=>'Vui lòng nhập ngyaf kết thúc',
        ]);

        $timeStart=$request->datestart;
        $timeEnd=$request->dateend;
        
        $checkDateStart=date('d/m/Y', strtotime($timeStart));
        $checkDateEnd= date('d/m/Y', strtotime($timeEnd));
        if($timeStart>$timeEnd){
            return redirect()->route('show.discount.pitch')->with('error','Thời gian kết thúc phải lớn hơn thời gian bắt đầu');
        }

        if(Carbon::now()->format('d/m/Y')>$checkDateStart||Carbon::now()->format('d/m/Y')>$checkDateEnd){
            return redirect()->route('show.discount.pitch')->with('error','Thời gian khuyến mãi phải lớn hơn thời gian hiện tại');
        }

        $myDateStart=date('Y-m-d', strtotime($timeStart));
        $myDateEnd= date('Y-m-d', strtotime($timeEnd));

        $discounts = Discount::where('ticket_id','!=','')->get();
   
        if(empty($request->nameticket)){
            return redirect()->route('show.discount.pitch')->with('error','Bạn chưa chọn sân để khuyến mãi');
        }

        foreach($discounts as $discount){
            foreach($request->nameticket as $id){
                if($discount->ticket_id==$id){
                    $discount->ticket_id=$id;
                    $discount->pitch_id='';
                    $discount->discount=$request->discount;
                    $discount->start_discount=$myDateStart;
                    $discount->end_discount=$myDateEnd;
                    $discount->save();
                }
            
            }
        }
    
        return redirect()->route('discounts.index')->with('success','Tạo khuyến mãi thành công');

    }
}
