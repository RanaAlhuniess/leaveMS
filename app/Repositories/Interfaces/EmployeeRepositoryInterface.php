<?php

namespace App\Repositories\Interfaces;

interface EmployeeRepositoryInterface
{
    public function getAll();
    public function create(object $data);
}
