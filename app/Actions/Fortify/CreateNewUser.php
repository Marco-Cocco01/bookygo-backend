<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
//Add By Mac
use App\Models\UserType;
use App\Models\TypeUser;
use App\Models\Rules;
use App\Models\UsersRights;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            ...$this->profileRules(),
            'password' => $this->passwordRules(),
        ])->validate();


        // Add By Mac
        //User::create
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'],
        ]);

        // Add By Mac
        // /admin/register → business (2), altrimenti client (3)
        $typeUser = TypeUser::create([
            'id_user' => $user->id,
            'id_type' => 2, // Business
        ]);  


        //Add By Mac
        //Add Rights to User
        $modulesRules = Rules::where('id_type_user', 2)->pluck('id_module')->toArray();
        foreach ($modulesRules as $moduleId) {
            UsersRights::create([
                'id_user' => $user->id,
                'id_parent' => $user->id, // Assuming no parent module for simplicity
                'id_module' => $moduleId,
                'can_view' => true, // Default permissions
                'can_add' => true,
                'can_edit' => true,
                'can_delete' => true,
            ]);
        }

        return $user;
    }
}
