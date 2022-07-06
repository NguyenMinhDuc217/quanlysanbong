<?php

namespace App\Repositories;

use App\Repositories\Interfaces\TeamRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Teams;
use Illuminate\Support\Facades\Auth;
class TeamRepository implements TeamRepositoryInterface
{
   public function showCreateTeam(){
     return view('create-team.index');
   }
   public function createTeam(Request $request){
        $request->validate(
            [
                'teamname' => 'required',
                'member' => 'required',
                'link' => 'required',
            ],[
                'teamname.required' => 'Tên đội không được để trống',
                'member.required' => 'Thành viên không được để trống',
                'link.required' => 'Link không được để trống',
            ]
           );
   if (Teams::where('team_name', '=', $request->teamname)->exists()) {
            return redirect()->route('show.create.team')->with('error',"Tên đội đã được tạo");
        } 
     $team=new Teams();
     $team->user_name=Auth::guard('user')->user()->username;
     $team->team_name=$request->teamname;
     $team->team_member=$request->member;
     $team->link=$request->link;
     if(!$team->save()){
        return redirect()->route('show.create.team')->with('error',"Tạo đội thất bại");
     }
    return redirect()->route('show.create.team')->with('success',"Tạo đội thành công");
  }
  public function listTeam(){
      $teams=Teams::orderby('id','DESC')->paginate(5)->appends(request()->query());
      return view('list-team.index',compact('teams'));
  }

  public function searchTeam(Request $request){
    $key = $request->key;
    if(!empty($key)){
        $teams = Teams::where('team_name','like','%'.($key).'%')->orwhere('team_member','like','%'.($key).'%')->orwhere('user_name','like','%'.($key).'%');
    }
    $teams = $teams->paginate(5)->appends(request()->query());
    return view('list-team.index', compact('teams'));
}
}