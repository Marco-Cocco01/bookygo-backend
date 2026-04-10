<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTypes extends Model
{
    
    protected $fillable = [
        'title',
        'description',
        'active',
        'created_at',
        'updated_at',

    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
