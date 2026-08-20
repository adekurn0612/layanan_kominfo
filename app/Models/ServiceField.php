<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceField extends Model
{
    use HasFactory;

    public const TYPES = [
        'text',
        'textarea',
        'number',
        'email',
        'phone',
        'date',
        'datetime',
        'select',
        'radio',
        'checkbox',
        'file',
    ];

    protected $fillable = [
        'service_id',
        'name',
        'label',
        'type',
        'placeholder',
        'description',
        'is_required',
        'validation_rules',
        'options',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_required' => 'boolean',
            'validation_rules' => 'array',
            'options' => 'array',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function normalizedOptions(): array
    {
        return collect($this->options ?? [])
            ->map(fn ($option) => is_array($option) ? ($option['label'] ?? $option['value'] ?? '') : $option)
            ->filter()
            ->values()
            ->all();
    }
}
