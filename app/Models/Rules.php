<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rules extends Model
{
    protected $fillable = [
        'id_type_user',
        'id_module',
    ];
}
