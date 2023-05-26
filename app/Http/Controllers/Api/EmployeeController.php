<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Http\Resources\Api\EmployeeResource;
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

    public function show()
    {

    }

    public function store(StoreEmployeeRequest $request): JsonResponse
    {
        $data = $request->validated();
        $employee = $this->employeeRepository->create((object)$data);
        return $this->respond($employee);

    }

    public function update()
    {

    }

    public function delete()
    {

    }
}
