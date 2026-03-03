<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRight extends Model
{
    protected $fillable = [
        'id_user',
        'id_module',
        'id_parent',
        'can_view',
        'can_add',
        'can_edit',
        'can_delete',
    ];

    protected $casts = [
        'can_view'   => 'boolean',
        'can_add'    => 'boolean',
        'can_edit'   => 'boolean',
        'can_delete' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class, 'id_module');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_parent');
    }
}
