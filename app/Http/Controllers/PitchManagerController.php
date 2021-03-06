<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseAdminController;
use App\Models\Detail_set_pitchs;
use App\Models\Pitchs;
use App\Models\Discount;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\ImageManagerStatic as Image;
// use Image;


class PitchManagerController extends BaseAdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $screenshot_save;

    /** Create a new controller instance. */
    public function __construct()
    {
        $this->screenshot_save = Setting::where('name', 'screenshot_save')->first();
    }

    public function index()
    {
        $pitchs = Pitchs::all();
        return View('admin.pitch.index', compact('pitchs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('admin.pitch.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'cover' => 'required',
                'name' => 'required|max:255',
                'price' => 'required|numeric',
                'describe' => 'required|max:500',
                // 'images' => ['required', 'mimes:jpg,jpeg,png,bmp,tiff', 'max:8192']
                'images' => ['required', 'max:8192']
            ],
            $messages = [
                'cover.required' => 'Vui lòng chọn hình ảnh đại diện',
                'name.required' => 'Vui lòng nhập tên sân',
                'name.max' => 'Vui lòng nhập tên sân không quá 255 ký tự',
                'price.required' => 'Vui lòng nhập giá sân',
                'price.numeric' => 'Giá sân phải là số',
                'describe.required' => 'Vui lòng nhập thông tin',
                'describe.max' => 'Vui lòng nhập thông tin sân không quá 500 ký tự',
                'screenshots.required' => 'Vui lòng chọn hình ảnh hoạt động',
                'images.required' => 'Vui lòng chọn hình ảnh hoạt động',
                // 'images.mimes' => 'Định dạng file chưa đúng',
                'images.max' => 'Vui lòng chọn hình ảnh dưới 8 MB',
            ]
        );
        // dd($request->file('images'));
        if ($validator->fails())   //check all validations are fine, if not then redirect and show error messages
        {
            return back()->withInput()->withErrors($validator);
        }
        $pitch = new Pitchs();
        if ($pitch->where('name', '=', $request->name)->exists()) {
            return redirect()->route('pitchs.create')->with('error', 'Tên sân đã tồn tại');
        }
        $pitch->name = $request->name;
        $pitch->price = $request->price;
        $pitch->describe = $request->describe;
        //avartar
        if ($request->hasFile('cover')) {
            $image = $request->file('cover');
            $filename = str_replace(' ', '', $pitch->name.'-'.Str::random(10). '.' . 'jpg');
            $location = public_path('/images/pitch/' . $filename);
            Image::make($image)->resize(350, 228)->save($location);
            $pitch->avartar = $filename;
        } else {
            $path = $request->get('cover');
            $filename = Str::random(10) . '.jpg';
            $filename = public_path('/images/pitch/' . $filename);
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
             $discount=new Discount();
             $discount->pitch_id=$pitch->id;
             $discount->ticket_id='';
             $discount->discount=0;
             $discount->start_discount=Carbon::now()->subDays(1)->format('Y-m-d');
             $discount->end_discount=Carbon::now()->subDays(1)->format('Y-m-d');
             $discount->save();

            return redirect()->route('pitchs.create')->with('success','Thêm sân mới thành công');
          }
           return redirect()->route('pitchs.create')->with('error','Xử lí thêm thất bại');
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
        $pitch = Pitchs::where('id', $id)->first();
        return View('admin.pitch.edit', compact('pitch'));
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
        ], [
            'name.required' => 'Vui lòng nhập tên sân',
            'name.max' => 'Vui lòng nhập tên sân không quá 255 ký tự',
            'price.required' => 'Vui lòng nhập giá sân',
            'price.numeric' => 'Giá sân phải là số',
            'describe.required' => 'Vui lòng nhập thông tin',
            'describe.max' => 'Vui lòng nhập tên sân không quá 500 ký tự',
        ]);

        $pitch = Pitchs::where('id', $id)->first();
        if ($pitch->where('name', '=', $request->name)->exists()) {
            return redirect()->route('pitchs.create')->with('error', 'Tên sân đã tồn tại');
        }
        $pitch->price = $request->price;
        $pitch->describe = $request->describe;
        $pitch->type_pitch = $request->get('type_pitch');
        $pitch->status = $request->get('status');
        if ($request->hasFile('cover')) {
            $image = $request->file('cover');
            $filename = $pitch->name . '.' . 'jpg';
            $location = public_path('/images/pitch/' . $filename);
            Image::make($image)->resize(350, 228)->save($location);
            $pitch->avartar = $filename;
        } else {
            // $path = $request->get('cover');
            $filename = $request->appid . '.jpg';
            // Image::make($path)->resize(350, 228)->save(public_path('/images/pitch' . $filename));
            $pitch->avartar = $filename;
        }
        $count_s = [];
        if ($request->hasFile('images')) {
            $screenshots = $request->file('images');
            foreach ($screenshots as $k => $v) {
                // $filename = $request->appid . '_up_' . $k . '.' . $v->extension();
                $filename = $request->name . 'sc' . $k . '.' . 'jpg';
                $location = public_path('images/pitch/' . $filename);
                Image::make($v)->resize(1152, 767.39)->save($location);
                // $v->move(public_path() . '/images/pitch/', $filename);
                $count_s[] = $filename;
            }
        }
        if (isset($request->preScreenshots) && count($request->preScreenshots) > 0) {
            foreach ($request->preScreenshots as $k => $v) {
                $count_s[] = $v;
            }
        }
        $pitch->screenshort = json_encode($count_s);

        if ($pitch->save()) {
            return redirect()->route('pitchs.edit', ['pitch' => $pitch->id])->with('success', 'Cập nhật sân thành công');
        }
        return redirect()->route('pitchs.edit', ['pitch' => $pitch->id])->with('error', 'Xử lí cập nhật thất bại');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $pitch = Pitchs::where('id',$request->pitch)->first();
        $detailSetPitch = Detail_set_pitchs::where('picth_id', $pitch->id)->get();
        if(!empty($detailSetPitch)){
            return redirect()->route('pitchs.index')->with('error', 'Không thể xoá sân');
        }
        dd($pitch);
        $pitch->delete();
        return redirect()->route('pitchs.index')->with('success', 'Xoá sân thành công');
    }
}
