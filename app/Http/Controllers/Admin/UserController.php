<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Organization;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', User::class);

        return view('admin.users.index', [
            'users' => User::with(['organization', 'roles'])->latest()->paginate(15),
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', User::class);
        $roles = Role::where('is_active', true)->orderBy('name');

        return view('admin.users.create', [
            'user' => new User(['is_active' => true]),
            'organizations' => Organization::where('is_active', true)->orderBy('name')->get(),
            'roles' => $this->filterAssignableRoles($roles)->get(),
            'selectedRoles' => [],
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['roles', 'password_confirmation']);
        $data['is_active'] = $request->boolean('is_active');

        $user = User::create($data);
        $user->roles()->sync($request->validated('roles', []));

        return redirect()->route('admin.users.index')->with('status', 'User berhasil ditambahkan.');
    }

    public function edit(User $user): View
    {
        $this->authorize('update', $user);
        $roles = Role::where('is_active', true)->orderBy('name');

        return view('admin.users.edit', [
            'user' => $user->load('roles'),
            'organizations' => Organization::where('is_active', true)->orderBy('name')->get(),
            'roles' => $this->filterAssignableRoles($roles)->get(),
            'selectedRoles' => $user->roles->pluck('id')->all(),
        ]);
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $data = Arr::except($request->safe()->except(['roles', 'password_confirmation']), ['password']);

        if ($request->filled('password')) {
            $data['password'] = $request->string('password')->toString();
        }

        $data['is_active'] = $request->boolean('is_active');

        $user->update($data);
        $user->roles()->sync($request->validated('roles', []));

        return redirect()->route('admin.users.index')->with('status', 'User berhasil diperbarui.');
    }

    private function filterAssignableRoles($query)
    {
        if (request()->user()?->isSuperAdmin()) {
            return $query;
        }

        return $query->where('code', '!=', Role::SUPER_ADMIN_CODE);
    }
}
