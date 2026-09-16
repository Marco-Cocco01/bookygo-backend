<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use App\Models\User;
use App\Models\Modules; // adatta al nome reale del tuo model dei moduli
use App\Models\UsersRights;

class AssignDefaultRightsToUser
{
    public function handle(Registered $event): void
    {
        $user = $event->user;
        $typeIds = $user->types()->pluck('types.id');

        \Log::info('Assigning rights to user ID: ' . $user->id . ' with type IDs: ' . implode(', ', $typeIds->toArray()));

        $callId = uniqid();
        \Log::info("[{$callId}] Listener START - User ID: {$event->user->id}");

        foreach ($typeIds as $typeId) {
            // Cerca un altro utente ESISTENTE dello stesso tipo (escludendo quello appena creato)
            $templateUser = User::whereHas('types', function ($q) use ($typeId) {
                    $q->where('types.id', $typeId);
                })
                ->where('id', '!=', $user->id)
                ->whereHas('rights') // deve avere già dei permessi assegnati
                ->first();

            if ($templateUser) {
                // CASO A: esiste già un utente dello stesso tipo -> copia i suoi permessi
                $rightsToClone = $templateUser->rights;

                foreach ($rightsToClone as $right) {
                    UsersRights::create([
                        'id_user'    => $user->id,
                        'id_parent'  => $templateUser->id, // tiene traccia di "da chi ha ereditato"
                        'id_module'  => $right->id_module,
                        'can_view'   => $right->can_view,
                        'can_add'    => $right->can_add,
                        'can_edit'   => $right->can_edit,
                        'can_delete' => $right->can_delete,
                    ]);
                }

                \Log::info("Permessi copiati dall'utente template ID: {$templateUser->id}");

            } else {
                // CASO B: nessun altro utente con questo tipo -> tutto disabilitato, per ogni modulo
                $modules = Modules::where('is_active', true)->get();

                foreach ($modules as $module) {
                    UsersRights::create([
                        'id_user'    => $user->id,
                        'id_parent'  => null,
                        'id_module'  => $module->id,
                        'can_view'   => false,
                        'can_add'    => false,
                        'can_edit'   => false,
                        'can_delete' => false,
                    ]);
                }

                \Log::info("Nessun utente template trovato, permessi impostati a false per tutti i moduli.");
                
            }

             \Log::info("[{$callId}] Listener END");
        }
    }
}