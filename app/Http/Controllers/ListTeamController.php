<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\TeamRepositoryInterface;

class ListTeamController extends Controller
{
    private $teamRepository;
    public function __construct(TeamRepositoryInterface $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }
    public function listTeam(){
        return $this->teamRepository->listTeam();
    }
    public function searchTeam(Request $Request){
        return $this->teamRepository->searchTeam($Request);
    }
}