<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Leave\LeaveRequestGetRequest;
use App\Http\Requests\Leave\LeaveRequestStoreRequest;
use App\Http\Resources\Api\EmployeeResource;
use App\Http\Resources\Api\LeaveRequestResource;
use App\Models\LeaveRequest;
use App\Services\EmployeeService;
use App\Traits\Pagination\PaginationTrait;
use Illuminate\Http\JsonResponse;

class LeaveController extends BaseController
{
    use PaginationTrait;

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
        return $this->respond(null, 201);
    }

    /**
     * @throws \Exception
     */
    public function approve(LeaveRequest $leaveRequest): JsonResponse
    {
        $this->employeeService->approveLeaveRequest($leaveRequest);
        return $this->respond(['message' => 'Leave request approved.']);
    }

    public function decline(LeaveRequest $leaveRequest): JsonResponse
    {
        $this->employeeService->declineLeaveRequest($leaveRequest);
        return $this->respond(['message' => 'Leave request declined.']);
    }

    public function getEmployeeLeaveRequests(LeaveRequestGetRequest $request): JsonResponse
    {
        $employee = auth()->user()->employee;
        $filters = $request->query();
        $leaveRequests = $employee->leaveRequests()->with(['leaveType'])->filter($filters)->latest()->paginate(10);
        $leaveRequests = $this->paginateCollection($leaveRequests, LeaveRequestResource::class);
        return $this->respond($leaveRequests);


    }
}
