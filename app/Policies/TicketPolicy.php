<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('tickets.view');
    }

    public function update(User $user, Ticket $ticket): bool
    {
        return $user->hasPermission('tickets.manage');
    }
}
