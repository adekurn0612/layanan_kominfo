@props(['align' => 'start'])

@php
    $alignClass = match ($align) {
        'end' => 'justify-end',
        'center' => 'justify-center',
        default => 'justify-start',
    };
@endphp

<div {{ $attributes->merge(['class' => 'mt-6 flex flex-wrap gap-3 ' . $alignClass]) }}>
    {{ $slot }}
</div>
