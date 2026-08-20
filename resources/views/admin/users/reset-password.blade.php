@extends('layouts.app', ['title' => 'Reset Password User'])

@section('content')
    <form method="POST" action="{{ route('admin.users.password.update', $user) }}" class="max-w-2xl rounded-lg border border-[#CDEAF5] bg-white p-5">
        @csrf
        @method('PUT')

        <div class="mb-5">
            <h1 class="text-lg font-semibold text-[#0B3558]">Reset Password</h1>
            <p class="mt-1 text-sm text-[#5B7180]">Atur password baru untuk {{ $user->name }}.</p>
        </div>

        <div class="space-y-4">
            <div>
                <label class="text-sm font-medium" for="password">Password Baru</label>
                <input id="password" name="password" type="password" required autofocus autocomplete="new-password" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">
                @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-sm font-medium" for="password_confirmation">Konfirmasi Password Baru</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">
            </div>

            <div class="flex gap-3 pt-2">
                <button class="rounded-md bg-[#137CBD] px-4 py-2 text-sm font-semibold text-white hover:bg-[#0D6EAE]">Simpan Password Baru</button>
                <a href="{{ route('admin.users.edit', $user) }}" class="rounded-md border border-[#B8E2F0] px-4 py-2 text-sm font-semibold hover:bg-[#F7FBFD]">Batal</a>
            </div>
        </div>
    </form>
@endsection
