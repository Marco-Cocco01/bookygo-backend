<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BusinessUnitInvitation;
use App\Models\Types; 
use App\Models\User;
use App\Models\UsersRights;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Validate;

class AuthController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Credenziali non corrette.',
            ]);
        }

        

        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    /**
     * Validate the invitation token and show the add password form.
     * 
     * @param string $token
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     * 
     * */
    public function addbupsw($token)
    {
        $invitation = BusinessUnitInvitation::where('expires_at', '>', now())
            ->whereNull('used_at')
            ->get()
            ->first(fn ($inv) => Hash::check($token, $inv->token));

        if (! $invitation) {
            return redirect()->route('login')
                ->with('error', 'Il link non è valido o è scaduto.');
        }

        return view('layouts.auth.addbupsw', [
            'token' => $token,
            'invitation' => $invitation,
        ]);
    }

    

    /** Copia i permessi di un utente a un altro basandosi sul ruolo */

    public function assignRolePermissionsToUser(User $user, int $typeUserId, int $parentId): void
    {
        $moduleIds = Types::find($typeUserId)
            ?->modules()
            ->pluck('modules.id');

        if (! $moduleIds || $moduleIds->isEmpty()) {
            \Log::warning("Nessun modulo configurato per il ruolo {$typeUserId}, impossibile assegnare permessi.");
            return;
        }

        foreach ($moduleIds as $moduleId) {
            UsersRights::updateOrCreate(
                [
                    'id_user' => $user->id,
                    'id_module' => $moduleId,
                ],
                [
                    'id_parent' => $parentId,
                    'can_view' => 1,
                    'can_add' => 1,
                    'can_edit' => 1,
                    'can_delete' => 1,
                ]
            );
        }

        \Log::debug("Permessi di default (full access) assegnati a utente {$user->id} (delegati da {$parentId}) per il ruolo {$typeUserId}");
    }


    /** Registrazione Utente */
    public function register()
    {
        return view('auth.register');
    }


    /**Password Business Unit */
    public function storeBupsw(Request $request, $token)
    {
        // Ritrovo l'invito valido, stessa logica dello step GET
        $invitation = BusinessUnitInvitation::where('expires_at', '>', now())
            ->whereNull('used_at')
            ->get()
            ->first(fn ($inv) => Hash::check($token, $inv->token));

        if (! $invitation) {
            return redirect()->route('login')
                ->with('error', 'Il link non è valido o è scaduto.');
        }

        $request->validate([
            'password' => ['required', Password::min(8)->mixedCase()->numbers()->symbols()],
            'password_confirmation' => ['required', 'same:password'],
        ]);

        $user = $invitation->user;

        $user->update([
            'password' => Hash::make($request->password),
            'is_business_unit' => true,
            'activated_at' => now(),
            'email_verified_at' => now(),
        ]);

        $invitation->update(['used_at' => now()]);
        
        $businessUnitTypeId = Types::where('name', 'Business Unit')->value('id');
        //Assegno i ruoli
        $this->assignRolePermissionsToUser($user, $businessUnitTypeId, $invitation->invited_by);

        return redirect()->route('login')
            ->with('success', 'Account attivato con successo! Effettua il login.');
    }
}