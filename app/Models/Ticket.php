<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'service_id',
        'user_id',
        'organization_id',
        'status',
        'form_data',
        'submitted_at',
        'target_deadline_at',
        'first_response_at',
        'resolved_at',
        'closed_at',
        'sla_status',
        'sla_breached',
        'priority',
        'response_hours',
        'resolution_hours',
    ];

    protected function casts(): array
    {
        return [
            'form_data' => 'array',
            'submitted_at' => 'datetime',
            'target_deadline_at' => 'datetime',
            'first_response_at' => 'datetime',
            'resolved_at' => 'datetime',
            'closed_at' => 'datetime',
            'sla_breached' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Ticket $ticket): void {
            $ticket->uuid ??= (string) Str::uuid();
            $ticket->submitted_at ??= now();
        });

        static::created(function (Ticket $ticket): void {
            $ticket->calculateSla();
            $ticket->saveQuietly();
        });
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function followUps(): HasMany
    {
        return $this->hasMany(TicketFollowUp::class);
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(TicketStatusHistory::class);
    }

    public function calculateSla(): void
    {
        if ($this->submitted_at && $this->service) {
            $this->target_deadline_at ??= $this->submitted_at->copy()->addHours($this->service->sla_hours);
        }

        if ($this->submitted_at && $this->first_response_at) {
            $this->response_hours = (float) $this->submitted_at->diffInHours($this->first_response_at, false);
        }

        if ($this->submitted_at && $this->resolved_at) {
            $this->resolution_hours = (float) $this->submitted_at->diffInHours($this->resolved_at, false);
        }

        if ($this->target_deadline_at && $this->resolved_at) {
            $this->sla_breached = $this->resolved_at->greaterThan($this->target_deadline_at);
            $this->sla_status = $this->sla_breached ? 'breached' : 'on_time';
        } elseif ($this->target_deadline_at) {
            $this->sla_breached = now()->greaterThan($this->target_deadline_at);
            $this->sla_status = $this->sla_breached
                ? 'breached'
                : ($this->first_response_at ? 'in_progress' : 'pending');
        }
    }
}
