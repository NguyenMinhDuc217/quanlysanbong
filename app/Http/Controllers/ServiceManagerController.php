<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Services;
use App\Models\SetService;
use League\OAuth1\Client\Server\Server;

class ServiceManagerController extends BaseAdminController
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services=Services::all();
        return view('admin.service.index',compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.service.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nameservice' => 'required|unique:services,name',
            'price' => 'required|numeric',
            'type'=>'required'
        ],[
            'nameservice.required'=>'Vui lòng nhập tên dịch vụ',
            'nameservice.unique'=>'Tên dịch vụ đã tồn tại',
            'price.required'=>'Vui lòng nhập giá',
            'price.numeric'=>'Giá phải là số',
            'type.required'=>'Loại không thể để trống'
        ]);
        $service = new Services();
        $service->name = $request->nameservice;
        $service->price = $request->price;
        $service->type = $request->type;
      if($service->save()){
        return redirect()->route('services.create')->with('success','Thêm dịch vụ mới thành công');
      }
       return redirect()->route('services.create')->with('error','Xử lí thêm thất bại');
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
        $services = Services::find($id);

        if ($services == null) {
            abort(404);
        }

        return view('admin.service.edit', compact('services'));
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
            'nameservice' => 'required',
            'price' => 'required|numeric',
            'type'=>'required'
        ],[
            'nameservice.required'=>'Vui lòng nhập tên dịch vụ',
            'price.required'=>'Vui lòng nhập giá',
            'price.numeric'=>'Giá phải là số',
            'type.required'=>'Loại không thể để trống'
        ]);
        $service =Services::find($id);
        $service->name = $request->nameservice;
        $service->price = $request->price;
        $service->type = $request->type;
      if($service->save()){
        return redirect()->route('services.index')->with('success','Sửa dịch vụ thành công');
      }
       return redirect()->route('services.index')->with('error','Xử lí sửa dịch vụ thất bại');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
            if(SetService::where('id', $request->id)->exists()){
                return redirect()->route('services.index')->with('error','Dịch vụ đang được đặt không thể xóa!');
            }
            
            Services::where('id', $request->id)->delete();
            return redirect()->route('services.index')->with('success','Xóa dịch vụ thành công');
        
    }
}
