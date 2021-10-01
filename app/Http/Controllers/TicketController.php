<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\User;
use App\Http\Requests\TicketRequest;
use App\Notifications\ConfirmTicket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class TicketController extends Controller
{
    /**
     * @param TicketRequest $request
     *
     * @return JsonResponse
     */
    public function create(TicketRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::where('username', $data['username'])
            ->orWhere('email', $request['email'])
            ->first();

        if (is_null($user)) {
            return response()->json(['message' => 'User Not Found'], 422);
        }

        $ticket = Ticket::factory()->for($user)->has(TicketMessage::factory([
            'message' => $data['message'],
        ])->for($user), 'messages')->create([
            'subject' => $data['subject'],
        ]);

        if (Hash::check($request->password, $user->password)) {
            $ticket->confirm();
        } else {
            $user->notify(new ConfirmTicket($ticket));
        }

        return response()->json($user);
    }

    /**
     * For confirmation ticket from mail
     *
     * @param Ticket $ticket
     *
     * @return RedirectResponse
     */
    public function confirm(Ticket $ticket): RedirectResponse
    {
        $ticket->confirm();

        return response()->redirectTo('/');
    }
}
