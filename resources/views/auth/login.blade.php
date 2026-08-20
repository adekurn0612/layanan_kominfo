@extends('layouts.app', ['hidePublicHeader' => true, 'publicFullBleed' => true])

@section('content')
    <div class="flex min-h-screen items-center justify-center px-4 py-12">
        <div class="w-full max-w-md overflow-hidden rounded-lg border border-[#CDEAF5] bg-white shadow-sm shadow-[#137CBD]/10">
            <div class="flex h-1.5">
                <div class="w-1/3 bg-[#137CBD]"></div>
                <div class="w-1/3 bg-[#19AEDD]"></div>
                <div class="w-1/3 bg-[#F5C521]"></div>
            </div>
            <div class="mb-6">
                        <a href="{{ route('welcome') }}"
                           class="inline-flex items-center gap-2 text-sm font-medium text-[#137CBD] transition hover:text-[#0D6EAE]">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-4 w-4"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M15 19l-7-7 7-7" />
                            </svg>

                            Kembali ke Beranda
                        </a>
                    </div>
            <div class="p-6">
            <div class="mb-6">
                <div class="mb-4 flex justify-center">
                    <x-app-logo size="lg" :show-text="false" />
                </div>
                <h1 class="text-center text-2xl font-semibold text-[#0B3558]">Masuk Portal Layanan Kabupaten Bengkulu Selatan</h1>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="text-sm font-medium text-[#0B3558]">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2 focus:border-[#137CBD] focus:outline-none focus:ring-2 focus:ring-[#BFEAF5]">
                    @error('email') <p class="mt-1 text-sm text-[#9D1D27]">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password" class="text-sm font-medium text-[#0B3558]">Password</label>
                    <input id="password" name="password" type="password" required class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2 focus:border-[#137CBD] focus:outline-none focus:ring-2 focus:ring-[#BFEAF5]">
                    @error('password') <p class="mt-1 text-sm text-[#9D1D27]">{{ $message }}</p> @enderror
                </div>

                <label class="flex items-center gap-2 text-sm text-[#5B7180]">
                    <input type="checkbox" name="remember" value="1" class="rounded border-[#B8E2F0]">
                    Ingat sesi masuk
                </label>

                <button class="w-full rounded-md bg-[#137CBD] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#0D6EAE]">Masuk</button>
            </form>
                <a href="{{ route('register') }}"
                    class="mt-4 block text-center text-sm font-semibold text-[#137CBD] hover:underline">
                    Belum punya akun? Daftar
                </a>
            </div>
        </div>
    </div>
@endsection
