<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;
use App\Models\Types;
use App\Models\UsersRights;
use Illuminate\Auth\Access\Response;

class ClientPolicy
{

    /**
     * Viene eseguito PRIMA di tutti gli altri metodi.
     * Se ritorna true, bypassa tutto (utile per l'Admin).
     */
    public function before(User $user, string $ability): bool|null
    {
        // L'admin ha sempre accesso a tutto
        if ($user->hasType('admin')) {
            return true;
        }
        return null; // null = continua con il metodo specifico
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->hasRight($user, 'can_view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Client $client): bool
    {
        return $this->hasRight($user, 'can_view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
       return $this->hasRight($user, 'can_add');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Client $client): bool
    {
        return $this->hasRight($user, 'can_edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Client $client): bool
    {
        return $this->hasRight($user, 'can_delete');
    }

    // restore e forceDelete — solo admin (before() ci pensa)
    public function restore(User $user, Client $client): bool
    {
        return false;
    }

    public function forceDelete(User $user, Client $client): bool
    {
        return false;
    }


    // -------------------------------------------------------
    // Metodo privato centrale
    // Legge users_rights per il modulo 'clients'
    // Funziona sia per permessi diretti che per deleghe (id_parent)
    // -------------------------------------------------------
    private function hasRight(User $user, string $action): bool
    {
        return $user->rights()
            ->whereHas('module', fn($q) =>
                $q->where('name', 'clients')  // ← nome del modulo in tabella modules
                  ->where('is_active', true)   // ← solo moduli attivi
            )
            ->where($action, true)
            ->exists();
    }
}
