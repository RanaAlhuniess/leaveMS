<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Leave\LeaveRequestStoreRequest;
use App\Models\LeaveRequest;
use App\Services\EmployeeService;
use Illuminate\Http\JsonResponse;

class LeaveController extends BaseController
{
    private EmployeeService $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    /**
     * @throws \Exception
     */
    public function store(LeaveRequestStoreRequest $request): JsonResponse
    {
        $employee = auth()->user()->employee;
        $data = (object)$request->validated();
        $leaveTypeId = $data->leave_type_id;
        $hasLeaveBalance = $this->employeeService->hasLeaveBalance($employee->id, $leaveTypeId);
        if (!$hasLeaveBalance) {
            return response()->json(['message' => 'Insufficient leave balance'], 400);
        }
        $this->employeeService->createLeaveRequest($employee->id, $data);
        return response()->json(null, 201);
    }

    /**
     * @throws \Exception
     */
    public function approve(LeaveRequest $leaveRequest): JsonResponse
    {
        $this->employeeService->approveLeaveRequest($leaveRequest);
        return response()->json(['message' => 'Leave request approved.']);
    }

    public function decline(LeaveRequest $leaveRequest): JsonResponse
    {
        $this->employeeService->declineLeaveRequest($leaveRequest);
        return response()->json(['message' => 'Leave request declined.']);
    }

}
