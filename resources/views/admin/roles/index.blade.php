@extends('layouts.app', ['title' => 'Role'])

@section('content')
    <div class="overflow-hidden rounded-lg border border-[#CDEAF5] bg-white">
        <table class="w-full divide-y divide-[#CDEAF5] text-sm">
            <thead class="bg-[#F7FBFD] text-left text-xs font-semibold uppercase text-zinc-500">
                <tr>
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3">Kode</th>
                    <th class="px-4 py-3">User</th>
                    <th class="px-4 py-3">Permission</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#EAF8FC]">
                @foreach ($roles as $role)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $role->name }}</td>
                        <td class="px-4 py-3">{{ $role->code }}</td>
                        <td class="px-4 py-3">{{ $role->users_count }}</td>
                        <td class="px-4 py-3">{{ $role->permissions_count }}</td>
                        <td class="px-4 py-3"><x-status-badge :active="$role->is_active" /></td>
                        <td class="px-4 py-3 text-right"><a href="{{ route('admin.roles.edit', $role) }}" class="font-medium text-zinc-900 underline">Edit</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $roles->links() }}</div>
@endsection
