<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Categories;

class ProductRules extends Model
{
    protected $fillable = [
        'title',
        'id_category',
        'is_active'
    ];


    public function category() : BelongsTo 
    {
        return $this->belongsTo(Categories::class, 'id_category');
    }

}
