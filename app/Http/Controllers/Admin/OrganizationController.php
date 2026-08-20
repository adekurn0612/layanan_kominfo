<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrganizationRequest;
use App\Http\Requests\UpdateOrganizationRequest;
use App\Models\Organization;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrganizationController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', Organization::class);

        return view('admin.organizations.index', [
            'organizations' => Organization::with('parent')->orderBy('name')->paginate(15),
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', Organization::class);

        return view('admin.organizations.create', [
            'organization' => new Organization(['is_active' => true]),
            'parents' => Organization::orderBy('name')->get(),
        ]);
    }

    public function store(StoreOrganizationRequest $request): RedirectResponse
    {
        Organization::create($request->safe()->merge([
            'is_active' => $request->boolean('is_active'),
        ])->all());

        return redirect()->route('admin.organizations.index')->with('status', 'Organisasi berhasil ditambahkan.');
    }

    public function edit(Organization $organization): View
    {
        $this->authorize('update', $organization);

        return view('admin.organizations.edit', [
            'organization' => $organization,
            'parents' => Organization::whereKeyNot($organization->id)->orderBy('name')->get(),
        ]);
    }

    public function update(UpdateOrganizationRequest $request, Organization $organization): RedirectResponse
    {
        $organization->update($request->safe()->merge([
            'is_active' => $request->boolean('is_active'),
        ])->all());

        return redirect()->route('admin.organizations.index')->with('status', 'Organisasi berhasil diperbarui.');
    }
}
