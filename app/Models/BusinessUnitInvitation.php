<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessUnitInvitation extends Model
{
    protected $fillable = [
        'user_id',
        'token',
        'expires_at',
        'used_at',
        'invited_by',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function isUsed(): bool
    {
        return ! is_null($this->used_at);
    }

    public function inviter()
{
    return $this->belongsTo(User::class, 'invited_by');
}
}
