<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;
use App\Repositories\SetPitchRepository;

interface SetPitchRepositoryInterface
{
    public function setPitch(Request $request,$pitchid);
}