<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequirementRequest;
use App\Http\Requests\UpdateServiceRequirementRequest;
use App\Models\Service;
use App\Models\ServiceRequirement;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ServiceRequirementController extends Controller
{
    public function create(Service $service): View
    {
        $this->authorize('update', $service);

        return view('admin.service-requirements.create', [
            'service' => $service,
            'requirement' => new ServiceRequirement(['is_required' => true, 'sort_order' => 0]),
        ]);
    }

    public function store(StoreServiceRequirementRequest $request, Service $service): RedirectResponse
    {
        $service->requirements()->create($this->payload($request->validated(), $request->boolean('is_required')));

        return redirect()->route('admin.services.show', $service)->with('status', 'Persyaratan layanan berhasil ditambahkan.');
    }

    public function edit(Service $service, ServiceRequirement $requirement): View
    {
        $this->authorize('update', $service);

        abort_unless($requirement->service_id === $service->id, 404);

        return view('admin.service-requirements.edit', compact('service', 'requirement'));
    }

    public function update(UpdateServiceRequirementRequest $request, Service $service, ServiceRequirement $requirement): RedirectResponse
    {
        abort_unless($requirement->service_id === $service->id, 404);

        $requirement->update($this->payload($request->validated(), $request->boolean('is_required')));

        return redirect()->route('admin.services.show', $service)->with('status', 'Persyaratan layanan berhasil diperbarui.');
    }

    private function payload(array $data, bool $isRequired): array
    {
        $data['is_required'] = $isRequired;
        $data['allowed_file_types'] = collect(explode(',', (string) ($data['allowed_file_types'] ?? '')))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all() ?: null;

        return $data;
    }
}
