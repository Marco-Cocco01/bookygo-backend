<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    protected $table = 'fee';

    protected $fillable = [
        'name',
        'description',
        'is_active',
        'id_client_type',
        'amount',
    ];
}
