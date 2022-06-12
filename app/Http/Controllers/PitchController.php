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
        $listPitch = $this->pitchRepository->ListPitch($request);
        // return view('layouts.home', ['listPitch' => $listPitch]);
        return view('pitchs.index', ['listPitch' => $listPitch]);
    }
}
