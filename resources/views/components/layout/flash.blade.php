@props(['message' => null, 'type' => 'success'])

@if ($message)
    @php
        $typeClasses = match ($type) {
            'error' => 'border-[#F2C1C6] bg-[#FFF3F4] text-[#9D1D27]',
            'warning' => 'border-[#F5C521] bg-[#FFF8D9] text-[#8A6500]',
            'info' => 'border-[#19AEDD] bg-[#EAF8FC] text-[#137CBD]',
            default => 'border-[#19AEDD] bg-[#EAF8FC] text-[#137CBD]',
        };
    @endphp

    <div {{ $attributes->merge(['class' => 'mb-4 rounded-md border px-4 py-3 text-sm ' . $typeClasses]) }}>
        {{ $message }}
    </div>
@endif
