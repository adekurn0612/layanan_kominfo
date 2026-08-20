@extends('layouts.app', ['title' => $service->name])

@section('content')
    @section('action')
        <a href="{{ route('admin.services.edit', $service) }}" class="rounded-md border border-[#B8E2F0] px-4 py-2 text-sm font-semibold hover:bg-[#F7FBFD]">Edit Layanan</a>
    @endsection

    <div class="grid gap-5 xl:grid-cols-[1fr_360px]">
        <section class="rounded-lg border border-[#CDEAF5] bg-white p-5">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <div class="text-sm font-medium text-zinc-500">{{ $service->category->name }} - {{ $service->code }}</div>
                    <h2 class="mt-1 text-2xl font-semibold">{{ $service->name }}</h2>
                    <p class="mt-2 text-sm leading-6 text-zinc-600">{{ $service->description ?: 'Belum ada deskripsi.' }}</p>
                </div>
                <x-status-badge :active="$service->is_active" />
            </div>
            <div class="mt-4 grid gap-3 sm:grid-cols-2">
                <div class="rounded-md bg-[#F7FBFD] p-3 text-sm">
                    <div class="text-zinc-500">SLA</div>
                    <div class="font-semibold">{{ $service->sla_hours }} jam</div>
                </div>
                <div class="rounded-md bg-[#F7FBFD] p-3 text-sm">
                    <div class="text-zinc-500">Urutan</div>
                    <div class="font-semibold">{{ $service->sort_order }}</div>
                </div>
            </div>
        </section>

        <section class="rounded-lg border border-[#CDEAF5] bg-white p-5">
            <h3 class="font-semibold">Preview Form</h3>
            <div class="mt-4 space-y-4">
                @forelse ($service->fields->where('is_active', true) as $field)
                    @include('services.partials.dynamic-field', ['field' => $field, 'disabled' => true])
                @empty
                    <p class="text-sm text-zinc-500">Belum ada field aktif.</p>
                @endforelse
            </div>
        </section>
    </div>

    <section class="mt-5 rounded-lg border border-[#CDEAF5] bg-white p-5">
        <div class="mb-4 flex items-center justify-between gap-3">
            <h3 class="font-semibold">Field Form Layanan</h3>
            <a href="{{ route('admin.services.fields.create', $service) }}" class="rounded-md bg-[#137CBD] px-3 py-2 text-sm font-semibold text-white hover:bg-[#0D6EAE]">Tambah Field</a>
        </div>
        <div class="overflow-hidden rounded-md border border-[#CDEAF5]">
            <table class="w-full divide-y divide-[#CDEAF5] text-sm">
                <thead class="bg-[#F7FBFD] text-left text-xs font-semibold uppercase text-zinc-500">
                    <tr>
                        <th class="px-4 py-3">Label</th>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Tipe</th>
                        <th class="px-4 py-3">Wajib</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EAF8FC]">
                    @forelse ($service->fields as $field)
                        <tr>
                            <td class="px-4 py-3 font-medium">{{ $field->label }}</td>
                            <td class="px-4 py-3">{{ $field->name }}</td>
                            <td class="px-4 py-3">{{ $field->type }}</td>
                            <td class="px-4 py-3">{{ $field->is_required ? 'Ya' : 'Tidak' }}</td>
                            <td class="px-4 py-3"><x-status-badge :active="$field->is_active" /></td>
                            <td class="px-4 py-3 text-right"><a href="{{ route('admin.services.fields.edit', [$service, $field]) }}" class="font-medium underline">Edit</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-6 text-center text-zinc-500">Belum ada field.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="mt-5 rounded-lg border border-[#CDEAF5] bg-white p-5">
        <div class="mb-4 flex items-center justify-between gap-3">
            <h3 class="font-semibold">Persyaratan Layanan</h3>
            <a href="{{ route('admin.services.requirements.create', $service) }}" class="rounded-md bg-[#137CBD] px-3 py-2 text-sm font-semibold text-white hover:bg-[#0D6EAE]">Tambah Persyaratan</a>
        </div>
        <div class="grid gap-3 md:grid-cols-2">
            @forelse ($service->requirements as $requirement)
                <div class="rounded-md border border-[#CDEAF5] p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h4 class="font-medium">{{ $requirement->name }}</h4>
                            <p class="mt-1 text-sm text-zinc-600">{{ $requirement->description ?: 'Tanpa deskripsi.' }}</p>
                            <p class="mt-2 text-xs text-zinc-500">
                                {{ $requirement->is_required ? 'Wajib' : 'Opsional' }}
                                @if ($requirement->allowed_file_types)
                                    - {{ implode(', ', $requirement->allowed_file_types) }}
                                @endif
                                @if ($requirement->max_file_size)
                                    - maks {{ $requirement->max_file_size }} KB
                                @endif
                            </p>
                        </div>
                        <a href="{{ route('admin.services.requirements.edit', [$service, $requirement]) }}" class="text-sm font-medium underline">Edit</a>
                    </div>
                </div>
            @empty
                <p class="text-sm text-zinc-500">Belum ada persyaratan.</p>
            @endforelse
        </div>
    </section>
@endsection
