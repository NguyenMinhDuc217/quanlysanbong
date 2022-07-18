<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\PitchRepositoryInterface;

class PitchController extends Controller
{
    private $pitchRepository;
    public function __construct(PitchRepositoryInterface $pitchRepository)
    {
        $this->pitchRepository = $pitchRepository;
    }
    public function ListPitch(Request $request){
        $pitchs = $this->pitchRepository->ListPitch($request);
        $discounts=[];
        foreach(Discount::all() as $discount){
            $discounts[$discount->pitch_id]=$discount;
        }
        return view('pitchs.index', compact('pitchs','discounts'));
    }
    public function Search(Request $request){
        $pitchs = $this->pitchRepository->Search($request);
        $discounts=[];
        foreach(Discount::all() as $discount){
            $discounts[$discount->pitch_id]=$discount;
        }
        return view('pitchs.search', compact('pitchs','discounts'));
    }
    public function DetailPitch($pitchid){
        $data = $this->pitchRepository->DetailPitch($pitchid);
        return view('detailpitch.index', array('data'=>$data));
    }
    public function commentAjax(Request $request, $id = ''){
        return $comment = $this->pitchRepository->Comment($request, $id);
    }
    public function sendPhone(Request $request){
        return $this->pitchRepository->sendPhone($request);
    }

}
