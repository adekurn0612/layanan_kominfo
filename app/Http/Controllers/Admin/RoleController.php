<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateRolePermissionsRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', Role::class);

        return view('admin.roles.index', [
            'roles' => Role::withCount(['users', 'permissions'])->orderBy('name')->paginate(15),
        ]);
    }

    public function edit(Role $role): View
    {
        $this->authorize('update', $role);

        return view('admin.roles.edit', [
            'role' => $role->load('permissions'),
            'permissions' => $this->filterAssignablePermissions(Permission::query()->orderBy('module')->orderBy('name'))->get()->groupBy('module'),
            'selectedPermissions' => $role->permissions->pluck('id')->all(),
        ]);
    }

    public function update(UpdateRolePermissionsRequest $request, Role $role): RedirectResponse
    {
        $role->update(['is_active' => $request->boolean('is_active')]);
        $role->permissions()->sync($request->validated('permissions', []));

        return redirect()->route('admin.roles.index')->with('status', 'Role berhasil diperbarui.');
    }

    private function filterAssignablePermissions(Builder $query): Builder
    {
        if (request()->user()?->isSuperAdmin()) {
            return $query;
        }

        return $query->whereNotIn('code', Permission::SENSITIVE_CODES);
    }
}
