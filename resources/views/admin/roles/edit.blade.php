@extends('layouts.app', ['title' => 'Edit Role'])

@section('content')
    <form method="POST" action="{{ route('admin.roles.update', $role) }}" class="max-w-3xl rounded-lg border border-[#CDEAF5] bg-white p-5">
        @csrf
        @method('PUT')

        <div class="mb-5">
            <h2 class="text-lg font-semibold">{{ $role->name }}</h2>
            <p class="text-sm text-zinc-500">{{ $role->description }}</p>
        </div>

        <label class="mb-5 flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $role->is_active)) class="rounded border-[#B8E2F0]">
            Aktif
        </label>

        <div class="space-y-5">
            @foreach ($permissions as $module => $items)
                <section>
                    <h3 class="mb-2 text-sm font-semibold">{{ $module }}</h3>
                    <div class="grid gap-2 sm:grid-cols-2">
                        @foreach ($items as $permission)
                            <label class="flex items-center gap-2 rounded-md border border-[#CDEAF5] px-3 py-2 text-sm">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" @checked(in_array($permission->id, old('permissions', $selectedPermissions), true)) class="rounded border-[#B8E2F0]">
                                {{ $permission->name }}
                            </label>
                        @endforeach
                    </div>
                </section>
            @endforeach
        </div>

        <div class="mt-6 flex gap-3">
            <button class="rounded-md bg-[#137CBD] px-4 py-2 text-sm font-semibold text-white hover:bg-[#0D6EAE]">Simpan</button>
            <a href="{{ route('admin.roles.index') }}" class="rounded-md border border-[#B8E2F0] px-4 py-2 text-sm font-semibold hover:bg-[#F7FBFD]">Batal</a>
        </div>
    </form>
@endsection
