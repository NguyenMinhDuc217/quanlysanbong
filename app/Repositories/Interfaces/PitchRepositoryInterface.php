<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;
use App\Repositories\PitchRepository;

interface PitchRepositoryInterface
{
    public function ListPitch(Request $request);
    public function Search(Request $request);
    public function DetailPitch($pitchid);
    public function Comment(Request $request, $pitchid);
}