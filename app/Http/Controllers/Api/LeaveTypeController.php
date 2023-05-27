<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Employee\EmployeeStoreRequest;
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
        return $this->respond($employee);

    }

    public function update()
    {

    }

    public function delete(Employee $employee): JsonResponse
    {
        $employee->delete();
        return $this->respond(null, 204);
    }
}
