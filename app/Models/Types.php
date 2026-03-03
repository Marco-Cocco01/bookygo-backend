<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Types extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'type_user',
            'id_type',
            'id_user'
        );
    }
}
