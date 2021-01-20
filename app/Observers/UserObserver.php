<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function creating(User $user): void
    {
        if ($this->isFirstUser())
        {
            $user->isadmin = true;
        }
    }

    public function isFirstUser() : bool
    {
        return User::query()->count() === 0;
    }
}
