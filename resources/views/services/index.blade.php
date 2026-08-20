@extends('layouts.app', ['title' => 'Katalog Layanan'])

@section('content')
    <div class="space-y-6">
        @guest
            <section class="rounded-lg border border-[#CDEAF5] bg-white p-5 shadow-sm shadow-[#137CBD]/5">
                <div class="max-w-3xl">
                    <p class="text-sm font-semibold text-[#137CBD]">Katalog Layanan Publik</p>
                    <h1 class="mt-2 text-2xl font-semibold tracking-tight text-[#0B3558]">Pilih kategori layanan untuk melihat daftar pelayanan.</h1>
                    <p class="mt-3 text-sm leading-6 text-zinc-600">Semua orang dapat melihat daftar layanan, detail SLA, formulir yang akan diisi, dan dokumen persyaratan. Pengajuan layanan akan meminta login terlebih dahulu.</p>
                </div>
            </section>
        @endguest

        @auth
            <div>
                <h1 class="text-xl font-semibold text-[#0B3558]">Katalog Layanan</h1>
                <p class="mt-1 text-sm text-zinc-600">Pilih kategori untuk melihat daftar layanan yang tersedia.</p>
            </div>
        @endauth

        <div class="grid gap-5 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6">
            @forelse ($categories as $category)
                <x-services.category-card :category="$category" />
            @empty
                <div class="col-span-full">
                    <x-data.empty-state title="Belum ada kategori layanan" description="Saat ini belum ada kategori layanan yang tersedia." />
                </div>
            @endforelse
        </div>
    </div>
@endsection
