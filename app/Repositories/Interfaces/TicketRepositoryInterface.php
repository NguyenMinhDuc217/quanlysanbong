<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;
use App\Repositories\TicketRepository;

interface TicketRepositoryInterface
{
    public function showTicket();
    public function viewTicket(Request $request);
    public function detailTicket(Request $request);
}