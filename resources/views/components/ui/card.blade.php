@props(['title' => null, 'description' => null, 'padding' => 'md'])

@php
    $paddingClass = match ($padding) {
        'sm' => 'p-4',
        'md' => 'p-5',
        'lg' => 'p-6',
        default => 'p-5',
    };
@endphp

<section {{ $attributes->merge(['class' => 'rounded-lg border border-[#CDEAF5] bg-white shadow-sm shadow-[#137CBD]/5 ' . $paddingClass]) }}>
    @if ($title || $description)
        <div class="mb-4">
            @if ($title)
                <h3 class="text-base font-semibold text-zinc-900">{{ $title }}</h3>
            @endif
            @if ($description)
                <p class="mt-1 text-sm text-zinc-600">{{ $description }}</p>
            @endif
        </div>
    @endif

    {{ $slot }}
</section>
