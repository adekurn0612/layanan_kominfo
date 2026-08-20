@extends('layouts.app', ['title' => 'Organisasi'])

@section('content')
    @section('action')
        <a href="{{ route('admin.organizations.create') }}" class="rounded-md bg-[#137CBD] px-4 py-2 text-sm font-semibold text-white hover:bg-[#0D6EAE]">Tambah Organisasi</a>
    @endsection

    <div class="overflow-hidden rounded-lg border border-[#CDEAF5] bg-white">
        <table class="w-full divide-y divide-[#CDEAF5] text-sm">
            <thead class="bg-[#F7FBFD] text-left text-xs font-semibold uppercase text-zinc-500">
                <tr>
                    <th class="px-4 py-3">Kode</th>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Induk</th>
                    <th class="px-4 py-3">Tipe</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#EAF8FC]">
                @foreach ($organizations as $organization)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $organization->code }}</td>
                        <td class="px-4 py-3">{{ $organization->name }}</td>
                        <td class="px-4 py-3 text-zinc-500">{{ $organization->parent?->name ?? '-' }}</td>
                        <td class="px-4 py-3">{{ str_replace('_', ' ', $organization->type) }}</td>
                        <td class="px-4 py-3"><x-status-badge :active="$organization->is_active" /></td>
                        <td class="px-4 py-3 text-right"><a href="{{ route('admin.organizations.edit', $organization) }}" class="font-medium text-zinc-900 underline">Edit</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $organizations->links() }}</div>
@endsection
