@php
    $disabled = $disabled ?? false;
    $inputName = "fields[{$field->name}]";
    $errorName = "fields.{$field->name}";
    $value = old("fields.{$field->name}");
    $baseClass = 'mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2 text-sm focus:border-[#137CBD] focus:outline-none focus:ring-2 focus:ring-[#BFEAF5]';
@endphp

<div>
    <label class="text-sm font-medium text-[#0B3558]" for="field_{{ $field->name }}">
        {{ $field->label }}
        @if ($field->is_required)
            <span class="text-[#9D1D27]">*</span>
        @endif
    </label>

    @if ($field->type === 'textarea')
        <textarea id="field_{{ $field->name }}" name="{{ $inputName }}" rows="4" placeholder="{{ $field->placeholder }}" @disabled($disabled) class="{{ $baseClass }}">{{ $value }}</textarea>
    @elseif ($field->type === 'select')
        <select id="field_{{ $field->name }}" name="{{ $inputName }}" @disabled($disabled) class="{{ $baseClass }}">
            <option value="">Pilih</option>
            @foreach ($field->normalizedOptions() as $option)
                <option value="{{ $option }}" @selected($value === $option)>{{ $option }}</option>
            @endforeach
        </select>
    @elseif ($field->type === 'radio')
        <div class="mt-2 grid gap-2 sm:grid-cols-2">
            @foreach ($field->normalizedOptions() as $option)
                <label class="flex items-center gap-2 rounded-md border border-[#CDEAF5] px-3 py-2 text-sm transition hover:bg-[#EAF8FC]">
                    <input type="radio" name="{{ $inputName }}" value="{{ $option }}" @checked($value === $option) @disabled($disabled) class="border-[#B8E2F0]">
                    {{ $option }}
                </label>
            @endforeach
        </div>
    @elseif ($field->type === 'checkbox')
        <div class="mt-2 grid gap-2 sm:grid-cols-2">
            @foreach ($field->normalizedOptions() as $option)
                <label class="flex items-center gap-2 rounded-md border border-[#CDEAF5] px-3 py-2 text-sm transition hover:bg-[#EAF8FC]">
                    <input type="checkbox" name="{{ $inputName }}[]" value="{{ $option }}" @checked(in_array($option, (array) $value, true)) @disabled($disabled) class="rounded border-[#B8E2F0]">
                    {{ $option }}
                </label>
            @endforeach
        </div>
    @elseif ($field->type === 'file')
        <input id="field_{{ $field->name }}" name="{{ $inputName }}" type="file" @disabled($disabled) class="{{ $baseClass }}">
    @else
        <input id="field_{{ $field->name }}" name="{{ $inputName }}" type="{{ $field->type === 'datetime' ? 'datetime-local' : ($field->type === 'phone' ? 'tel' : $field->type) }}" value="{{ $value }}" placeholder="{{ $field->placeholder }}" @disabled($disabled) class="{{ $baseClass }}">
    @endif

    @if ($field->description)
        <p class="mt-1 text-xs text-zinc-500">{{ $field->description }}</p>
    @endif
    @error($errorName) <p class="mt-1 text-sm text-[#9D1D27]">{{ $message }}</p> @enderror
</div>
