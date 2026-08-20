@props([
    'variant' => 'primary',
    'as' => 'button',
    'size' => 'md',
])

@php
    $baseClasses = 'inline-flex items-center justify-center rounded-md font-semibold transition focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-60';
    $sizeClasses = match ($size) {
        'sm' => 'px-3 py-2 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-5 py-2.5 text-base',
        default => 'px-4 py-2 text-sm',
    };
    $variantClasses = match ($variant) {
        'secondary' => 'border border-[#B8E2F0] bg-white text-[#137CBD] hover:bg-[#EAF8FC] focus:ring-[#19AEDD]',
        'danger' => 'border border-[#F2C1C6] bg-[#FFF3F4] text-[#9D1D27] hover:bg-[#FCE7EA] focus:ring-[#9D1D27]',
        'ghost' => 'bg-transparent text-[#137CBD] hover:bg-[#EAF8FC] focus:ring-[#19AEDD]',
        'primary' => 'bg-[#137CBD] text-white hover:bg-[#0D6EAE] focus:ring-[#19AEDD]',
        default => 'bg-[#137CBD] text-white hover:bg-[#0D6EAE] focus:ring-[#19AEDD]',
    };
@endphp

@if ($as === 'a')
    <a {{ $attributes->merge(['class' => trim($baseClasses . ' ' . $sizeClasses . ' ' . $variantClasses)]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => trim($baseClasses . ' ' . $sizeClasses . ' ' . $variantClasses)]) }}>
        {{ $slot }}
    </button>
@endif
