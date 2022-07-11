<?php

namespace App\Repositories;

use App\Repositories\Interfaces\TeamRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Teams;
use Illuminate\Support\Facades\Auth;

class TeamRepository implements TeamRepositoryInterface
{
    public function showCreateTeam()
    {
        return view('create-team.index');
    }
    public function createTeam(Request $request)
    {
        $request->validate(
            [
                'teamname' => 'required',
                'member' => 'required',
                'link' => 'required',
            ],
            [
                'teamname.required' => 'Tên đội không được để trống',
                'member.required' => 'Thành viên không được để trống',
                'link.required' => 'Liên lạc không được để trống',
            ]
        );
        if (Teams::where('team_name', '=', $request->teamname)->exists()) {
            return redirect()->route('show.create.team')->with('error', "Tên đội đã được tạo");
        }
        $team = new Teams();
        $team->user_name = Auth::guard('user')->user()->username;
        $team->team_name = $request->teamname;
        $team->team_member = $request->member;
        $team->link = $request->link;
        if (!$team->save()) {
            return redirect()->route('show.create.team')->with('error', "Tạo đội thất bại");
        }
        return redirect()->route('show.create.team')->with('success', "Tạo đội thành công");
    }
    public function listTeam()
    {
        $teams = Teams::orderby('id', 'DESC')->paginate(5)->appends(request()->query());
        return view('list-team.index', compact('teams'));
    }
    public function myTeam()
    {
        $teams = Teams::where('user_name', Auth::guard('user')->user()->username)->orderby('id', 'DESC')->paginate(5)->appends(request()->query());
        return view('my-team.index', compact('teams'));
    }
    public function editTeam($id)
    {
        $my_teams = Teams::where('id', $id)->where('user_name', Auth::guard('user')->user()->username)->first();
        return view('my-team.edit', compact('my_teams'));
    }
    public function updateTeam(Request $request, $id)
    {
        $request->validate(
            [
                'teamname' => 'required',
                'member' => 'required',
                'contact' => 'required',
            ],
            [
                'teamname.required' => 'Tên đội không được để trống',
                'member.required' => 'Thành viên không được để trống',
                'contact.required' => 'Link không được để trống',
            ]
        );
        $user = Auth::guard('user')->user();
        $my_teams = Teams::where('user_name', $user["username"])->first();
        $teams = Teams::orderby('id', 'DESC')->paginate(5)->appends(request()->query());

        if (empty($my_teams)) {
            return view('list-team.index', compact('teams'));
        }
        // if($request->username != $my_teams->user_name){
        //     return redirect()->route('my.team.edit',[$my_teams->id])->with('error', "Tên của đội trưởng không chính xác");
        // }
        if ($request->teamname != $my_teams->team_name) {
            if (Teams::where('team_name', '=', $request->teamname)->exists()) {
                return redirect()->route('my.team.edit', [$my_teams->id])->with('error', "Tên đội đã tồn tại");
            }
        }

        // $my_teams->user_name = $request->user_name;
        $my_teams->team_name = $request->teamname;
        $my_teams->team_member = $request->member;
        $my_teams->link = $request->contact;

        if (!$my_teams->save()) {
            return redirect()->route('my.team.edit', [$my_teams->id])->with('error', "Cập nhật đội thất bại");
        }
        return redirect()->route('my.team.edit', [$my_teams->id])->with('success', "Cập nhật đội thành công");
    }
    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->id;
            $app = Application::where('id', $id)->first();
            if (!empty($app->cover)) {
                if (file_exists(public_path() . '/images/' . $app->cover)) {
                    @unlink(public_path() . '/images/' . $app->cover);
                }
            }
            if (!empty($app->screenshots)) {
                $screenshots = json_decode($app->screenshots);
                foreach ($screenshots as $v) {
                    if (file_exists(public_path() . '/images/' . $v)) {
                        @unlink(public_path() . '/images/' . $v);
                    }
                }
            }
            Application::where('id', $id)->delete();
            AppsInfo::where('id', $app->id)->delete();
            // Clear cache
            Cache::flush();
            return response()->json([
                'status' => true,
                'message' => 'Data deleted successfully!'
            ]);
        }
    }

    public function searchTeam(Request $request)
    {
        $key = $request->key;
        $teams = new Teams();
        if (!empty($key)) {
            $teams = Teams::where('team_name', 'like', '%' . ($key) . '%')->orwhere('team_member', 'like', '%' . ($key) . '%')->orwhere('user_name', 'like', '%' . ($key) . '%');
        }
        $teams = $teams->paginate(5)->appends(request()->query());
        return view('list-team.index', compact('teams'));
    }
}
