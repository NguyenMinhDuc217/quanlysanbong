<?php

namespace App\Repositories;

use App\Repositories\Interfaces\TicketRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Pitchs;

class TicketRepository implements TicketRepositoryInterface
{
  public function showTicket(){
      return view('buy-ticket.index');
  }
}