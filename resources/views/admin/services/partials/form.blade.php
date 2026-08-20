<div class="space-y-4">
    <div>
        <label class="text-sm font-medium" for="category_id">Kategori</label>
        <select id="category_id" name="category_id" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $service->category_id) == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
        @error('category_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label class="text-sm font-medium" for="name">Nama</label>
            <input id="name" name="name" value="{{ old('name', $service->name) }}" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">
            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="text-sm font-medium" for="code">Kode</label>
            <input id="code" name="code" value="{{ old('code', $service->code) }}" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">
            @error('code') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label class="text-sm font-medium" for="description">Deskripsi</label>
        <textarea id="description" name="description" rows="4" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">{{ old('description', $service->description) }}</textarea>
        @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="grid gap-4 sm:grid-cols-3">
        <div>
            <label class="text-sm font-medium" for="sla_hours">SLA Jam</label>
            <input id="sla_hours" name="sla_hours" type="number" min="1" value="{{ old('sla_hours', $service->sla_hours ?? 24) }}" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">
            @error('sla_hours') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="text-sm font-medium" for="sort_order">Urutan</label>
            <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $service->sort_order ?? 0) }}" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">
            @error('sort_order') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <label class="flex items-end gap-2 pb-2 text-sm">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $service->is_active)) class="rounded border-[#B8E2F0]">
            Aktif
        </label>
    </div>

    <div class="flex gap-3 pt-2">
        <button class="rounded-md bg-[#137CBD] px-4 py-2 text-sm font-semibold text-white hover:bg-[#0D6EAE]">Simpan</button>
        <a href="{{ route('admin.services.index') }}" class="rounded-md border border-[#B8E2F0] px-4 py-2 text-sm font-semibold hover:bg-[#F7FBFD]">Batal</a>
    </div>
</div>
