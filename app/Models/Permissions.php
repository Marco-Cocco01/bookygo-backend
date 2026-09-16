<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    protected $table = 'permissions';

    protected $fillable = [
        'id_user_type',
        'id_module',
        'can_view',
        'can_add',
        'can_edit',
        'can_delete',
    ];

    public function userType()
    {
        return $this->belongsTo(TypeUser::class, 'id_user_type');
    }

    public function module()
    {
        return $this->belongsTo(Module::class, 'id_module');
    }
}
