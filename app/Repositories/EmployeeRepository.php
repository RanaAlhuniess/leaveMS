<?php

namespace App\Repositories;

use App\Models\Employee;
use App\Models\User;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class EmployeeRepository implements EmployeeRepositoryInterface
{

    public function getAll(): LengthAwarePaginator
    {
        return Employee::with(['user'])->latest()->paginate(10);
    }

    public function create($data)
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $data->first_name,
                'email' => $data->email,
                'password' => $data->password,
            ]);

            Employee::create([
                'user_id' => $user->id,
                'first_name' => $data->first_name,
                'last_name' => $data->last_name,
                'gender' => $data->gender,
                'dob' => Carbon::createFromFormat('d.m.Y', $data->dob)->toDateString(),
                'salary' => $data->salary,
                'join_date' => Carbon::createFromFormat('d.m.Y', $data->join_date)->toDateString(),
            ]);
            $user->roles()->attach($data->role_id);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
