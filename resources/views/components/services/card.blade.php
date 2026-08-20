@props(['service'])

<a href="{{ route('services.show', $service) }}" {{ $attributes->merge(['class' => 'group block rounded-lg border border-[#CDEAF5] bg-white p-5 shadow-sm shadow-[#137CBD]/5 transition hover:border-[#19AEDD] hover:shadow-md hover:shadow-[#137CBD]/10']) }}>
    <div class="flex items-start justify-between gap-3">
        <h3 class="font-semibold text-[#0B3558]">{{ $service->name }}</h3>
        <span class="rounded-full bg-[#EAF8FC] px-2 py-1 text-xs font-semibold text-[#137CBD]">{{ $service->sla_hours }} jam</span>
    </div>
    <p class="mt-2 line-clamp-3 text-sm leading-6 text-zinc-600">{{ $service->description }}</p>
    <div class="mt-4 flex items-center justify-between gap-3 border-t border-[#EAF8FC] pt-4 text-xs font-semibold">
        <span class="text-zinc-500">{{ $service->requirements_count ?? $service->requirements()->count() }} persyaratan</span>
        <span class="text-[#137CBD] transition group-hover:text-[#0B3558]">Lihat detail</span>
    </div>
</a>
