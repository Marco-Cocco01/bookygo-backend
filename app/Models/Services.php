<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\ServiceTypes;

class Services extends Model
{
    protected $fillable = [
        "title",
        "id_service_type",
        "is_active"
    ];

    public function parent() : BelongsTo 
    {
        return $this->belongsTo(ServiceTypes::class, 'id_service_type');
    }


}
