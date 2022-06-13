<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PitchRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Pitchs;

class PitchRepository implements PitchRepositoryInterface
{
    public function ListPitch(Request $request)
    {
        // $pitch = new Pitchs();
        // $pitch = Pitchs::all();
        $pitch = Pitchs::orderby('average_rating','DESC')->paginate(8)->appends(request()->query());
        // dd($page);
        return $pitch;
    }
}