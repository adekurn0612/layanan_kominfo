<div class="space-y-4">
    <div>
        <label class="text-sm font-medium" for="organization_id">Organisasi</label>
        <select id="organization_id" name="organization_id" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">
            <option value="">Tidak ada</option>
            @foreach ($organizations as $organization)
                <option value="{{ $organization->id }}" @selected(old('organization_id', $user->organization_id) == $organization->id)>{{ $organization->name }}</option>
            @endforeach
        </select>
        @error('organization_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label class="text-sm font-medium" for="name">Nama</label>
            <input id="name" name="name" value="{{ old('name', $user->name) }}" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">
            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-sm font-medium" for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">
            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label class="text-sm font-medium" for="phone">Nomor HP</label>
        <input id="phone" name="phone" type="tel" value="{{ old('phone', $user->phone) }}" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">
        @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    @if (! $user->exists)
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="text-sm font-medium" for="password">Password</label>
                <input id="password" name="password" type="password" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">
                @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-sm font-medium" for="password_confirmation">Konfirmasi Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">
            </div>
        </div>
    @endif

    <div>
        <div class="text-sm font-medium">Role</div>
        <div class="mt-2 grid gap-2 sm:grid-cols-2">
            @foreach ($roles as $role)
                <label class="flex items-center gap-2 rounded-md border border-[#CDEAF5] px-3 py-2 text-sm">
                    <input type="checkbox" name="roles[]" value="{{ $role->id }}" @checked(in_array($role->id, old('roles', $selectedRoles), true)) class="rounded border-[#B8E2F0]">
                    {{ $role->name }}
                </label>
            @endforeach
        </div>
        @error('roles') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <label class="flex items-center gap-2 text-sm">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $user->is_active)) class="rounded border-[#B8E2F0]">
        Aktif
    </label>

    <div class="flex gap-3 pt-2">
        <button class="rounded-md bg-[#137CBD] px-4 py-2 text-sm font-semibold text-white hover:bg-[#0D6EAE]">Simpan</button>
        <a href="{{ route('admin.users.index') }}" class="rounded-md border border-[#B8E2F0] px-4 py-2 text-sm font-semibold hover:bg-[#F7FBFD]">Batal</a>
    </div>
</div>
