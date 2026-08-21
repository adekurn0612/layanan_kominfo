<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#F7FBFD] text-zinc-900 antialiased">
        <div class="min-h-screen @auth lg:flex @endauth">
            @auth
                <aside class="border-b border-[#CDEAF5] bg-white/95 backdrop-blur lg:min-h-screen lg:w-72 lg:border-b-0 lg:border-r">
                    <div class="flex h-1.5">
                        <div class="w-1/3 bg-[#137CBD]"></div>
                        <div class="w-1/3 bg-[#19AEDD]"></div>
                        <div class="w-1/3 bg-[#F5C521]"></div>
                    </div>
                    <div class="flex h-16 items-center justify-between px-5">
                        <a href="{{ route('dashboard') }}" class="min-w-0">
                            <x-app-logo size="sm" />
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-ui.button type="submit" variant="secondary" size="sm">Keluar</x-ui.button>
                        </form>
                    </div>
                    <nav class="space-y-1 px-3 pb-5 text-sm">
                        <a href="{{ route('dashboard') }}" class="block rounded-md px-3 py-2 font-medium text-[#137CBD] transition hover:bg-[#EAF8FC] hover:text-[#0B3558]">Dashboard</a>
                        <a href="{{ route('services.index') }}" class="block rounded-md px-3 py-2 text-[#5B7180] transition hover:bg-[#EAF8FC] hover:text-[#137CBD]">Daftar Layanan</a>
                        <a href="{{ route('tickets.lookup') }}" class="block rounded-md px-3 py-2 text-[#5B7180] transition hover:bg-[#EAF8FC] hover:text-[#137CBD]">Cek Tiket</a>
                        @can('view-admin')
                            <div class="px-3 pt-4 text-[11px] font-semibold uppercase tracking-[0.2em] text-[#137CBD]">Admin Panel</div>
                            <a href="{{ route('admin.users.index') }}" class="block rounded-md px-3 py-2 text-[#5B7180] transition hover:bg-[#EAF8FC] hover:text-[#137CBD]">User</a>
                            <a href="{{ route('admin.roles.index') }}" class="block rounded-md px-3 py-2 text-[#5B7180] transition hover:bg-[#EAF8FC] hover:text-[#137CBD]">Role</a>
                            <a href="{{ route('admin.permissions.index') }}" class="block rounded-md px-3 py-2 text-[#5B7180] transition hover:bg-[#EAF8FC] hover:text-[#137CBD]">Permission</a>
                            <a href="{{ route('admin.organizations.index') }}" class="block rounded-md px-3 py-2 text-[#5B7180] transition hover:bg-[#EAF8FC] hover:text-[#137CBD]">Organisasi</a>
                            <a href="{{ route('admin.service-categories.index') }}" class="block rounded-md px-3 py-2 text-[#5B7180] transition hover:bg-[#EAF8FC] hover:text-[#137CBD]">Kategori Layanan</a>
                            <a href="{{ route('admin.services.index') }}" class="block rounded-md px-3 py-2 text-[#5B7180] transition hover:bg-[#EAF8FC] hover:text-[#137CBD]">Layanan</a>
                            <a href="{{ route('admin.tickets.index') }}" class="block rounded-md px-3 py-2 text-[#5B7180] transition hover:bg-[#EAF8FC] hover:text-[#137CBD]">Tindak Lanjut Tiket</a>
                        @endcan
                    </nav>
                </aside>
            @endauth
            @guest
                @unless ($hidePublicHeader ?? false)
                    <header class="border-b border-[#D7EDF6] bg-white">
                        <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-5 py-4">
                            <a href="{{ route('welcome') }}" class="min-w-0">
                                <x-app-logo size="sm" />
                            </a>
                            <nav class="flex flex-wrap items-center justify-end gap-2 text-sm font-medium text-zinc-700">
                                <a href="{{ route('services.index') }}" class="rounded-md px-3 py-2 transition hover:bg-[#EAF8FC] hover:text-[#137CBD]">Katalog Layanan</a>
                                <a href="{{ route('news.index') }}" class="rounded-md px-3 py-2 transition hover:bg-[#EAF8FC] hover:text-[#137CBD]">Berita</a>
                                <a href="{{ route('tickets.lookup') }}" class="rounded-md px-3 py-2 transition hover:bg-[#EAF8FC] hover:text-[#137CBD]">Cek Tiket</a>
                                <a href="{{ route('login') }}" class="rounded-md bg-[#137CBD] px-3 py-2 text-white transition hover:bg-[#0D6EAE]">Masuk</a>
                            </nav>
                        </div>
                    </header>
                @endunless
            @endguest

            <main class="flex-1">
                @auth
                    <header class="border-b border-[#CDEAF5] bg-white/90 px-5 py-4 backdrop-blur">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <div>
                                <h1 class="text-xl font-semibold tracking-tight text-[#0B3558]">{{ $title ?? 'Dashboard' }}</h1>
                                <p class="text-sm text-[#5B7180]">{{ auth()->user()->name }} - {{ auth()->user()->organization?->name ?? 'Tanpa organisasi' }}</p>
                            </div>
                            @hasSection('action')
                                @yield('action')
                            @endif
                        </div>
                    </header>
                @endauth

                <div class="@auth p-5 @else {{ ($publicFullBleed ?? false) ? '' : 'mx-auto max-w-7xl px-5 py-6' }} @endauth">
                    @if (session('status'))
                        <x-layout.flash message="{{ session('status') }}" />
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
        @stack('scripts')
    </body>
</html>
