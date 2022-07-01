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
}
