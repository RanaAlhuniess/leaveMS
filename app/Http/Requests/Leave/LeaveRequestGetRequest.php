<?php

namespace App\Http\Requests\Leave;

use Illuminate\Foundation\Http\FormRequest;

class LeaveRequestGetRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->tokenCan('employee') || auth()->user()->tokenCan('hr');
    }

    public function rules(): array
    {
        return [
            'start_date' => 'date',
            'status' => 'in:pending,declined,approved',
        ];

    }
}
