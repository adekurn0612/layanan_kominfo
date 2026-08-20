<div class="space-y-4">
    <div class="rounded-md bg-[#F7FBFD] p-3 text-sm text-zinc-600">Layanan: <span class="font-semibold text-zinc-900">{{ $service->name }}</span></div>

    <div>
        <label class="text-sm font-medium" for="name">Nama Persyaratan</label>
        <input id="name" name="name" value="{{ old('name', $requirement->name) }}" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">
        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="text-sm font-medium" for="description">Deskripsi</label>
        <textarea id="description" name="description" rows="3" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">{{ old('description', $requirement->description) }}</textarea>
    </div>

    <div class="grid gap-4 sm:grid-cols-3">
        <div>
            <label class="text-sm font-medium" for="allowed_file_types">Tipe File</label>
            <input id="allowed_file_types" name="allowed_file_types" value="{{ old('allowed_file_types', implode(', ', $requirement->allowed_file_types ?? [])) }}" placeholder="pdf, docx, jpg" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">
        </div>
        <div>
            <label class="text-sm font-medium" for="max_file_size">Ukuran Maks KB</label>
            <input id="max_file_size" name="max_file_size" type="number" min="1" value="{{ old('max_file_size', $requirement->max_file_size) }}" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">
        </div>
        <div>
            <label class="text-sm font-medium" for="sort_order">Urutan</label>
            <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $requirement->sort_order ?? 0) }}" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">
            @error('sort_order') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <label class="flex items-center gap-2 text-sm">
        <input type="checkbox" name="is_required" value="1" @checked(old('is_required', $requirement->is_required)) class="rounded border-[#B8E2F0]">
        Wajib
    </label>

    <div class="flex gap-3 pt-2">
        <button class="rounded-md bg-[#137CBD] px-4 py-2 text-sm font-semibold text-white hover:bg-[#0D6EAE]">Simpan</button>
        <a href="{{ route('admin.services.show', $service) }}" class="rounded-md border border-[#B8E2F0] px-4 py-2 text-sm font-semibold hover:bg-[#F7FBFD]">Batal</a>
    </div>
</div>
