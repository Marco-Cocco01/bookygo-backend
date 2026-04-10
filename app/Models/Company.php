<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = "company";
    protected $fillable = [
        'id_user',
        'id_type',
        'owner',
        'name',
        'piva',
        'email',
        'cf',
        'address',
        'city',
        'phone',
        'cell',
        'iban',
        'is_active'
    ];
}
