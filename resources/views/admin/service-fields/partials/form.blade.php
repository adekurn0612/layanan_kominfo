<div class="space-y-4">
    <div class="rounded-md bg-[#F7FBFD] p-3 text-sm text-zinc-600">Layanan: <span class="font-semibold text-zinc-900">{{ $service->name }}</span></div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label class="text-sm font-medium" for="label">Label</label>
            <input id="label" name="label" value="{{ old('label', $field->label) }}" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">
            @error('label') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="text-sm font-medium" for="name">Name</label>
            <input id="name" name="name" value="{{ old('name', $field->name) }}" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">
            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-3">
        <div>
            <label class="text-sm font-medium" for="type">Tipe</label>
            <select id="type" name="type" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">
                @foreach ($types as $type)
                    <option value="{{ $type }}" @selected(old('type', $field->type) === $type)>{{ $type }}</option>
                @endforeach
            </select>
            @error('type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="text-sm font-medium" for="sort_order">Urutan</label>
            <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $field->sort_order ?? 0) }}" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">
            @error('sort_order') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="text-sm font-medium" for="placeholder">Placeholder</label>
            <input id="placeholder" name="placeholder" value="{{ old('placeholder', $field->placeholder) }}" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">
            @error('placeholder') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label class="text-sm font-medium" for="description">Deskripsi</label>
        <textarea id="description" name="description" rows="2" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">{{ old('description', $field->description) }}</textarea>
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label class="text-sm font-medium" for="options">Options</label>
            <textarea id="options" name="options" rows="4" placeholder="Satu opsi per baris" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">{{ old('options', implode("\n", $field->options ?? [])) }}</textarea>
        </div>
        <div>
            <label class="text-sm font-medium" for="validation_rules">Validation Rules</label>
            <textarea id="validation_rules" name="validation_rules" rows="4" placeholder="Contoh: max:255" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">{{ old('validation_rules', implode("\n", $field->validation_rules ?? [])) }}</textarea>
        </div>
    </div>

    <div class="flex flex-wrap gap-4">
        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_required" value="1" @checked(old('is_required', $field->is_required)) class="rounded border-[#B8E2F0]">
            Wajib
        </label>
        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $field->is_active)) class="rounded border-[#B8E2F0]">
            Aktif
        </label>
    </div>

    <div class="flex gap-3 pt-2">
        <button class="rounded-md bg-[#137CBD] px-4 py-2 text-sm font-semibold text-white hover:bg-[#0D6EAE]">Simpan</button>
        <a href="{{ route('admin.services.show', $service) }}" class="rounded-md border border-[#B8E2F0] px-4 py-2 text-sm font-semibold hover:bg-[#F7FBFD]">Batal</a>
    </div>
</div>
