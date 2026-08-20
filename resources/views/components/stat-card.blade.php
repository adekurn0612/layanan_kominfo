@props(['label', 'value'])

<div class="overflow-hidden rounded-lg border border-[#CDEAF5] bg-white shadow-sm shadow-[#137CBD]/5">
    <div class="flex h-1.5">
        <div class="w-1/2 bg-[#137CBD]"></div>
        <div class="w-1/4 bg-[#19AEDD]"></div>
        <div class="w-1/4 bg-[#F5C521]"></div>
    </div>
    <div class="p-5">
        <div class="text-sm font-medium text-[#5B7180]">{{ $label }}</div>
        <div class="mt-2 text-3xl font-semibold text-[#0B3558]">{{ $value }}</div>
    </div>
</div>
