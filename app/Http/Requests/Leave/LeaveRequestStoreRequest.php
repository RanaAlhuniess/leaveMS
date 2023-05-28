<?php

namespace App\Http\Requests\Leave;

use Illuminate\Foundation\Http\FormRequest;

class LeaveRequestStoreRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->tokenCan('employee') || auth()->user()->tokenCan('hr');
    }

    public function rules(): array
    {
        $rules = [
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date_format:Y-m-d H:i:s',
            'end_date' => 'required|date_format:Y-m-d H:i:s|after_or_equal:start_date',
            'leave_duration' => 'required|in:full_day,half_day',
        ];
        if ($this->input('leave_duration') === 'half_day') {
            $rules['end_date'] .= '|same:start_date';
        }

        return $rules;

    }
}
