<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Berita - {{ config('app.name') }}</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="min-h-screen bg-[#F7FBFD] text-zinc-950 antialiased">
        <header class="border-b border-[#D7EDF6] bg-white">
            <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-5 py-4">
                <a href="{{ route('welcome') }}" class="min-w-0">
                    <x-app-logo size="sm" />
                </a>
                <nav class="flex items-center gap-2 text-sm font-medium text-zinc-700">
                    <a href="{{ route('welcome') }}" class="rounded-md px-3 py-2 transition hover:bg-[#EAF8FC] hover:text-[#137CBD]">Beranda</a>
                    <a href="{{ route('tickets.lookup') }}" class="rounded-md px-3 py-2 transition hover:bg-[#EAF8FC] hover:text-[#137CBD]">Cek Tiket</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="rounded-md bg-[#137CBD] px-3 py-2 text-white transition hover:bg-[#0D6EAE]">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="rounded-md bg-[#137CBD] px-3 py-2 text-white transition hover:bg-[#0D6EAE]">Masuk</a>
                    @endauth
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-5 py-12">
            <section class="grid gap-8 rounded-lg border border-[#CDEAF5] bg-white p-6 md:grid-cols-[1fr_320px] md:items-center md:p-8">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#137CBD]">Berita Layanan TI</p>
                    <h1 class="mt-3 text-3xl font-semibold tracking-tight text-zinc-950 sm:text-4xl">Coming Soon</h1>
                    <p class="mt-4 max-w-2xl text-base leading-7 text-zinc-600">
                        Halaman berita sedang disiapkan untuk menampilkan pengumuman, informasi layanan, dan update kegiatan Diskominfo Bengkulu Selatan.
                    </p>
                    <div class="mt-7 flex flex-wrap gap-3">
                        <a href="{{ route('welcome') }}" class="inline-flex items-center justify-center rounded-md bg-[#137CBD] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#0D6EAE]">Kembali ke Beranda</a>
                        <a href="{{ route('tickets.lookup') }}" class="inline-flex items-center justify-center rounded-md border border-[#19AEDD] bg-white px-5 py-3 text-sm font-semibold text-[#137CBD] transition hover:bg-[#EAF8FC]">Cek Tiket</a>
                    </div>
                </div>

                <div class="rounded-lg bg-[#0B3558] p-5 text-white">
                    <div class="mb-4 flex h-1.5 overflow-hidden rounded-full">
                        <div class="w-1/3 bg-[#9D1D27]"></div>
                        <div class="w-1/3 bg-[#19AEDD]"></div>
                        <div class="w-1/3 bg-[#F5C521]"></div>
                    </div>
                    <div class="flex items-center justify-center rounded-lg bg-white p-5">
                        <img src="{{ asset('images/logo-bengkulu-selatan.png') }}" alt="Logo Kabupaten Bengkulu Selatan" class="h-40 w-40 object-contain">
                    </div>
                    <div class="mt-5 text-sm font-semibold uppercase tracking-[0.16em] text-[#A8E8F7]">Kabupaten Bengkulu Selatan</div>
                    <p class="mt-2 text-sm leading-6 text-zinc-300">Konten berita akan segera hadir.</p>
                </div>
            </section>
        </main>
    </body>
</html>
