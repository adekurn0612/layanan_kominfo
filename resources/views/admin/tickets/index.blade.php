@extends('layouts.app', ['title' => 'Tindak Lanjut Tiket'])

@section('content')
    <div class="overflow-hidden rounded-lg border border-[#CDEAF5] bg-white">
        <table class="w-full divide-y divide-[#CDEAF5] text-sm">
            <thead class="bg-[#F7FBFD] text-left text-xs font-semibold uppercase text-zinc-500">
                <tr>
                    <th class="px-4 py-3">Tiket</th>
                    <th class="px-4 py-3">Layanan</th>
                    <th class="px-4 py-3">Pemohon</th>
                    <th class="px-4 py-3">Diajukan</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#EAF8FC]">
                @forelse ($tickets as $ticket)
                    <tr>
                        <td class="px-4 py-3 font-mono text-xs">{{ $ticket->uuid }}</td>
                        <td class="px-4 py-3 font-medium">{{ $ticket->service->name }}</td>
                        <td class="px-4 py-3">{{ $ticket->user?->name ?? 'Publik' }}</td>
                        <td class="px-4 py-3 text-zinc-500">{{ $ticket->submitted_at?->format('d M Y H:i') ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $statuses[$ticket->status] ?? ucfirst(str_replace('_', ' ', $ticket->status)) }}</td>
                        <td class="px-4 py-3 text-right"><a href="{{ route('admin.tickets.edit', $ticket) }}" class="font-medium underline">Tindak lanjut</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-8 text-center text-zinc-500">Belum ada tiket.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $tickets->links() }}</div>
@endsection
