<?php

namespace App\Actions\Jetstream;

use App\Models\User;
use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUser implements DeletesUsers
{
    /**
     * Delete the given user.
     */
    public function delete(User $user): void
    {
        // Delete the user's profile photo
        $user->deleteProfilePhoto();

        // Delete the user's tokens (if any)
        if ($user->tokens) {
            $user->tokens->each->delete();
        }

        // Delete the user
        $user->delete();
    }
}