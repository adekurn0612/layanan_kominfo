<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ServiceCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
            'code',
            'description',
            'image_path',
            'is_active',
            'sort_order',
        ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class, 'category_id')->orderBy('sort_order')->orderBy('name');
    }

    public function getRouteKeyName(): string
    {
        return 'code';
    }

    public function getImageUrlAttribute(): string
    {
        if (! $this->image_path) {
            return asset('images/service-categories/default.svg');
        }

        if (File::exists(public_path($this->image_path))) {
            return asset($this->image_path);
        }

        return Storage::disk('public')->url($this->image_path);
    }
}
