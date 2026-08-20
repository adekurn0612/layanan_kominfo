@extends('layouts.app', ['title' => 'Ajukan ' . $service->name])

@section('content')
    <x-ui.card class="max-w-4xl">
        <form method="POST" action="{{ route('services.apply.store', $service) }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-5">
                <div class="text-sm font-medium text-zinc-500">{{ $service->category->name }} - SLA {{ $service->sla_hours }} jam</div>
                <h2 class="mt-1 text-xl font-semibold text-zinc-900">{{ $service->name }}</h2>
                <p class="mt-2 text-sm text-zinc-600">{{ $service->description }}</p>
            </div>

            @if ($service->requirements->isNotEmpty())
                <div class="mb-5 rounded-md bg-[#F7FBFD] p-4">
                    <h3 class="text-sm font-semibold text-zinc-800">Persyaratan</h3>
                    <ul class="mt-2 space-y-1 text-sm text-zinc-600">
                        @foreach ($service->requirements as $requirement)
                            <li>{{ $requirement->name }}{{ $requirement->is_required ? ' (wajib)' : ' (opsional)' }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid gap-4 md:grid-cols-2">
                @forelse ($service->activeFields as $field)
                    @include('services.partials.dynamic-field', ['field' => $field])
                @empty
                    <p class="text-sm text-zinc-500">Layanan ini belum memiliki field aktif.</p>
                @endforelse
            </div>

            <x-form.actions>
                <x-ui.button type="submit" :disabled="$service->activeFields->isEmpty()">Validasi Form</x-ui.button>
                <x-ui.button as="a" href="{{ route('services.show', $service) }}" variant="secondary">Batal</x-ui.button>
            </x-form.actions>
        </form>
    </x-ui.card>
@endsection
