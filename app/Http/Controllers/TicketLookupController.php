<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TicketLookupController extends Controller
{
    public function __invoke(Request $request): View
    {
        $uuid = trim((string) $request->query('uuid', ''));
        $ticket = null;

        if ($uuid !== '') {
            $ticket = Ticket::query()
                ->with(['service.category'])
                ->where('uuid', $uuid)
                ->first();
        }

        return view('tickets.lookup', [
            'uuid' => $uuid,
            'ticket' => $ticket,
            'searched' => $uuid !== '',
        ]);
    }
}
