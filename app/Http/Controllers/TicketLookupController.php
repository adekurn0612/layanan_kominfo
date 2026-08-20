<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TicketLookupController extends Controller
{
    public function __invoke(Request $request): View
    {
        $uuid = trim((string) $request->query('uuid', ''));
        $ticket = null;
        $canViewFollowUps = false;

        if ($uuid !== '') {
            $query = Ticket::query()
                ->with('service.category')
                ->where('uuid', $uuid);

            $user = $request->user();
            $ticket = $query->first();

            $canViewFollowUps = $ticket && $user && (
                $ticket->user_id === $user->id || $user->hasPermission('admin.access')
            );

            if ($canViewFollowUps) {
                $ticket->load(['followUps' => fn ($followUpQuery) => $followUpQuery->where('is_public', true)->latest()]);
            }
        }

        return view('tickets.lookup', [
            'uuid' => $uuid,
            'ticket' => $ticket,
            'canViewFollowUps' => $canViewFollowUps,
            'searched' => $uuid !== '',
        ]);
    }

    public function downloadFollowUpFile(Ticket $ticket, int $followUp): Response
    {
        $user = request()->user();
        abort_unless(
            $ticket->user_id === $user?->id || $user?->hasPermission('admin.access'),
            403
        );

        $followUp = $ticket->followUps()
            ->where('is_public', true)
            ->findOrFail($followUp);

        return Storage::disk('local')->response($followUp->file_path, $followUp->file_name, [
            'Content-Type' => $followUp->file_mime,
        ]);
    }
}
