@extends('layouts.app', ['hidePublicHeader' => true, 'publicFullBleed' => true])

@section('content')
    <div class="flex min-h-screen items-center justify-center px-4 py-12">
        <div class="w-full max-w-lg overflow-hidden rounded-lg border border-[#CDEAF5] bg-white shadow-sm shadow-[#137CBD]/10">
            <div class="flex h-1.5">
                <div class="w-1/3 bg-[#137CBD]"></div>
                <div class="w-1/3 bg-[#19AEDD]"></div>
                <div class="w-1/3 bg-[#F5C521]"></div>
            </div>
            <div class="p-6">
                <div class="mb-6">
                    <div class="mb-4 flex justify-center">
                        <x-app-logo size="lg" :show-text="false" />
                    </div>
                    <h1 class="text-center text-2xl font-semibold text-[#0B3558]">Daftar Akun</h1>
                    <p class="mt-2 text-center text-sm text-[#5B7180]">Buat akun untuk mengakses Portal Layanan Kabupaten Bengkulu Selatan.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="text-sm font-medium text-[#0B3558]">Nama Lengkap</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2 focus:border-[#137CBD] focus:outline-none focus:ring-2 focus:ring-[#BFEAF5]">
                        @error('name') <p class="mt-1 text-sm text-[#9D1D27]">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="phone" class="text-sm font-medium text-[#0B3558]">Nomor HP</label>
                        <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" required autocomplete="tel" placeholder="Contoh: 081234567890" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2 focus:border-[#137CBD] focus:outline-none focus:ring-2 focus:ring-[#BFEAF5]">
                        @error('phone') <p class="mt-1 text-sm text-[#9D1D27]">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="text-sm font-medium text-[#0B3558]">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2 focus:border-[#137CBD] focus:outline-none focus:ring-2 focus:ring-[#BFEAF5]">
                        @error('email') <p class="mt-1 text-sm text-[#9D1D27]">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="organization_id" class="text-sm font-medium text-[#0B3558]">Instansi</label>
                        <select id="organization_id" name="organization_id" required class="mt-1 w-full rounded-md border border-[#B8E2F0] bg-white px-3 py-2 focus:border-[#137CBD] focus:outline-none focus:ring-2 focus:ring-[#BFEAF5]">
                            <option value="">Pilih instansi</option>
                            @foreach ($organizations as $organization)
                                <option value="{{ $organization->id }}" @selected(old('organization_id') == $organization->id)>{{ $organization->name }}</option>
                            @endforeach
                        </select>
                        @error('organization_id') <p class="mt-1 text-sm text-[#9D1D27]">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="password" class="text-sm font-medium text-[#0B3558]">Password</label>
                            <input id="password" name="password" type="password" required autocomplete="new-password" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2 focus:border-[#137CBD] focus:outline-none focus:ring-2 focus:ring-[#BFEAF5]">
                            @error('password') <p class="mt-1 text-sm text-[#9D1D27]">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="text-sm font-medium text-[#0B3558]">Konfirmasi Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2 focus:border-[#137CBD] focus:outline-none focus:ring-2 focus:ring-[#BFEAF5]">
                        </div>
                    </div>

                    <button class="w-full rounded-md bg-[#137CBD] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#0D6EAE]">Daftar</button>
                </form>

                <a href="{{ route('login') }}" class="mt-4 block text-center text-sm font-semibold text-[#137CBD] hover:underline">Sudah punya akun? Masuk</a>
            </div>
        </div>
    </div>
@endsection
