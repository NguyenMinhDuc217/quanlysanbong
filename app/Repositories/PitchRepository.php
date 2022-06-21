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
        return $pitch;
    }
}