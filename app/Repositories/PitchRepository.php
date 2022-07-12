<?php

namespace App\Repositories;

use App\Models\Comments;
use App\Models\Detail_set_pitchs;
use App\Repositories\Interfaces\PitchRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Pitchs;
use App\Models\Services;
use App\Models\User_comments;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

class PitchRepository implements PitchRepositoryInterface
{
    public function ListPitch(Request $request)
    {
        $pitch = Pitchs::orderby('average_rating','DESC')->paginate(8)->appends(request()->query());
        return $pitch;
    }
    public function Search(Request $request){
        $key = $request->key;
        $pitch = new Pitchs();
        if(!empty($key)){
            $pitch = $pitch->where('name','like','%'.($key).'%');
        }
        $pitch = $pitch->paginate(8)->appends(request()->query());
        return $pitch;
    }
    public function DetailPitch($pitchid = ''){
        $pitch = Pitchs::where('id',$pitchid)->first();
        $comments = Comments::where('picth_id', $pitchid)->get()->toArray();
        
        if (!empty(Auth::guard('user')->user()->id)) {
            foreach ($comments as &$c) {
               $userComment = User_comments::where('comment_id', $c["id"])->where('user_id', Auth::guard('user')->user()->id)->first();
            //    dd(!empty($userComment['status']) ? $userComment['status'] :'');
            $c["created_at"] = strtotime($c["created_at"]);
            $c["status"] = (!empty($userComment['status'])) ? $userComment['status'] :"";
            }
        }
        //lấy lượt đánh giá của từng sao
        $ratings = [];
        for ($stars = 1; $stars <= 5; $stars++) {
            $check = Comments::where('picth_id', $pitch['id'])->where('rating', $stars)->get();
            if (!isset($check)) {
                $ratings[$stars] = 0;
            } else {
                $ratings[$stars] = $check->count();
            }
        }

        $user = Auth::guard('user')->user();

        $services = Services::all()->toArray();

        //lấy thời gian và tình trạng sân trong ngày hôm đó
        $now = Carbon::now();

        $detail_set_pitchs = Detail_set_pitchs::where('picth_id',$pitchid)->where(function ($query) use ($now) {
            $query->whereDate('start_time','<=',$now)->orwhereDate('end_time','>=', $now);
        })->get();
        foreach($detail_set_pitchs as $detail){
            $detail['start_time'] = substr($detail['start_time'],11,8);
            $detail['end_time'] = substr($detail['end_time'],11,8);
            
        }
        return array(
            'pitch' => $pitch,
            'comments' => $comments,
            'ratings' => $ratings,
            'user' => $user,
            'services' => $services,
            'detail_set_pitchs' => $detail_set_pitchs,
            // 'start_time' => $start_time,
        );
    }
    public function Comment(Request $request,$id = ''){
        $validator = Validator::make($request->all(), [
            'comment' => 'required|string|max:255',
        ], [
            'comment.required' => "Vui lòng nhập nội dung",
            'comment.max' => "Vui lòng nhập không quá :max ký tự",
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()->all()]);
        }
        $pitch = Pitchs::where('id', $id)->first();
        if (empty($pitch)) {
            return response()->json(['status' => 400, 'error' => "Sân không tồn tại"]);
        }
        //nếu chưa đăng nhập
        if (empty(Auth::guard('user')->user()->id)) {
            // return redirect()-route('show.login')->with('error', 'Vui đăng nhập');
            $comment = new Comments();
            $comment->picth_id = $pitch['id'];
            $comment->user_id = 0;
            $comment->name = "user" . "" . rand(0, 10) . "" . Str::random(5);
            $comment->content = $request->get('comment');
            if (empty($request->get('rating'))) {
                $comment->rating = 1;
            } else {
                $comment->rating = $request->get('rating');
            }
            $comment->like = "";
            $comment->dislike = "";
            $comment->save();

            //cập nhật numberVoters, score vô trong application đó
            $idpitch = $pitch['id'];
            $argscore = round(Comments::where('picth_id', $idpitch)->avg('rating'), 1);
            $countcomment = Comments::where('picth_id', $idpitch)->get()->count();
            $pitch['total_rating'] = $countcomment;
            $pitch['average_rating'] = $argscore;
            $pitch->save();
        }
        //nếu đã đăng nhập
        else{
            $check = Comments::where('picth_id', $pitch['id'])->where('user_id', Auth::guard('user')->user()->id)->first();
            $comment = [];
            if(empty($check)){
                $comment = new Comments();
                $comment->picth_id = $pitch['id'];
                $comment->user_id = Auth::guard('user')->user()->id;
                $comment->name = Auth::guard('user')->user()->username;
                $comment->content = $request->get('comment');
                if (empty($request->get('rating'))) {
                    $comment->rating = 1;
                } else {
                    $comment->rating = $request->get('rating');
                }
                $comment->like = "";
                $comment->dislike = "";
                $comment->save();
                //cập nhật numberVoters, score vô trong application đó
                $idpitch = $pitch['id'];
                $argscore = round(Comments::where('picth_id', $idpitch)->avg('rating'), 1);
                $countcomment = Comments::where('picth_id', $idpitch)->get()->count();
                $pitch['total_rating'] = $countcomment;
                $pitch['average_rating'] = $argscore;
                $pitch->save();
            }
            //nếu đã comment -> sửa comment
            else{
                $check->content = $request->get('comment');
                $ratingtemp = $check['rating'];
                if (empty($request->get('rating'))) {
                    //nếu rating trong db đang là 1 thì -1
                    if ($check->rating == 1) {
                        $pitch['one'] = $pitch['one'] - 1;
                        $pitch->save();
                    }
                    //nếu rating trong db khác 1 thì -1 count của rating đó
                    else {
                        if ($check->rating == 5) {
                            $pitch['five'] = $pitch['five'] - 1;
                        } elseif ($check->rating == 4) {
                            $pitch['four'] = $pitch['four'] - 1;
                        } elseif ($check->rating == 3) {
                            $pitch['three'] = $pitch['three'] - 1;
                        } elseif ($check->rating == 2) {
                            $pitch['two'] = $pitch['two'] - 1;
                        } elseif ($check->rating == 1) {
                            $pitch['one'] = $pitch['one'] - 1;
                        }
                        $check->rating = 1;
                    }
                }
                else {
                    //giảm count rating của rating cũ
                    if ($check->rating == 5) {
                        $pitch['five'] = $pitch['five'] - 1;
                    } elseif ($check->rating == 4) {
                        $pitch['four'] = $pitch['four'] - 1;
                    } elseif ($check->rating == 3) {
                        $pitch['three'] = $pitch['three'] - 1;
                    } elseif ($check->rating == 2) {
                        $pitch['two'] = $pitch['two'] - 1;
                    } elseif ($check->rating == 1) {
                        $pitch['one'] = $pitch['one'] - 1;
                    }
                    $pitch->save();
                    
                    $check->name = Auth::guard('user')->user()->username;
                    $check->rating = $request->get('rating');
                }
                $check->save();
                $comment = $check;
                $comment->save();
                //cập nhật numberVoters, score vô trong application đó
                $idpitch = $pitch['id'];
                $argscore = round(Comments::where('picth_id', $idpitch)->avg('rating'), 1);
                $countcomment = Comments::where('picth_id', $idpitch)->get()->count();
                $pitch['total_rating'] = $countcomment;
                $pitch['average_rating'] = $argscore;
                $pitch->save();
            }
        }
        //tăng count rating của rating mới
        if ($comment->rating == 5) {
            $pitch['five'] = $pitch['five'] + 1;
        } elseif ($comment->rating == 4) {
            $pitch['four'] = $pitch['four'] + 1;
        } elseif ($comment->rating == 3) {
            $pitch['three'] = $pitch['three'] + 1;
        } elseif ($comment->rating == 2) {
            $pitch['two'] = $pitch['two'] + 1;
        } elseif ($comment->rating == 1) {
            $pitch['one'] = $pitch['one'] + 1;
        }
        $pitch->save();
        return response()->json(['status' => 200, 'success' => "thành công", "comment" => $comment]);
    }

    public function sendPhone(Request $request){
        define('EMAIL','quanlysanbong247@gmail.com');
        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric|digits:10',
        ], [
            'phone.required'=>'Vui lòng nhập số điện thoại',
            'phone.numeric'=>'Số điện thoại phải là số',
            'phone.digits' => 'Số điện thoại không hợp lệ',
        ]);
   
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()->all()]);
        }

        $subject =null;
        $details = [
            'title' => 'Số điện thoại của khách, vui lòng liên hệ với số điện thoại:',
            'name' => 'Admin',
            'body'=>$request->phone,
        ];

        Mail::to(EMAIL)->send(new SendMail($details, $subject));
            return response()->json(['status'=> 200,'success'=>'Số điện thoại của bạn đã chuyển đến admin, vui lòng chờ sự phản hồi']);
          
    }
}