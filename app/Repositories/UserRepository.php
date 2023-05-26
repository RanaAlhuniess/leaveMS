<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{

    public function getUserRoleById($id)
    {
        // TODO: Implement getUserRoleById() method.
    }

    public function getUserById($id)
    {
        return User::findOrFail($id);
    }
}
