<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * @param User $user
     * @throws \Exception
     */
    public function creating(User $user)
    {
        $user->api_token = unique_api_token();
    }
}
