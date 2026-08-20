@extends('layouts.app', ['title' => 'User'])

@section('content')
    @section('action')
        <a href="{{ route('admin.users.create') }}" class="rounded-md bg-[#137CBD] px-4 py-2 text-sm font-semibold text-white hover:bg-[#0D6EAE]">Tambah User</a>
    @endsection

    <div class="overflow-hidden rounded-lg border border-[#CDEAF5] bg-white">
        <table class="w-full divide-y divide-[#CDEAF5] text-sm">
            <thead class="bg-[#F7FBFD] text-left text-xs font-semibold uppercase text-zinc-500">
                <tr>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">No. HP</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Instansi</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#EAF8FC]">
                @foreach ($users as $user)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $user->name }}</td>
                        <td class="px-4 py-3">{{ $user->phone ?: '-' }}</td>
                        <td class="px-4 py-3">{{ $user->email }}</td>
                        <td class="px-4 py-3 text-zinc-500">{{ $user->organization?->name ?? '-' }}</td>
                        <td class="px-4 py-3">
                            @if ($user->is_active)
                                <x-status-badge :active="true" />
                            @else
                                <span class="inline-flex rounded-full bg-[#FFF8D9] px-2 py-1 text-xs font-semibold text-[#8A6500]">Menunggu verifikasi</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right"><a href="{{ route('admin.users.edit', $user) }}" class="font-medium text-zinc-900 underline">Edit</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $users->links() }}</div>
@endsection
