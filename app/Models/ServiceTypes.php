<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Categories;
use App\Models\Services;

class ServiceTypes extends Model
{
    protected $fillable = [
        "title",
        "id_category",
        "is_active"
    ];


    public function children() : HasMany 
    {
        return $this->hasMany(Services::class, "id_service_type");
    }


    public function category() : BelongsTo 
    {
        return $this->belongsTo(Categories::class, 'id_category');
    }


}
