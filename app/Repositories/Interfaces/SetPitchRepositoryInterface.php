<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;
use App\Repositories\SetPitchRepository;

interface SetPitchRepositoryInterface
{
    public function setPitch(Request $request,$pitchid);
    public function listSetPitch();
    public function deleteSetPitch(Request $request);
}