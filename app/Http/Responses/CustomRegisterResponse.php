<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class CustomRegisterResponse implements RegisterResponseContract
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }


    public function toResponse($request)
    {
        if ($request->wantsJson()) {
            return response()->json(['message' => __('Registrazione completata, controlla la tua email.')], 201);
        }

        return redirect()->route('registration.verify-notice');
    }
}
