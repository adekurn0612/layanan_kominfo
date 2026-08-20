<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\View\View;

class ServiceCatalogController extends Controller
{
    public function index(): View
    {
        return view('services.index', [
            'categories' => ServiceCategory::where('is_active', true)
                ->withCount(['services' => fn ($query) => $query->where('is_active', true)])
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function category(ServiceCategory $category): View
    {
        abort_unless($category->is_active, 404);

        return view('services.category', [
            'category' => $category->load(['services' => fn ($query) => $query
                ->where('is_active', true)
                ->withCount('requirements')]),
        ]);
    }

    public function show(Service $service): View
    {
        abort_unless($service->is_active, 404);

        return view('services.show', [
            'service' => $service->load(['category', 'activeFields', 'requirements']),
        ]);
    }
}
