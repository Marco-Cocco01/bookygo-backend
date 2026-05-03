<?php

namespace App\Services;

use App\Models\UsersRights;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class MenuServices
{
    public function getMenuForUser(): Collection
    {
        return UsersRights::with('module')
            ->where('id_user', Auth::id())
            ->where('can_view', 1)
            ->get()
            ->pluck('module')
            ->filter()         // rimuove eventuali moduli null
            ->sortBy('order')
            ->values();
    }
}