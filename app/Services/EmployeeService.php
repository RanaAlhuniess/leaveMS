<?php

namespace App\Services;

use App\Models\EmployeeLeaveBalance;
use App\Models\LeaveRequest;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\Translation\t;

class EmployeeService
{
    private EmployeeRepositoryInterface $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

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

    /**
     * @throws \Exception
     */
    public function approveLeaveRequest(LeaveRequest $leaveRequest): void
    {
        DB::beginTransaction();
        try {
            $employee = $leaveRequest->employee;
            $leaveType = $leaveRequest->leaveType;
            if (!$employee || !$leaveType)
                throw new \Exception('Oops, Something going wrong', 400);
            if ($leaveRequest->status === 'approved') {
                throw new \Exception('The request has already been processed', 409);
            }
            $duration = $leaveRequest->start_date->diffInDays($leaveRequest->end_date) + 1;//
            $employeeLeaveBalance = $this->employeeRepository->getEmployeeLeaveBalanceByType($employee->id, $leaveType->id);
            // TODO: should not use leave_duration value as hardcoded
            if ($leaveRequest->leave_duration === 'half_day') {
                $duration -= 0.5;
            };
            if ($employeeLeaveBalance->balance < $duration) {
                throw new \Exception('Insufficient leave balance', 422);
            }
            $leaveRequest->markAsApproved();
            $employeeLeaveBalance->balance -= $duration; // Adjust the balance based on the leave duration
            $employeeLeaveBalance->save();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }
    }

    public function declineLeaveRequest(LeaveRequest $leaveRequest): void
    {
        $leaveRequest->markAsDeclined();
    }
}
