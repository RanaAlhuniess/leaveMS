<?php

namespace App\Services;

use App\Models\User;
use Laravel\Passport\PersonalAccessTokenResult;

class UserService
{
    public function getUserRoleScope(User $user)
    {
        $lastRole = $user->roles()->latest()->first();

        if (!$lastRole) {
            return 'employee';
        }
        return $lastRole->name;
    }

    public function generateUserAccessToken(User $user, string $scope): PersonalAccessTokenResult
    {
        return $user->createToken($user->email . '-' . now(), [$scope]);
    }
}
