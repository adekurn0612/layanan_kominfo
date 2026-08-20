<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Ticket;
use App\Services\DynamicServiceFormValidator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\View\View;

class ServiceApplicationController extends Controller
{
    public function create(Service $service): View
    {
        abort_unless($service->is_active, 404);

        return view('services.apply', [
            'service' => $service->load(['category', 'activeFields', 'requirements']),
        ]);
    }

    public function store(Request $request, Service $service, DynamicServiceFormValidator $validator): RedirectResponse
    {
        abort_unless($service->is_active, 404);

        $service->load('activeFields');
        $fields = $validator->validate($request, $service);
        $ticket = Ticket::create([
            'service_id' => $service->id,
            'user_id' => $request->user()->id,
            'organization_id' => $request->user()->organization_id,
            'status' => 'submitted',
            'form_data' => $this->normalizeFormData($fields, $service->id),
        ]);

        return redirect()
            ->route('tickets.lookup', ['uuid' => $ticket->uuid])
            ->with('status', "Tiket berhasil dibuat. Simpan UUID tiket: {$ticket->uuid}")
            ->with('ticket_created_uuid', $ticket->uuid);
    }

    private function normalizeFormData(array $fields, int $serviceId): array
    {
        return collect($fields)
            ->map(function (mixed $value, string $key) use ($serviceId): mixed {
                if ($value instanceof UploadedFile) {
                    return [
                        'original_name' => $value->getClientOriginalName(),
                        'mime_type' => $value->getClientMimeType(),
                        'size' => $value->getSize(),
                        'path' => $value->store("tickets/{$serviceId}"),
                    ];
                }

                return $value;
            })
            ->all();
    }
}
