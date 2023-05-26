<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function getUserById($id);
    public function getUserRoleById($id);
}
