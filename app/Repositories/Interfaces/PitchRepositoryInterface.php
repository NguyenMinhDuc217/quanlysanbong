<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;
use App\Repositories\PitchRepository;

interface PitchRepositoryInterface
{
    public function ListPitch(Request $request);
}