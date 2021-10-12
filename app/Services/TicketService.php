<?php

namespace App\Services;

use App\Http\Requests\TicketRequest;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\User;
use App\Notifications\ConfirmTicket;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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
     * Before saving the ticket to the database, we should determine the user,
     * based on their username or email.
     *
     * @param mixed $username
     * @param mixed $email
     *
     * @return User
     *
     * @throws ValidationException
     */
    public function findUser(string $username = null, string $email = null): User
    {
        $user = User::where('username', $username)
            ->orWhere('email', $email)
            ->first();

        if (is_null($user)) {
            throw ValidationException::withMessages([
                'username' => 'User Not Found!',
            ]);
        }

        return $user;
    }

    /**
     * To verify the ticket, User must submit a valid password, or ...
     *
     * @param User $user
     * @param string|null $password
     *
     * @return bool
     *
     * @throws ValidationException
     */
    public function checkPassword(User $user, string $password = null): bool
    {
        if (! $password) {
            return false;
        }

        if (! Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => 'Password is incorrect!',
            ]);
        }

        return true;
    }

    /**
     * @param TicketRequest $request
     * @param User $user
     * @param bool $needConfirm
     *
     * @return bool
     *
     * @throws BindingResolutionException
     */
    public function create(TicketRequest $request, User $user, bool $needConfirm = false): bool
    {
        $ticket = Ticket::create([
            'subject' => $request->subject,
            'user_id' => $user->id,
            'status' => $needConfirm
                ? Ticket::STATUS_NEW
                : Ticket::STATUS_OPEN,
        ]);

        if ($needConfirm) {
            $user->notify(new ConfirmTicket($ticket));
        }

        TicketMessage::create([
            'message' => $request->message,
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
        ]);

        return true;
    }
}
