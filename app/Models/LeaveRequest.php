<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'leave_type_id', 'start_date', 'end_date', 'reason', 'leave_duration', 'status'];
    protected $dates = ['start_date', 'end_date', 'created_at', 'updated_at'];
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function leaveType(): BelongsTo
    {
        return $this->belongsTo(LeaveType::class,'leave_type_id');
    }
    public function markAsApproved() {
        $this->update(['status' => 'approved']);
    }
    public function markAsDeclined() {
        $this->update(['status' => 'declined']);
    }
}
