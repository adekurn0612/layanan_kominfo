@extends('layouts.app', ['title' => 'Layanan'])

@section('content')
    @section('action')
        <a href="{{ route('admin.services.create') }}" class="rounded-md bg-[#137CBD] px-4 py-2 text-sm font-semibold text-white hover:bg-[#0D6EAE]">Tambah Layanan</a>
    @endsection

    <div class="overflow-hidden rounded-lg border border-[#CDEAF5] bg-white">
        <table class="w-full divide-y divide-[#CDEAF5] text-sm">
            <thead class="bg-[#F7FBFD] text-left text-xs font-semibold uppercase text-zinc-500">
                <tr>
                    <th class="px-4 py-3">Layanan</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">SLA</th>
                    <th class="px-4 py-3">Field</th>
                    <th class="px-4 py-3">Syarat</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#EAF8FC]">
                @foreach ($services as $service)
                    <tr>
                        <td class="px-4 py-3">
                            <div class="font-medium">{{ $service->name }}</div>
                            <div class="text-xs text-zinc-500">{{ $service->code }}</div>
                        </td>
                        <td class="px-4 py-3">{{ $service->category->name }}</td>
                        <td class="px-4 py-3">{{ $service->sla_hours }} jam</td>
                        <td class="px-4 py-3">{{ $service->fields_count }}</td>
                        <td class="px-4 py-3">{{ $service->requirements_count }}</td>
                        <td class="px-4 py-3"><x-status-badge :active="$service->is_active" /></td>
                        <td class="px-4 py-3 text-right"><a href="{{ route('admin.services.show', $service) }}" class="font-medium underline">Kelola</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $services->links() }}</div>
@endsection
