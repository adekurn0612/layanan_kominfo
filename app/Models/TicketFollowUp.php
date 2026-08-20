<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketFollowUp extends Model
{
    protected $fillable = [
        'ticket_id',
        'user_id',
        'comment',
        'is_public',
        'file_path',
        'file_name',
        'file_mime',
    ];

    protected function casts(): array
    {
        return ['is_public' => 'boolean'];
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
