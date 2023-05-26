<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    use HasFactory;

    protected $dates = ['dob', 'join_date', 'created_at', 'updated_at'];
    protected $fillable = ['user_id', 'first_name', 'last_name', 'gender', 'dob', 'join_date', 'salary'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
