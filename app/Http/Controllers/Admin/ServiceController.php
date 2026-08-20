<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', Service::class);

        return view('admin.services.index', [
            'services' => Service::with('category')->withCount(['fields', 'requirements'])->orderBy('sort_order')->orderBy('name')->paginate(15),
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', Service::class);

        return view('admin.services.create', [
            'service' => new Service(['is_active' => true, 'sla_hours' => 24, 'sort_order' => 0]),
            'categories' => ServiceCategory::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function store(StoreServiceRequest $request): RedirectResponse
    {
        $service = Service::create($request->safe()->merge(['is_active' => $request->boolean('is_active')])->all());

        return redirect()->route('admin.services.show', $service)->with('status', 'Layanan berhasil ditambahkan.');
    }

    public function show(Service $service): View
    {
        $this->authorize('view', $service);

        return view('admin.services.show', [
            'service' => $service->load(['category', 'fields', 'requirements']),
        ]);
    }

    public function edit(Service $service): View
    {
        $this->authorize('update', $service);

        return view('admin.services.edit', [
            'service' => $service,
            'categories' => ServiceCategory::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function update(UpdateServiceRequest $request, Service $service): RedirectResponse
    {
        $service->update($request->safe()->merge(['is_active' => $request->boolean('is_active')])->all());

        return redirect()->route('admin.services.show', $service)->with('status', 'Layanan berhasil diperbarui.');
    }
}
