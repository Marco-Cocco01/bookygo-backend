<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Categories extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name',
        'description',
        'id_parent',
        'is_active'
    ];

    // Relazione verso i figli (hasMany)
    public function children(): HasMany
    {
        return $this->hasMany(Categories::class, 'id_parent');
    }

    // Relazione verso il padre (belongsTo)
    public function parentCategory(): BelongsTo
    {
        return $this->belongsTo(Categories::class, 'id_parent');
    }

    // Scope per filtrare solo le categorie padre
    public function scopeRoots(Builder $query): void
    {
        $query->whereNull('id_parent');
    }
}
