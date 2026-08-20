<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceCategoryRequest;
use App\Http\Requests\UpdateServiceCategoryRequest;
use App\Models\ServiceCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ServiceCategoryController extends Controller
{
    private const UPLOAD_DIRECTORY = 'images/service-categories/uploads';

    public function index(): View
    {
        $this->authorize('viewAny', ServiceCategory::class);

        return view('admin.service-categories.index', [
            'categories' => ServiceCategory::withCount('services')->orderBy('sort_order')->orderBy('name')->paginate(15),
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', ServiceCategory::class);

        return view('admin.service-categories.create', [
            'category' => new ServiceCategory(['is_active' => true, 'sort_order' => 0]),
        ]);
    }

    public function store(StoreServiceCategoryRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['image']);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $data['image_path'] = $this->storeImage($request->file('image'));
        }

        ServiceCategory::create($data);

        return redirect()->route('admin.service-categories.index')->with('status', 'Kategori layanan berhasil ditambahkan.');
    }

    public function edit(ServiceCategory $serviceCategory): View
    {
        $this->authorize('update', $serviceCategory);

        return view('admin.service-categories.edit', ['category' => $serviceCategory]);
    }

    public function update(UpdateServiceCategoryRequest $request, ServiceCategory $serviceCategory): RedirectResponse
    {
        $data = $request->safe()->except(['image', 'remove_image']);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->boolean('remove_image')) {
            $this->deleteUploadedImage($serviceCategory->image_path);
            $data['image_path'] = null;
        }

        if ($request->hasFile('image')) {
            $this->deleteUploadedImage($serviceCategory->image_path);
            $data['image_path'] = $this->storeImage($request->file('image'));
        }

        $serviceCategory->update($data);

        return redirect()->route('admin.service-categories.index')->with('status', 'Kategori layanan berhasil diperbarui.');
    }

    private function storeImage(UploadedFile $image): string
    {
        if (! $image->isValid()) {
            throw ValidationException::withMessages([
                'image' => $image->getErrorMessage(),
            ]);
        }

        $filename = Str::uuid().'.'.$image->extension();
        $directory = public_path(self::UPLOAD_DIRECTORY);
        File::ensureDirectoryExists($directory);

        if (! $image->move($directory, $filename)) {
            throw ValidationException::withMessages([
                'image' => 'Gambar tidak dapat disimpan. Pastikan folder public/images/service-categories dapat ditulis.',
            ]);
        }

        return self::UPLOAD_DIRECTORY.'/'.$filename;
    }

    private function deleteUploadedImage(?string $path): void
    {
        if (! $path || ! str_starts_with($path, self::UPLOAD_DIRECTORY.'/')) {
            return;
        }

        File::delete(public_path($path));
    }
}
