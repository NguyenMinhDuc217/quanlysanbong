<?php

namespace App\Http\Controllers;

use App\Models\Pitchs;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\SetPitchRepositoryInterface;

class SetPitchController extends BaseUserController
{
    private $setPitchRepository;
    public function __construct(SetPitchRepositoryInterface $setPitchRepository)
    {
        parent::__construct();
        $this->setPitchRepository = $setPitchRepository;
    }
 
    public function setPitch(Request $request,$pitchid){
        return $this->setPitchRepository->setPitch($request,$pitchid);

    }

}