@props([
    'size' => 'md',
    'showText' => true,
    'textClass' => 'text-zinc-950',
])

@php
    $imageClasses = match ($size) {
        'sm' => 'h-9 w-9',
        'lg' => 'h-14 w-14',
        default => 'h-11 w-11',
    };
@endphp

<div {{ $attributes->merge(['class' => 'flex min-w-0 items-center gap-3']) }}>
    <img
        src="{{ asset('images/logo-bengkulu-selatan.png') }}"
        alt="Logo Kabupaten Bengkulu Selatan"
        class="{{ $imageClasses }} shrink-0 object-contain"
    >
    @if ($showText)
        <div class="min-w-0">
            <div class="truncate text-sm font-semibold leading-tight {{ $textClass }}">Pusat Layanan</div>
            <div class="truncate text-xs font-medium leading-tight text-zinc-500">Kabupaten Bengkulu Selatan</div>
        </div>
    @endif
</div>
