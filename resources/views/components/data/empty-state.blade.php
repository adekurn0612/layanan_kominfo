@props(['title' => 'Tidak ada data', 'description' => null])

<div {{ $attributes->merge(['class' => 'rounded-lg border border-[#CDEAF5] bg-white p-5 text-sm text-[#5B7180]']) }}>
    <div class="font-medium text-[#137CBD]">{{ $title }}</div>
    @if ($description)
        <p class="mt-1">{{ $description }}</p>
    @endif
</div>
