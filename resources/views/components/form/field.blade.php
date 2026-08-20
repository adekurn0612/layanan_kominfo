@props(['label' => null, 'for' => null, 'required' => false, 'help' => null, 'error' => null])

<div {{ $attributes->merge(['class' => 'space-y-2']) }}>
    @if ($label)
        <label for="{{ $for }}" class="block text-sm font-medium text-[#0B3558]">
            {{ $label }}
            @if ($required)
                <span class="ml-1 text-[#9D1D27]">*</span>
            @endif
        </label>
    @endif

    {{ $slot }}

    @if ($help)
        <p class="text-xs text-[#5B7180]">{{ $help }}</p>
    @endif

    @if ($error)
        <p class="text-sm text-[#9D1D27]">{{ $error }}</p>
    @endif
</div>
