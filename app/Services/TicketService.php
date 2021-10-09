<?php

namespace App\Services;

use App\Http\Requests\TicketRequest;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Notifications\ConfirmTicket;

class TicketService
{
    /**
     * @param Ticket $ticket
     *
     * @return boolean
     */
    public function confirm(Ticket $ticket): bool
    {
        if (Ticket::STATUS_NEW) {
            $ticket->status = Ticket::STATUS_OPEN;
        }

        return $ticket->save();
    }

    /**
     * @param TicketRequest $request
     *
     * @return boolean
     */
    public function create(TicketRequest $request): bool
    {
        $ticket = Ticket::create([
            'subject' => $request->subject,
            'user_id' => $request->user->id,
            'status' => $request->password
                ? Ticket::STATUS_OPEN
                : Ticket::STATUS_NEW,
        ]);
        if (! $request->password) {
            $request->user->notify(new ConfirmTicket($ticket));
        }
        TicketMessage::create([
            'message' => $request->message,
            'ticket_id' => $ticket->id,
            'user_id' => $request->user->id,
        ]);

        return true;
    }
}
