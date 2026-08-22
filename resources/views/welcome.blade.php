<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#F7FBFD] text-zinc-950 antialiased">
        <header class="border-b border-[#D7EDF6] bg-white">
            <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-5 py-4">
                <a href="{{ route('welcome') }}" class="min-w-0">
                    <x-app-logo size="sm" />
                </a>
                <nav class="flex items-center gap-2 text-sm font-medium text-zinc-700">
                    <a href="{{ route('welcome') }}" @class(['rounded-md px-3 py-2 transition hover:bg-[#EAF8FC] hover:text-[#137CBD]', 'bg-[#EAF8FC] text-[#137CBD]' => request()->routeIs('welcome')]) @if(request()->routeIs('welcome')) aria-current="page" @endif>Beranda</a>
                    <a href="{{ route('services.index') }}" @class(['rounded-md px-3 py-2 transition hover:bg-[#EAF8FC] hover:text-[#137CBD]', 'bg-[#EAF8FC] text-[#137CBD]' => request()->routeIs('services.*')]) @if(request()->routeIs('services.*')) aria-current="page" @endif>Katalog Layanan</a>
                    <a href="{{ route('news.index') }}" @class(['rounded-md px-3 py-2 transition hover:bg-[#EAF8FC] hover:text-[#137CBD]', 'bg-[#EAF8FC] text-[#137CBD]' => request()->routeIs('news.*')]) @if(request()->routeIs('news.*')) aria-current="page" @endif>Berita</a>
                    <a href="{{ route('tickets.lookup') }}" @class(['rounded-md px-3 py-2 transition hover:bg-[#EAF8FC] hover:text-[#137CBD]', 'bg-[#EAF8FC] text-[#137CBD]' => request()->routeIs('tickets.lookup')]) @if(request()->routeIs('tickets.lookup')) aria-current="page" @endif>Cek Tiket</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="rounded-md bg-[#137CBD] px-3 py-2 text-white transition hover:bg-[#0D6EAE]" @if(request()->routeIs('dashboard')) aria-current="page" @endif>Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="rounded-md bg-[#137CBD] px-3 py-2 text-white transition hover:bg-[#0D6EAE]">Masuk</a>
                    @endauth
                </nav>
            </div>
        </header>

        <main>
            <section class="border-b border-[#D7EDF6] bg-white">
                <div class="mx-auto grid max-w-7xl gap-10 px-5 py-5 lg:grid-cols-[1fr_460px] lg:items-center lg:py-7">
                    <div>
                        <div class="inline-flex items-center gap-2 rounded-md border border-[#CDEAF5] bg-[#EAF8FC] px-3 py-2 text-sm font-semibold text-[#137CBD]">
                            <span class="h-2.5 w-2.5 rounded-sm bg-[#9D1D27]"></span>
                            <span class="h-2.5 w-2.5 rounded-sm bg-[#19AEDD]"></span>
                            <span class="h-2.5 w-2.5 rounded-sm bg-[#F5C521]"></span>
                            <span>Portal Digital Bengkulu Selatan</span>
                        </div>
                        <h1 class="mt-4 max-w-3xl text-4xl font-semibold tracking-tight text-zinc-950 sm:text-5xl">
                            Ajukan layanan Digital dan pantau dalam satu pintu.
                        </h1>
                        <p class="mt-4 max-w-2xl text-base leading-7 text-zinc-600">
                            Portal ini membantu Masyarakat dan instansi  mengajukan kebutuhan layanan digital secara online, memantau status pengajuan, dan mendapatkan informasi terkait layanan digital yang tersedia.
                        </p>
                        <div class="mt-7 flex flex-wrap gap-3">
                            @auth
                                <a href="{{ route('services.index') }}" class="inline-flex items-center justify-center rounded-md bg-[#137CBD] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#0D6EAE]">Ajukan Layanan</a>
                            @else
                                <a href="{{ route('services.index') }}" class="inline-flex items-center justify-center rounded-md bg-[#137CBD] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#0D6EAE]">Lihat Katalog Layanan</a>
                            @endauth
                            <a href="{{ route('tickets.lookup') }}" class="inline-flex items-center justify-center rounded-md border border-[#19AEDD] bg-white px-5 py-3 text-sm font-semibold text-[#137CBD] transition hover:bg-[#EAF8FC]">Cek Tiket</a>
                        </div>
                    </div>

                    <div class="relative overflow-hidden rounded-lg border border-[#0D6EAE] bg-[#0B3558] p-5 text-white">
    <!-- Aksen warna -->
    <div class="absolute inset-y-0 right-0 w-44 bg-[#19AEDD]"></div>
    <div class="absolute left-0 top-0 h-1.5 w-24 bg-[#9D1D27]"></div>
    <div class="absolute left-24 top-0 h-1.5 w-24 bg-[#F5C521]"></div>

    <!-- Konten -->
    <div class="relative rounded-md bg-white p-5 text-zinc-950 shadow-sm ring-1 ring-white/20">

        <!-- Judul -->
        <div class="border-b border-[#CDEAF5] pb-3">
            <div class="text-xs font-semibold uppercase tracking-[0.16em] text-[#137CBD]">
                Cara Menggunakan Layanan
            </div>

            <div class="mt-1 text-lg font-semibold text-zinc-950">
                Mudah, cepat, dan transparan
            </div>
        </div>

        <!-- Langkah -->
        <div class="mt-5 space-y-4">

            <!-- 01 -->
            <div class="flex items-start gap-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-[#EAF8FC] text-sm font-bold text-[#137CBD]">
                    01
                </div>

                <div>
                    <div class="font-semibold text-zinc-950">
                        Pilih Layanan
                    </div>
                    <div class="mt-0.5 text-sm leading-5 text-zinc-500">
                        Temukan layanan yang sesuai dengan kebutuhan Anda.
                    </div>
                </div>
            </div>

            <!-- 02 -->
            <div class="flex items-start gap-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-[#EAF8FC] text-sm font-bold text-[#19AEDD]">
                    02
                </div>

                <div>
                    <div class="font-semibold text-zinc-950">
                        Ajukan Permintaan
                    </div>
                    <div class="mt-0.5 text-sm leading-5 text-zinc-500">
                        Lengkapi formulir dan kirim pengajuan layanan secara online.
                    </div>
                </div>
            </div>

            <!-- 03 -->
            <div class="flex items-start gap-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-[#FFF8D9] text-sm font-bold text-[#D19F00]">
                    03
                </div>

                <div>
                    <div class="font-semibold text-zinc-950">
                        Pantau Status
                    </div>
                    <div class="mt-0.5 text-sm leading-5 text-zinc-500">
                        Gunakan nomor tiket untuk memantau proses pengajuan Anda.
                    </div>
                </div>
            </div>

        </div>

        <!-- Tombol -->
        <div class="mt-5 border-t border-[#CDEAF5] pt-4">
            <a href="{{ route('login') }}"
               class="block w-full rounded-md bg-[#137CBD] px-4 py-2.5 text-center text-sm font-semibold text-white transition hover:bg-[#0D6EAE]">
                Mulai Ajukan Layanan
            </a>
        </div>

    </div>
</div>
                </div>
            </section>

            <!-- <section class="mx-auto grid max-w-7xl gap-4 px-5 py-8 md:grid-cols-3">
                <div class="rounded-lg border border-[#CDEAF5] bg-white p-5">
                    <div class="mb-4 h-1 w-12 rounded-full bg-[#137CBD]"></div>
                    <h2 class="text-base font-semibold text-zinc-950">Katalog Layanan</h2>
                    <p class="mt-2 text-sm leading-6 text-zinc-600">Daftar layanan disusun berdasarkan kategori dan SLA yang sudah dikonfigurasi admin.</p>
                </div>
                <div class="rounded-lg border border-[#CDEAF5] bg-white p-5">
                    <div class="mb-4 h-1 w-12 rounded-full bg-[#19AEDD]"></div>
                    <h2 class="text-base font-semibold text-zinc-950">UUID Tiket</h2>
                    <p class="mt-2 text-sm leading-6 text-zinc-600">Setiap pengajuan mendapatkan UUID unik untuk pencarian status secara publik.</p>
                </div>
                <div class="rounded-lg border border-[#CDEAF5] bg-white p-5">
                    <div class="mb-4 h-1 w-12 rounded-full bg-[#F5C521]"></div>
                    <h2 class="text-base font-semibold text-zinc-950">Cek Status</h2>
                    <p class="mt-2 text-sm leading-6 text-zinc-600">Pemohon dapat memasukkan UUID di menu cek tiket tanpa perlu membuka dashboard.</p>
                </div>
            </section> -->
        </main>
        <footer class="border-t border-[#D7EDF6] bg-white px-5 py-4 text-center text-xs text-zinc-500">
             © {{ date('Y') }}
         <a href="mailto:adekurniawan0612@gmail.com" class="text-[#137CBD] transition hover:underline">
        Ade Kurniawan
        </a>
    · All rights reserved
</footer>
    </body>
</html>
