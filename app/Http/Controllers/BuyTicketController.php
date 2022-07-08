<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\TicketRepositoryInterface;

class BuyTicketController extends BaseUserController
{
    private $ticketRepository;
    public function __construct(TicketRepositoryInterface $ticketRepository)
    {
        parent::__construct();
        $this->ticketRepository = $ticketRepository;
    }
    public function buyTicket(Request $request){
        return $this->ticketRepository->buyTicket($request);
    }
    public function listBuyTicket(){
        return $this->ticketRepository->listBuyTicket();
    }
    public function payTicket(Request $request){
        return $this->ticketRepository->payTicket($request);
    }
}
