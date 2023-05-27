<?php

namespace App\Services;

use App\Models\EmployeeLeaveBalance;
use App\Models\LeaveRequest;

class EmployeeService
{
    public function hasLeaveBalance($employeeId, $leaveTypeId): bool
    {
        $leaveBalance = EmployeeLeaveBalance::where('employee_id', $employeeId)
            ->where('leave_type_id',
                $leaveTypeId)
            ->first();
        if (!$leaveBalance || $leaveBalance->balance <= 0) {
            return false;
        }
        return true;
    }

    /**
     * @throws \Exception
     */
    public function createLeaveRequest($employeeId, object $data): void
    {
        $leaveRequest = LeaveRequest::create([
            'employee_id' => $employeeId,
            'leave_type_id' => $data->leave_type_id,
            'start_date' => formatDate($data->start_date),
            'end_date' => formatDate($data->end_date),
            'reason' => $data->reason ?? null,
        ]);
    }
}
