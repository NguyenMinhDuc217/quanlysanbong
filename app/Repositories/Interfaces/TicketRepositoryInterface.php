<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;
use App\Repositories\TicketRepository;

interface TicketRepositoryInterface
{
    public function showTicket();
    public function viewTicket(Request $request);
    public function detailTicket(Request $request);
    public function buyTicket(Request $request);
    public function listBuyTicket();
    public function payTicket(Request $request);
    public function searchTicket(Request $request);
}