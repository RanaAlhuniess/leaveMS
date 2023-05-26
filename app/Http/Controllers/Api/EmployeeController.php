<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Http\Resources\Api\UserResource;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends BaseController
{
    private EmployeeRepositoryInterface $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
//        $this->middleware('guest');
        $this->employeeRepository = $employeeRepository;
    }

    public function index()
    {

    }

    public function show()
    {

    }

    public function store(StoreEmployeeRequest $request)
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
