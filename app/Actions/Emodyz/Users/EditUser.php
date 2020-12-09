<?php

namespace App\Actions\Emodyz\Users;

use App\Models\User;
use App\Rules\RoleExists;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class EditUser
{
    /**
     * Validate and update the given user if the initiator has the appropriate authorizations.
     *
     * @param User $user
     * @param array $input
     * @return void
     * @throws ValidationException
     */
    public function editUserProfile(User $user, array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', 'string', 'max:255', new RoleExists()],
            'photo' => ['nullable', 'image', 'max:1024'],
        ])->validateWithBag('editUserProfile');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }


        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => now(),
        ])->save();

    }
}
