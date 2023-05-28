<?php

namespace App\Repositories\Interfaces;

interface EmployeeRepositoryInterface
{
    public function getAll();
    public function create(object $data);
    public function getEmployeeLeaveBalanceByType(int $employeeId, int $typeId);
}
