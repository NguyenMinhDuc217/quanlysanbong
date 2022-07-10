<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;
use App\Repositories\TeamRepository;

interface TeamRepositoryInterface
{
    public function showCreateTeam();
    public function createTeam(Request $request);
    public function listTeam();
    public function searchTeam(Request $request);
}