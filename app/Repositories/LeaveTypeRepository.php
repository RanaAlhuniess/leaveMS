<?php

namespace App\Repositories;

use App\Models\LeaveType;
use App\Repositories\Interfaces\LeaveTypeRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class LeaveTypeRepository implements LeaveTypeRepositoryInterface
{

    public function getAll(): Collection
    {
        return LeaveType::all();
    }

    public function create($data)
    {
        return LeaveType::create([
            'name' => $data->name
        ]);
    }

    public function getById($id)
    {
        return LeaveType::findOrFail($id);
    }

    public function update($data, $id)
    {
        return LeaveType::whereId($id)->update($data);
    }

    public function delete($id)
    {
        LeaveType::destroy($id);
    }
}
