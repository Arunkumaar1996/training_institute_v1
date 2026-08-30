<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'employee_code',
        'first_name',
        'last_name',
        'email',
        'mobile',
        'emergency_contact',
        'dob',
        'gender',
        'qualification',
        'department_id',
        'designation_id',
        'joining_date',
        'salary',
        'employment_type',
        'status',
        'address',
        'city',
        'state',
        'pincode',
        'photo',
        'documents',
        'notes',
    ];

    protected $casts = [
        'dob' => 'date',
        'joining_date' => 'date',
        'salary' => 'decimal:2',
        'documents' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function designation(): BelongsTo
    {
        return $this->belongsTo(Designation::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(EmployeeAttendance::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function getBasicSalaryAttribute()
    {
        return $this->salary;
    }

    public function setBasicSalaryAttribute($value)
    {
        $this->attributes['salary'] = $value;
    }
}
