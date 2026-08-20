@props(['category'])

<a href="{{ route('services.categories.show', $category) }}" {{ $attributes->merge(['class' => 'group flex flex-col overflow-hidden rounded-lg border border-zinc-200 bg-white shadow-sm transition hover:border-[#19AEDD] hover:shadow-md hover:shadow-[#137CBD]/10']) }}>
    {{-- Logo area with decorative frame --}}
    <div class="relative mx-auto mt-5 flex h-36 w-36 items-center justify-center">
        {{-- Decorative organic border --}}
        <svg class="absolute inset-0 h-full w-full text-[#B8E2F0]" viewBox="0 0 144 144" fill="currentColor" aria-hidden="true">
            <path d="M72 4C72 4 88 20 88 36C88 52 72 68 72 68C72 68 56 52 56 36C56 20 72 4 72 4Z" opacity="0.6"/>
            <path d="M4 72C4 72 20 56 36 56C52 56 68 72 68 72C68 72 52 88 36 88C20 88 4 72 4 72Z" opacity="0.5"/>
            <path d="M140 72C140 72 124 88 108 88C92 88 76 72 76 72C76 72 92 56 108 56C124 56 140 72 140 72Z" opacity="0.5"/>
            <path d="M72 140C72 140 88 124 88 108C88 92 72 76 72 76C72 76 56 92 56 108C56 124 72 140 72 140Z" opacity="0.6"/>
            <path d="M20 20C20 20 32 32 32 44C32 56 20 68 20 68C20 68 8 56 8 44C8 32 20 20 20 20Z" opacity="0.35"/>
            <path d="M124 20C124 20 136 32 136 44C136 56 124 68 124 68C124 68 112 56 112 44C112 32 124 20 124 20Z" opacity="0.35"/>
            <path d="M20 124C20 124 32 112 32 100C32 88 20 76 20 76C20 76 8 88 8 100C8 112 20 124 20 124Z" opacity="0.35"/>
            <path d="M124 124C124 124 136 112 136 100C136 88 124 76 124 76C124 76 112 88 112 100C112 112 124 124 124 124Z" opacity="0.35"/>
        </svg>
        <div class="relative flex h-28 w-28 items-center justify-center overflow-hidden rounded-md bg-white p-3">
            <img src="{{ $category->image_url }}" alt="Logo {{ $category->name }}" class="max-h-full max-w-full object-contain">
        </div>
    </div>

    {{-- Category name --}}
    <div class="flex flex-1 flex-col px-4 pb-3 pt-4">
        <h3 class="min-h-[3.5rem] text-sm font-medium leading-snug text-zinc-800">{{ $category->name }}</h3>
    </div>

    {{-- Service count footer --}}
    <div class="flex items-center gap-2 border-t border-zinc-200 px-4 py-3">
        <svg class="h-4 w-4 shrink-0 text-[#2D32AA]" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
            <path d="M1 12V4a1 1 0 0 1 1-1h3v9H2a1 1 0 0 1-1-1zm5 0V3h4v9H6zm6 0V3h2a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-3z"/>
        </svg>
        <span class="text-xs font-bold uppercase tracking-wide text-[#2D32AA]">
            {{ $category->services_count }} Layanan
        </span>
    </div>
</a>
