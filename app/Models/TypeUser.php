<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeUser extends Model
{
    protected $table = 'type_user';

    protected $fillable = [
        'id_user',
        'id_type',
        'created_at',
        'updated_at',

    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
