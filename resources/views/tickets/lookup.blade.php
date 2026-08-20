@extends('layouts.app', ['title' => 'Cek Tiket'])

@section('content')
    <div class="mx-auto max-w-4xl py-8 @guest px-5 @endguest">
        <div class="mb-6 flex items-center justify-between gap-4">
            <div>
                <a href="{{ route('welcome') }}" class="inline-flex min-w-0">
                    <x-app-logo size="sm" />
                </a>
                <h1 class="mt-2 text-2xl font-semibold tracking-tight text-zinc-950">Cek Tiket</h1>
                <p class="mt-1 text-sm text-zinc-600">Masukkan UUID tiket untuk melihat status pengajuan layanan.</p>
            </div>
            @auth
                <x-ui.button as="a" href="{{ route('dashboard') }}" variant="secondary">Dashboard</x-ui.button>
            @else
                <x-ui.button as="a" href="{{ route('login') }}" variant="secondary">Masuk</x-ui.button>
            @endauth
        </div>

        <x-ui.card>
            <form method="GET" action="{{ route('tickets.lookup') }}" class="grid gap-3 md:grid-cols-[1fr_auto]">
                <label class="block">
                    <span class="mb-1 block text-sm font-medium text-zinc-700">UUID Tiket</span>
                    <input
                        type="text"
                        name="uuid"
                        value="{{ $uuid }}"
                        placeholder="Contoh: 9f8d7c6b-1234-4a5b-9cde-1029384756ab"
                        class="w-full rounded-md border border-[#B8E2F0] px-3 py-2 text-sm text-zinc-900 outline-none transition focus:border-[#137CBD] focus:ring-2 focus:ring-[#BFEAF5]"
                    >
                </label>
                <div class="flex items-end">
                    <x-ui.button type="submit" class="w-full md:w-auto">Cek Tiket</x-ui.button>
                </div>
            </form>
        </x-ui.card>

        @if ($ticket)
            @php
                $statusClasses = [
                    'submitted' => 'bg-[#EAF8FC] text-[#137CBD]',
                    'in_review' => 'bg-sky-50 text-sky-700',
                    'verified' => 'bg-sky-50 text-sky-700',
                    'in_progress' => 'bg-amber-50 text-amber-700',
                    'completed' => 'bg-[#0B3558] text-white',
                    'rejected' => 'bg-red-50 text-red-700',
                ][$ticket->status] ?? 'bg-[#EAF8FC] text-zinc-700';

                $statusLabel = [
                    'submitted' => 'Diajukan',
                    'in_review' => 'Sedang Diverifikasi',
                    'verified' => 'Terverifikasi',
                    'in_progress' => 'Diproses',
                    'completed' => 'Selesai',
                    'rejected' => 'Ditolak',
                ][$ticket->status] ?? ucfirst(str_replace('_', ' ', $ticket->status));
            @endphp

            <x-ui.card class="mt-5">
                <div class="flex flex-wrap items-start justify-between gap-4 border-b border-[#CDEAF5] pb-4">
                    <div>
                        <div class="text-sm font-medium text-zinc-500">{{ $ticket->service->category->name }}</div>
                        <h2 class="mt-1 text-xl font-semibold text-zinc-950">{{ $ticket->service->name }}</h2>
                        <p class="mt-2 break-all font-mono text-sm text-zinc-600">{{ $ticket->uuid }}</p>
                    </div>
                    <span class="rounded-md px-3 py-1 text-sm font-semibold {{ $statusClasses }}">{{ $statusLabel }}</span>
                </div>

                <dl class="mt-5 grid gap-4 md:grid-cols-3">
                    <div>
                        <dt class="text-sm font-medium text-zinc-500">Tanggal Masuk</dt>
                        <dd class="mt-1 text-sm font-semibold text-zinc-900">{{ $ticket->submitted_at?->format('d M Y H:i') ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-zinc-500">SLA Layanan</dt>
                        <dd class="mt-1 text-sm font-semibold text-zinc-900">{{ $ticket->service->sla_hours }} jam</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-zinc-500">Terakhir Diperbarui</dt>
                        <dd class="mt-1 text-sm font-semibold text-zinc-900">{{ $ticket->updated_at?->format('d M Y H:i') ?? '-' }}</dd>
                    </div>
                </dl>
            </x-ui.card>

            @if ($canViewFollowUps && $ticket->followUps->isNotEmpty())
                <x-ui.card class="mt-5">
                    <h2 class="font-semibold">Informasi dari Petugas</h2>
                    <div class="mt-4 space-y-4">
                        @foreach ($ticket->followUps as $followUp)
                            <article class="border-l-2 border-[#19AEDD] pl-4">
                                <time class="text-xs text-zinc-500">{{ $followUp->created_at->format('d M Y H:i') }}</time>
                                @if ($followUp->comment)
                                    <p class="mt-1 whitespace-pre-line text-sm text-zinc-700">{{ $followUp->comment }}</p>
                                @endif
                                @if ($followUp->file_path)
                                    <a href="{{ route('tickets.follow-ups.file', [$ticket, $followUp->id]) }}" class="mt-2 inline-block text-sm font-medium underline">Lihat lampiran: {{ $followUp->file_name }}</a>
                                @endif
                            </article>
                        @endforeach
                    </div>
                </x-ui.card>
            @endif
        @elseif ($searched)
            <x-ui.card class="mt-5 border-red-200 bg-red-50">
                <h2 class="text-base font-semibold text-red-800">Tiket tidak ditemukan</h2>
                <p class="mt-1 text-sm text-red-700">Periksa kembali UUID tiket yang dimasukkan.</p>
            </x-ui.card>
        @endif
    </div>
@endsection
