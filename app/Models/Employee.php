<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['dob', 'join_date', 'created_at', 'updated_at'];
    protected $fillable = ['user_id', 'first_name', 'last_name', 'gender', 'dob', 'join_date', 'salary'];
    protected $casts = [
        'dob' => 'datetime',
        'join_date' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
