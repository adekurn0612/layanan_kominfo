@props(['active'])

<span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold {{ $active ? 'bg-[#EAF8FC] text-[#137CBD]' : 'bg-[#FFF8D9] text-[#8A6500]' }}">
    {{ $active ? 'Aktif' : 'Nonaktif' }}
</span>
