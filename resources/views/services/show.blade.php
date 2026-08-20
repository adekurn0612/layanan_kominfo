@extends('layouts.app', ['title' => $service->name])

@section('content')
    @section('action')
        <x-ui.button as="a" href="{{ route('services.apply', $service) }}">Ajukan Layanan</x-ui.button>
    @endsection

    <div class="grid gap-5 xl:grid-cols-[1fr_380px]">
        <x-ui.card title="{{ $service->name }}" description="{{ $service->description }}" class="space-y-4">
            <div class="overflow-hidden rounded-lg border border-[#CDEAF5]">
                <img src="{{ $service->category->image_url }}" alt="Gambar {{ $service->category->name }}" class="h-44 w-full object-cover">
            </div>
            <div class="text-sm font-medium text-zinc-500">{{ $service->category->name }}</div>
            <div class="flex flex-wrap items-center gap-3">
                <div class="inline-flex rounded-md bg-[#EAF8FC] px-3 py-2 text-sm font-semibold text-zinc-800">SLA {{ $service->sla_hours }} jam</div>
                @guest
                    <div class="text-sm text-zinc-600">Login diperlukan saat mengajukan layanan.</div>
                @endguest
            </div>
            <div class="flex flex-wrap gap-3 pt-2">
                <x-ui.button as="a" href="{{ route('services.apply', $service) }}">Ajukan Layanan</x-ui.button>
                <x-ui.button as="a" href="{{ route('services.index') }}" variant="secondary">Kembali ke Katalog</x-ui.button>
            </div>
        </x-ui.card>

        <x-ui.card title="Persyaratan">
            <div class="space-y-3">
                @forelse ($service->requirements as $requirement)
                    <div class="rounded-md border border-[#CDEAF5] p-3">
                        <div class="flex items-center justify-between gap-3">
                            <div class="font-medium text-zinc-900">{{ $requirement->name }}</div>
                            <span class="text-xs font-semibold {{ $requirement->is_required ? 'text-red-700' : 'text-zinc-500' }}">{{ $requirement->is_required ? 'Wajib' : 'Opsional' }}</span>
                        </div>
                        @if ($requirement->description)
                            <p class="mt-1 text-sm text-zinc-600">{{ $requirement->description }}</p>
                        @endif
                    </div>
                @empty
                    <p class="text-sm text-zinc-500">Tidak ada persyaratan khusus.</p>
                @endforelse
            </div>
        </x-ui.card>
    </div>

    <x-ui.card title="Formulir yang Akan Diisi" class="mt-5">
        <div class="mt-4 grid gap-4 md:grid-cols-2">
            @forelse ($service->activeFields as $field)
                @include('services.partials.dynamic-field', ['field' => $field, 'disabled' => true])
            @empty
                <p class="text-sm text-zinc-500">Belum ada konfigurasi field.</p>
            @endforelse
        </div>
    </x-ui.card>
@endsection
