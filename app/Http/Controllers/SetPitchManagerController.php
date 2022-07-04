<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseAdminController;
use App\Models\Detail_set_pitchs;
use App\Models\Pitchs;
use App\Models\Services;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
// use Image;


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
        $detail_set_pitch = Detail_set_pitchs::all();
        $users = [];
        foreach($detail_set_pitch as $i => $detail){
            $users = User::where("id",$detail['user_id'])->first();
            $services = Services::where("id",$detail["service_id"])->first();
            $pitchs = Pitchs::where("id",$detail["picth_id"])->first();
            $detail['pitch_name'] = isset($pitchs['name']) ? $pitchs['name'] : "";
            $detail['username'] = isset($users['username']) ? $users['username'] : "";
            $detail['service_name'] = isset($services['name']) ? $services['name'] : "";
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pitchs = Pitchs::where('id', $id)->first();
        return View('admin.set_pitch.edit',compact('pitchs'));
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
