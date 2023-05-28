<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Employee\EmployeeStoreRequest;
use App\Http\Requests\Employee\EmployeeUpdateLeaveBalanceRequest;
use App\Http\Resources\Api\EmployeeResource;
use App\Models\Employee;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Traits\Pagination\PaginationTrait;
use Illuminate\Http\JsonResponse;

class EmployeeController extends BaseController
{
    use PaginationTrait;

    private EmployeeRepositoryInterface $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function index(): JsonResponse
    {
        $employees = $this->employeeRepository->getAll();
        $employees = $this->paginateCollection($employees, EmployeeResource::class);
        return $this->respond($employees);
    }

    public function show(Employee $employee)
    {
        return $this->respond(new EmployeeResource($employee));
    }

    public function store(EmployeeStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $employee = $this->employeeRepository->create((object)$data);
        return $this->respond(new EmployeeResource($employee));

    }

    public function update()
    {

    }

    public function destroy(Employee $employee): JsonResponse
    {
        $employee->delete();
        return $this->respond(null, 204);
    }

    public function updateLeaveBalance(EmployeeUpdateLeaveBalanceRequest $request, Employee $employee): JsonResponse
    {
        $data = (object)$request->validated();
        $leaveTypeId = $data->leave_type_id;
        $balance = $data->balance;
        $employee->leaveBalances()->syncWithoutDetaching([$leaveTypeId => ['balance' => $balance]]);
        return $this->respond(['message' => 'Leave balance updated successfully']);
    }
}
