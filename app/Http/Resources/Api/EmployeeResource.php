<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => optional($this->user)->email,
            'gender' => $this->gender,
            'dob' => $this->dob->format('Y-m-d'),
            'salary' => $this->salary,
            'join_date' => $this->join_date->format('Y-m-d'),
            'role' => $this->whenLoaded('user', function () {
                return $this->user->roles->last()->name;
            }),
        ];
    }
}
