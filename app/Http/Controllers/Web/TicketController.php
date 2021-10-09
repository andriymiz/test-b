<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Services\TicketService;
use Illuminate\Http\RedirectResponse;

class TicketController extends Controller
{
    /**
     * For confirmation ticket from mail
     *
     * @param Ticket $ticket
     * @param TicketService $service
     *
     * @return RedirectResponse
     */
    public function confirm(Ticket $ticket, TicketService $service): RedirectResponse
    {
        $service->confirm($ticket);

        return response()->redirectTo('/');
    }
}
