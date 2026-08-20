<div class="space-y-4">
    <div>
        <label class="text-sm font-medium" for="parent_id">Induk Organisasi</label>
        <select id="parent_id" name="parent_id" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">
            <option value="">Tidak ada</option>
            @foreach ($parents as $parent)
                <option value="{{ $parent->id }}" @selected(old('parent_id', $organization->parent_id) == $parent->id)>{{ $parent->name }}</option>
            @endforeach
        </select>
        @error('parent_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label class="text-sm font-medium" for="code">Kode</label>
            <input id="code" name="code" value="{{ old('code', $organization->code) }}" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">
            @error('code') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-sm font-medium" for="type">Tipe</label>
            <input id="type" name="type" value="{{ old('type', $organization->type) }}" placeholder="opd, kecamatan, desa" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">
            @error('type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label class="text-sm font-medium" for="name">Nama</label>
        <input id="name" name="name" value="{{ old('name', $organization->name) }}" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">
        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <label class="flex items-center gap-2 text-sm">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $organization->is_active)) class="rounded border-[#B8E2F0]">
        Aktif
    </label>

    <div class="flex gap-3 pt-2">
        <button class="rounded-md bg-[#137CBD] px-4 py-2 text-sm font-semibold text-white hover:bg-[#0D6EAE]">Simpan</button>
        <a href="{{ route('admin.organizations.index') }}" class="rounded-md border border-[#B8E2F0] px-4 py-2 text-sm font-semibold hover:bg-[#F7FBFD]">Batal</a>
    </div>
</div>
