<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class LeaveRequestResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'reason' => $this->reason,
            'startDate' => $this->start_date->format('Y-m-d'),
            'endDate' => $this->end_date->format('Y-m-d'),
            'leaveDuration' => $this->leave_duration,
            'leaveType' => $this->whenLoaded('leaveType', function () {
                return $this->leaveType->name;
            }),
        ];
    }
}
