@extends('layouts.app', ['title' => 'Tindak Lanjut Tiket'])

@section('content')
    <div class="grid max-w-4xl gap-5 lg:grid-cols-[1fr_320px]">
        <section class="rounded-lg border border-[#CDEAF5] bg-white p-5">
            <div class="text-sm text-zinc-500">{{ $ticket->service->category->name }}</div>
            <h2 class="mt-1 text-xl font-semibold">{{ $ticket->service->name }}</h2>
            <p class="mt-2 break-all font-mono text-xs text-zinc-500">{{ $ticket->uuid }}</p>

            <dl class="mt-5 grid gap-4 text-sm sm:grid-cols-2">
                <div><dt class="text-zinc-500">Pemohon</dt><dd class="font-medium">{{ $ticket->user?->name ?? 'Publik' }}</dd></div>
                <div><dt class="text-zinc-500">Organisasi</dt><dd class="font-medium">{{ $ticket->organization?->name ?? '-' }}</dd></div>
                <div><dt class="text-zinc-500">Diajukan</dt><dd class="font-medium">{{ $ticket->submitted_at?->format('d M Y H:i') ?? '-' }}</dd></div>
                <div><dt class="text-zinc-500">Terakhir diperbarui</dt><dd class="font-medium">{{ $ticket->updated_at?->format('d M Y H:i') ?? '-' }}</dd></div>
            </dl>
        </section>

        <section class="rounded-lg border border-[#CDEAF5] bg-white p-5">
            <h3 class="font-semibold">Perbarui Status</h3>
            <form method="POST" action="{{ route('admin.tickets.update', $ticket) }}" class="mt-4 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label for="status" class="mb-1 block text-sm font-medium">Status</label>
                    <select id="status" name="status" class="w-full rounded-md border border-[#B8E2F0] px-3 py-2 text-sm">
                        @foreach ($statuses as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', $ticket->status) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('status')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="w-full rounded-md bg-[#137CBD] px-4 py-2 text-sm font-semibold text-white hover:bg-[#0D6EAE]">Simpan Status</button>
            </form>
        </section>
    </div>

    <section class="mt-5 max-w-4xl rounded-lg border border-[#CDEAF5] bg-white p-5">
        <h3 class="font-semibold">Tambah Tindak Lanjut</h3>
        <form method="POST" action="{{ route('admin.tickets.follow-ups.store', $ticket) }}" enctype="multipart/form-data" class="mt-4 space-y-4">
            @csrf
            <div>
                <label for="comment" class="mb-1 block text-sm font-medium">Komentar</label>
                <textarea id="comment" name="comment" rows="4" maxlength="5000" class="w-full rounded-md border border-[#B8E2F0] px-3 py-2 text-sm" placeholder="Tuliskan perkembangan atau hasil tindak lanjut...">{{ old('comment') }}</textarea>
                @error('comment')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="file" class="mb-1 block text-sm font-medium">Lampiran</label>
                <input id="file" name="file" type="file" accept="image/jpeg,image/png,application/pdf" class="block w-full rounded-md border border-[#B8E2F0] px-3 py-2 text-sm">
                <p class="mt-1 text-xs text-zinc-500">JPG, JPEG, PNG, atau PDF. Maksimal 5 MB.</p>
                @error('file')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <label class="flex items-start gap-2 text-sm">
                <input type="checkbox" name="is_public" value="1" @checked(old('is_public', true)) class="mt-1 rounded border-[#B8E2F0]">
                <span><span class="font-medium">Tampilkan ke pengaju</span><span class="block text-xs text-zinc-500">Komentar dan lampiran dapat dilihat melalui halaman Cek Tiket.</span></span>
            </label>
            <button type="submit" class="rounded-md bg-[#137CBD] px-4 py-2 text-sm font-semibold text-white hover:bg-[#0D6EAE]">Tambah Tindak Lanjut</button>
        </form>
    </section>

    <section class="mt-5 max-w-4xl rounded-lg border border-[#CDEAF5] bg-white p-5">
        <h3 class="font-semibold">Riwayat Tindak Lanjut</h3>
        <div class="mt-4 space-y-4">
            @forelse ($followUps as $followUp)
                <article class="border-l-2 border-[#19AEDD] pl-4">
                    <div class="flex flex-wrap justify-between gap-2 text-xs text-zinc-500">
                        <span>{{ $followUp->user->name }}</span>
                        <time>{{ $followUp->created_at->format('d M Y H:i') }}</time>
                    </div>
                    <span class="mt-1 inline-block text-xs font-medium {{ $followUp->is_public ? 'text-emerald-700' : 'text-zinc-500' }}">{{ $followUp->is_public ? 'Publik' : 'Internal' }}</span>
                    @if ($followUp->comment)
                        <p class="mt-2 whitespace-pre-line text-sm text-zinc-700">{{ $followUp->comment }}</p>
                    @endif
                    @if ($followUp->file_path)
                        <a href="{{ route('admin.tickets.follow-ups.file', [$ticket, $followUp->id]) }}" class="mt-2 inline-block text-sm font-medium underline">Unduh {{ $followUp->file_name }}</a>
                    @endif
                </article>
            @empty
                <p class="text-sm text-zinc-500">Belum ada tindak lanjut.</p>
            @endforelse
        </div>
    </section>
@endsection
