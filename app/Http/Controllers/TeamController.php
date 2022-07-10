<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\TeamRepositoryInterface;

class TeamController extends  BaseUserController
{
    private $teamRepository;
    public function __construct(TeamRepositoryInterface $teamRepository)
    {
        parent::__construct();
        $this->teamRepository = $teamRepository;
    }
    public function showCreateTeam(){
        return $this->teamRepository->showCreateTeam();
    }
    public function createTeam(Request $Request){
        return $this->teamRepository->createTeam($Request);
    }
    public function listTeam(){
        return $this->teamRepository->listTeam();
    }
    public function searchTeam(Request $Request){
        return $this->teamRepository->searchTeam($Request);
    }
}
