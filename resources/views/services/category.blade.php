@extends('layouts.app', ['title' => $category->name])

@section('content')
    <div class="space-y-6">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-zinc-500">
            <a href="{{ route('services.index') }}" class="font-medium text-[#137CBD] transition hover:text-[#0B3558]">Katalog Layanan</a>
            <svg class="h-4 w-4 shrink-0" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M6.22 4.22a.75.75 0 0 1 1.06 0l3.25 3.25a.75.75 0 0 1 0 1.06l-3.25 3.25a.75.75 0 0 1-1.06-1.06L8.94 8 6.22 5.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
            </svg>
            <span class="font-medium text-zinc-700">{{ $category->name }}</span>
        </nav>

        {{-- Category header --}}
        <section class="rounded-lg border border-[#CDEAF5] bg-white p-5 shadow-sm shadow-[#137CBD]/5">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                <div class="relative mx-auto flex h-28 w-28 shrink-0 items-center justify-center sm:mx-0">
                    <svg class="absolute inset-0 h-full w-full text-[#B8E2F0]" viewBox="0 0 112 112" fill="currentColor" aria-hidden="true">
                        <path d="M56 4C56 4 68 16 68 28C68 40 56 52 56 52C56 52 44 40 44 28C44 16 56 4 56 4Z" opacity="0.6"/>
                        <path d="M4 56C4 56 16 44 28 44C40 44 52 56 52 56C52 56 40 68 28 68C16 68 4 56 4 56Z" opacity="0.5"/>
                        <path d="M108 56C108 56 96 68 84 68C72 68 60 56 60 56C60 56 72 44 84 44C96 44 108 56 108 56Z" opacity="0.5"/>
                        <path d="M56 108C56 108 68 96 68 84C68 72 56 60 56 60C56 60 44 72 44 84C44 96 56 108 56 108Z" opacity="0.6"/>
                    </svg>
                    <div class="relative flex h-20 w-20 items-center justify-center overflow-hidden rounded-md bg-white p-2">
                        <img src="{{ $category->image_url }}" alt="Logo {{ $category->name }}" class="max-h-full max-w-full object-contain">
                    </div>
                </div>
                <div class="text-center sm:text-left">
                    <h1 class="text-xl font-semibold text-[#0B3558]">{{ $category->name }}</h1>
                    @if ($category->description)
                        <p class="mt-2 text-sm leading-6 text-zinc-600">{{ $category->description }}</p>
                    @endif
                    <p class="mt-2 text-xs font-bold uppercase tracking-wide text-[#2D32AA]">
                        {{ $category->services->count() }} Layanan Tersedia
                    </p>
                </div>
            </div>
        </section>

        {{-- Service list --}}
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($category->services as $service)
                <x-services.card :service="$service" />
            @empty
                <x-data.empty-state title="Belum ada layanan aktif" description="Belum ada layanan aktif pada kategori ini." />
            @endforelse
        </div>
    </div>
@endsection
