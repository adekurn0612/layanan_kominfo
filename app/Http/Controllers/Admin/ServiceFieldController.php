<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceFieldRequest;
use App\Http\Requests\UpdateServiceFieldRequest;
use App\Models\Service;
use App\Models\ServiceField;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ServiceFieldController extends Controller
{
    public function create(Service $service): View
    {
        $this->authorize('update', $service);

        return view('admin.service-fields.create', [
            'service' => $service,
            'field' => new ServiceField(['is_active' => true, 'sort_order' => 0]),
            'types' => ServiceField::TYPES,
        ]);
    }

    public function store(StoreServiceFieldRequest $request, Service $service): RedirectResponse
    {
        $service->fields()->create($this->payload($request->validated(), $request->boolean('is_required'), $request->boolean('is_active')));

        return redirect()->route('admin.services.show', $service)->with('status', 'Field layanan berhasil ditambahkan.');
    }

    public function edit(Service $service, ServiceField $field): View
    {
        $this->authorize('update', $service);

        abort_unless($field->service_id === $service->id, 404);

        return view('admin.service-fields.edit', [
            'service' => $service,
            'field' => $field,
            'types' => ServiceField::TYPES,
        ]);
    }

    public function update(UpdateServiceFieldRequest $request, Service $service, ServiceField $field): RedirectResponse
    {
        abort_unless($field->service_id === $service->id, 404);

        $field->update($this->payload($request->validated(), $request->boolean('is_required'), $request->boolean('is_active')));

        return redirect()->route('admin.services.show', $service)->with('status', 'Field layanan berhasil diperbarui.');
    }

    private function payload(array $data, bool $isRequired, bool $isActive): array
    {
        $data['is_required'] = $isRequired;
        $data['is_active'] = $isActive;
        $data['options'] = $this->lines($data['options'] ?? null);
        $data['validation_rules'] = $this->lines($data['validation_rules'] ?? null);

        return $data;
    }

    private function lines(?string $value): ?array
    {
        $items = collect(preg_split('/\r\n|\r|\n/', (string) $value))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();

        return $items ?: null;
    }
}
