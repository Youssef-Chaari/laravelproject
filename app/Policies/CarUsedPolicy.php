<?php

namespace App\Policies;

use App\Models\CarUsed;
use App\Models\User;

class CarUsedPolicy
{
    public function update(User $user, CarUsed $car): bool
    {
        return $user->isAdmin() || $user->id === $car->user_id;
    }

    public function delete(User $user, CarUsed $car): bool
    {
        return $user->isAdmin() || $user->id === $car->user_id;
    }
}
