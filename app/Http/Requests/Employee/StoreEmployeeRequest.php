<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->tokenCan('hr');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|regex:/^[a-zA-Z ]+$/',
            'last_name' => 'required|regex:/^[a-zA-Z ]+$/',
            'email' => 'required|email|max:200|unique:users',
            'password' => 'required|min:6|max:20',
            'gender' => 'required',
            'dob' => 'required|date|before_or_equal:today',
            'salary' => 'required',
            'join_date' => 'required|date|before_or_equal:today',
            'role_id' => 'required|exists:roles,id',
        ];
    }
}
