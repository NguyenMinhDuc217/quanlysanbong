<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\TicketRepositoryInterface;

class TicketController extends Controller
{
    private $ticketRepository;
    public function __construct(TicketRepositoryInterface $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }
    public function showTicket(){
        return $this->ticketRepository->showTicket();
    }
    public function viewTicket(Request $request){
        return $this->ticketRepository->viewTicket($request);
    }
    public function detailTicket(Request $request){
        return $this->ticketRepository->detailTicket($request);
    }
    public function searchTicket(Request $request){
        return $this->ticketRepository->searchTicket($request);
    }
}
