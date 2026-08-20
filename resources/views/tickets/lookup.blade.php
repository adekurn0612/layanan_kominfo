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
            <div class="mt-4 border-t border-[#EAF8FC] pt-4">
                <label for="qr-upload" class="mb-1 block text-sm font-medium text-zinc-700">Atau upload QR tiket</label>
                <input id="qr-upload" type="file" accept="image/*" class="block w-full rounded-md border border-[#B8E2F0] px-3 py-2 text-sm">
                <p id="qr-upload-status" class="mt-1 text-xs text-zinc-500">QR akan dibaca otomatis untuk mengisi UUID.</p>
            </div>
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

    @if ($showCreatedModal)
        <div id="ticket-created-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-[#0B3558]/60 px-5" role="dialog" aria-modal="true" aria-labelledby="ticket-created-title">
            <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-2xl">
                <div class="text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[#EAF8FC] text-2xl text-[#137CBD]">&#10003;</div>
                    <h2 id="ticket-created-title" class="mt-4 text-xl font-semibold text-[#0B3558]">Terima kasih, tiket berhasil dibuat</h2>
                    <p class="mt-2 text-sm text-zinc-600">Simpan UUID berikut untuk memeriksa status tiket Anda.</p>
                    <p class="mt-4 break-all rounded-md bg-[#F7FBFD] px-3 py-3 font-mono text-sm font-semibold text-zinc-900">{{ $ticket->uuid }}</p>
                    <div class="mt-5 flex flex-wrap justify-center gap-3">
                        <a href="{{ route('tickets.qr.download', $ticket) }}" class="rounded-md bg-[#137CBD] px-4 py-2 text-sm font-semibold text-white hover:bg-[#0D6EAE]">Download QR Tiket</a>
                        <button type="button" data-close-ticket-modal class="rounded-md border border-[#B8E2F0] px-4 py-2 text-sm font-semibold text-zinc-700 hover:bg-[#F7FBFD]">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
    <script>
        document.querySelector('[data-close-ticket-modal]')?.addEventListener('click', () => {
            document.getElementById('ticket-created-modal')?.remove();
        });

        document.getElementById('qr-upload')?.addEventListener('change', function (event) {
            const file = event.target.files?.[0];
            const status = document.getElementById('qr-upload-status');
            if (!file) return;

            const image = new Image();
            const reader = new FileReader();
            reader.onload = () => {
                image.onload = () => {
                    const canvas = document.createElement('canvas');
                    canvas.width = image.naturalWidth;
                    canvas.height = image.naturalHeight;
                    const context = canvas.getContext('2d');
                    context.drawImage(image, 0, 0);
                    const result = jsQR(context.getImageData(0, 0, canvas.width, canvas.height).data, canvas.width, canvas.height);
                    if (!result?.data) {
                        status.textContent = 'QR tidak dapat dibaca. Silakan upload gambar QR yang jelas.';
                        status.className = 'mt-1 text-xs text-red-600';
                        return;
                    }

                    const url = new URL(result.data, window.location.origin);
                    const uuid = url.searchParams.get('uuid') || result.data.trim();
                    document.querySelector('input[name="uuid"]').value = uuid;
                    document.querySelector('form[action="{{ route('tickets.lookup') }}"]').submit();
                };
                image.src = reader.result;
            };
            reader.readAsDataURL(file);
        });
    </script>
@endpush
