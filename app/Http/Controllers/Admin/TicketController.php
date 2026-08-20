<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TicketController extends Controller
{
    private const STATUSES = [
        'submitted' => 'Diajukan',
        'in_review' => 'Sedang Diverifikasi',
        'in_progress' => 'Sedang Diproses',
        'completed' => 'Selesai',
        'rejected' => 'Ditolak',
    ];

    public function index(): View
    {
        $this->authorize('viewAny', Ticket::class);

        return view('admin.tickets.index', [
            'tickets' => Ticket::with(['service', 'user', 'organization'])
                ->latest('submitted_at')
                ->paginate(15),
            'statuses' => self::STATUSES,
        ]);
    }

    public function edit(Ticket $ticket): View
    {
        $this->authorize('update', $ticket);

        return view('admin.tickets.edit', [
            'ticket' => $ticket->load(['service', 'user', 'organization']),
            'statuses' => self::STATUSES,
            'followUps' => $ticket->followUps()->with('user')->latest()->get(),
        ]);
    }

    public function downloadFollowUpFile(Ticket $ticket, int $followUp): Response
    {
        $this->authorize('update', $ticket);

        $followUp = $ticket->followUps()->findOrFail($followUp);

        return Storage::disk('local')->response($followUp->file_path, $followUp->file_name, [
            'Content-Type' => $followUp->file_mime,
        ]);
    }

    public function update(Request $request, Ticket $ticket): RedirectResponse
    {
        $this->authorize('update', $ticket);

        $ticket->update($request->validate([
            'status' => ['required', 'string', 'in:' . implode(',', array_keys(self::STATUSES))],
        ]));

        return redirect()->route('admin.tickets.edit', $ticket)->with('status', 'Status tiket berhasil diperbarui.');
    }

    public function storeFollowUp(Request $request, Ticket $ticket): RedirectResponse
    {
        $this->authorize('update', $ticket);

        $data = $request->validate([
            'comment' => ['nullable', 'string', 'max:5000', 'required_without:file'],
            'file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120', 'required_without:comment'],
            'is_public' => ['boolean'],
        ]);

        $file = $request->file('file');
        $ticket->followUps()->create([
            'user_id' => $request->user()->id,
            'comment' => $data['comment'] ?? null,
            'is_public' => $request->boolean('is_public'),
            'file_path' => $file?->store('ticket-follow-ups', 'local'),
            'file_name' => $file?->getClientOriginalName(),
            'file_mime' => $file?->getMimeType(),
        ]);

        return redirect()->route('admin.tickets.edit', $ticket)->with('status', 'Tindak lanjut tiket berhasil ditambahkan.');
    }
}
