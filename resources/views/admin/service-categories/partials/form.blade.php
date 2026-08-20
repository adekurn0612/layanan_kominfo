<div class="space-y-4">
    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label class="text-sm font-medium" for="name">Nama</label>
            <input id="name" name="name" value="{{ old('name', $category->name) }}" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">
            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="text-sm font-medium" for="code">Kode</label>
            <input id="code" name="code" value="{{ old('code', $category->code) }}" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">
            @error('code') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label class="text-sm font-medium" for="description">Deskripsi</label>
        <textarea id="description" name="description" rows="3" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">{{ old('description', $category->description) }}</textarea>
        @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="text-sm font-medium" for="image">Gambar Kategori</label>
        <div class="mt-2 grid gap-4 sm:grid-cols-[160px_1fr] sm:items-start">
            <img src="{{ $category->image_url }}" alt="Gambar {{ $category->name ?: 'kategori layanan' }}" class="h-28 w-full rounded-md border border-[#CDEAF5] object-cover">
            <div>
                <input id="image" name="image" type="file" accept="image/png,image/jpeg,image/webp" class="w-full rounded-md border border-[#B8E2F0] px-3 py-2 text-sm">
                <p class="mt-1 text-xs text-zinc-500">Format JPG, PNG, atau WebP. Maksimal 2 MB.</p>
                @if ($category->image_path)
                    <label class="mt-3 flex items-center gap-2 text-sm text-zinc-600">
                        <input type="checkbox" name="remove_image" value="1" class="rounded border-[#B8E2F0]">
                        Hapus gambar saat ini
                    </label>
                @endif
                @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label class="text-sm font-medium" for="sort_order">Urutan</label>
            <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $category->sort_order ?? 0) }}" class="mt-1 w-full rounded-md border border-[#B8E2F0] px-3 py-2">
            @error('sort_order') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <label class="flex items-end gap-2 pb-2 text-sm">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $category->is_active)) class="rounded border-[#B8E2F0]">
            Aktif
        </label>
    </div>

    <div class="flex gap-3 pt-2">
        <button class="rounded-md bg-[#137CBD] px-4 py-2 text-sm font-semibold text-white hover:bg-[#0D6EAE]">Simpan</button>
        <a href="{{ route('admin.service-categories.index') }}" class="rounded-md border border-[#B8E2F0] px-4 py-2 text-sm font-semibold hover:bg-[#F7FBFD]">Batal</a>
    </div>
</div>
