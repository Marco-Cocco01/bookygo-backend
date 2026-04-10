<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;
use App\Models\Modules;

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

    public function modules(): BelongsToMany
    {
        return $this->belongsToMany(
            modules::class, // Model correlato
            'rules', // tabella pivot
            'id_type_user', // FK della tabella pivot che punta a Types
            'id_module' // FK della tabella pivot che punta a Modules
        );
    }
}
