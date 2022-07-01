<?php

namespace App\Http\Controllers;

use App\Models\Pitchs;
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
        // return view('layouts.home', ['listPitch' => $listPitch]);
        return view('pitchs.index', compact('pitchs'));
    }
    public function Search(Request $request){
        $pitchs = $this->pitchRepository->Search($request);
        return view('pitchs.search', compact('pitchs'));
    }
    public function DetailPitch($pitchid){
        $data = $this->pitchRepository->DetailPitch($pitchid);
        return view('detailpitch.index', array('data'=>$data));
    }
    public function commentAjax(Request $request, $id = ''){
        return $comment = $this->pitchRepository->Comment($request, $id);
    }
}
