<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LeaveType\LeaveTypeStoreRequest;
use App\Http\Resources\Api\LeaveTypeResource;

use App\Models\LeaveType;
use App\Repositories\LeaveTypeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;


class LeaveTypeController extends BaseController
{
    private LeaveTypeRepository $leaveTypeRepository;

    public function __construct(LeaveTypeRepository $leaveTypeRepository)
    {
        $this->leaveTypeRepository = $leaveTypeRepository;
    }

    public function index(): JsonResponse
    {
        $leaveTypes = $this->leaveTypeRepository->getAll();
        return $this->respond(LeaveTypeResource::collection($leaveTypes));
    }

    public function show(LeaveType $leaveType): JsonResponse
    {
        return $this->respond(new LeaveTypeResource($leaveType));
    }

    public function store(LeaveTypeStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $leaveType = $this->leaveTypeRepository->create((object)$data);
        return $this->respond(new LeaveTypeResource($leaveType));

    }

    public function update(LeaveType $leaveType, Request $request)
    {
        //TODO: change to use request
        $validator = Validator::make($request->all(), [
            'name' => ['required', Rule::unique('leave_types')->ignore($leaveType->id)],
        ]);
        if ($validator->fails())
            return $this->respondError($validator->errors(), 422);
        $leaveType->name = $request->name;
        $leaveType->save();
    }

    public function delete(LeaveType $leaveType): JsonResponse
    {
        $leaveType->delete();
        return $this->respond(null, 204);
    }
}
