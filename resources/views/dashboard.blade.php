@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')

    <div class="overflow-hidden rounded-2xl border border-[#CDEAF5] bg-white shadow-sm shadow-[#137CBD]/5">
        <div class="p-4 md:p-5">
            <div class="rounded-xl border border-[#CDEAF5] bg-[#F7FBFD] p-4 text-center">
                <div class="mb-3 text-base font-semibold text-[#0B3558]">Kepatuhan SLA</div>
                <div class="text-3xl font-bold text-[#0B3558]">{{ number_format($slaFulfillmentRate, 1) }}%</div>
                <div class="mt-3 h-2.5 overflow-hidden rounded-full bg-[#DDEFF6]">
                    <div class="h-full rounded-full bg-[#137CBD]" style="width: {{ min($slaFulfillmentRate, 100) }}%"></div>
                </div>
                <div class="mt-3 text-sm text-[#5B7180]">{{ $onTimeCount }} tiket telah diselesaikan tepat waktu.</div>
            </div>

            <div class="mt-5 grid gap-3 md:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-xl border border-[#CDEAF5] bg-[#F7FBFD] p-3">
                    <div class="text-xs font-medium uppercase tracking-wide text-[#5B7180]">Total Tiket</div>
                    <div class="mt-2 text-2xl font-bold text-[#0B3558]">{{ $ticketCount }}</div>
                </div>
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-3">
                    <div class="text-xs font-medium uppercase tracking-wide text-emerald-700">Dalam SLA</div>
                    <div class="mt-2 text-2xl font-bold text-emerald-700">{{ $onTimeCount }}</div>
                </div>
                <div class="rounded-xl border border-amber-200 bg-amber-50 p-3">
                    <div class="text-xs font-medium uppercase tracking-wide text-amber-700">Hampir Lewat</div>
                    <div class="mt-2 text-2xl font-bold text-amber-700">{{ $nearDeadlineCount }}</div>
                </div>
                <div class="rounded-xl border border-red-200 bg-red-50 p-3">
                    <div class="text-xs font-medium uppercase tracking-wide text-red-700">Terlambat</div>
                    <div class="mt-2 text-2xl font-bold text-red-700">{{ $breachedCount }}</div>
                </div>
            </div>

            <div class="mt-5 rounded-xl border border-[#CDEAF5] bg-[#F7FBFD] p-4">
                <div class="mb-3 text-base font-semibold text-[#0B3558]">Status Tiket</div>
                <div class="grid gap-2 text-sm sm:grid-cols-2 xl:grid-cols-4">
                    @php
                        $statusLabels = [
                            'completed' => ['label' => 'Selesai', 'color' => 'bg-emerald-500'],
                            'in_progress' => ['label' => 'Proses', 'color' => 'bg-blue-500'],
                            'submitted' => ['label' => 'Menunggu', 'color' => 'bg-amber-500'],
                            'rejected' => ['label' => 'Ditolak', 'color' => 'bg-slate-500'],
                        ];
                    @endphp

                    @foreach (['completed', 'in_progress', 'submitted', 'rejected'] as $status)
                        @php $statusTotal = $statusSummary[$status] ?? 0; @endphp
                        <div class="flex items-center justify-between rounded-lg border border-[#DDEFF6] bg-white px-3 py-1.5">
                            <div class="flex items-center gap-3">
                                <span class="inline-block h-2.5 w-2.5 rounded-full {{ $statusLabels[$status]['color'] ?? 'bg-slate-400' }}"></span>
                                <span class="text-[#3F586A]">{{ $statusLabels[$status]['label'] ?? ucfirst(str_replace('_', ' ', $status)) }}</span>
                            </div>
                            <span class="font-semibold text-[#0B3558]">{{ $statusTotal }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            @if ($categorySummaries->isNotEmpty())
                <div class="mt-5 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($categorySummaries as $category)
                        <div class="overflow-hidden rounded-xl border border-[#CDEAF5] bg-white shadow-sm shadow-[#137CBD]/5">
                            <div class="border-b border-[#CDEAF5] bg-[#F7FBFD] px-3 py-2.5">
                                <h3 class="text-sm font-semibold leading-tight text-[#0B3558]">{{ $category->name }}</h3>
                            </div>
                            <div class="px-3 py-3">
                                <div class="rounded-lg border border-[#DDEFF6] bg-[#F7FBFD] px-3 py-2.5 text-center">
                                    <div class="text-2xl font-semibold text-[#0B3558]">{{ $category->total }}</div>
                                    <div class="mt-1 text-sm text-[#5B7180]">Jumlah Semua Pengajuan</div>
                                </div>
                                <div class="mt-3 space-y-1.5 rounded-lg bg-[#0B3558] px-3 py-2.5 text-sm text-white">
                                    <div class="flex items-center justify-between"><span>Diproses</span><span class="font-semibold">{{ $category->in_progress }}</span></div>
                                    <div class="flex items-center justify-between"><span>Selesai</span><span class="font-semibold">{{ $category->completed }}</span></div>
                                    <div class="flex items-center justify-between"><span>Gagal/Ditolak</span><span class="font-semibold">{{ $category->rejected }}</span></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="mt-5 rounded-xl border border-[#CDEAF5] bg-white">
                <div class="border-b border-[#CDEAF5] bg-[#F7FBFD] px-4 py-3">
                    <h3 class="text-base font-semibold text-[#0B3558]">Tiket Perlu Perhatian</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm text-[#3F586A]">
                        <thead class="bg-[#F7FBFD] text-xs uppercase tracking-wide text-[#5B7180]">
                            <tr>
                                <th class="px-5 py-3">No Tiket</th>
                                <th class="px-5 py-3">Layanan</th>
                                <th class="px-5 py-3">OPD</th>
                                <th class="px-5 py-3">SLA</th>
                                <th class="px-5 py-3">Sisa</th>
                                <th class="px-5 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($overdueTickets->take(5) as $ticket)
                                <tr class="border-t border-[#EAF8FC]">
                                    <td class="px-5 py-3 font-medium text-[#0B3558]">#{{ $ticket->id }}</td>
                                    <td class="px-5 py-3">{{ $ticket->service?->name ?? 'Layanan tidak tersedia' }}</td>
                                    <td class="px-5 py-3">{{ $ticket->organization?->name ?? 'OPD belum diatur' }}</td>
                                    <td class="px-5 py-3">{{ $ticket->service?->sla_hours ?? 0 }}j</td>
                                    <td class="px-5 py-3 text-red-600">
                                        @if ($ticket->target_deadline_at && $ticket->resolved_at)
                                            {{ $ticket->resolved_at->diffInHours($ticket->target_deadline_at, false) }}h
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-5 py-3">
                                        <span class="inline-flex rounded-full bg-red-100 px-2 py-1 text-xs font-semibold text-red-700">⚠</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-5 py-8 text-center text-[#5B7180]">Belum ada tiket yang memerlukan perhatian.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
