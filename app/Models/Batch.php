<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Batch extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'batch_code',
        'batch_name',
        'course_id',
        'trainer_id',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'days_schedule',
        'max_students',
        'room_number',
        'mode',
        'status',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'max_students' => 'integer',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(Trainer::class);
    }

    public function trainers(): BelongsToMany
    {
        return $this->belongsToMany(Trainer::class, 'batch_trainer')->withPivot('is_primary');
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'batch_student')->withPivot('assigned_date', 'status')->withTimestamps();
    }

    public function admissions(): HasMany
    {
        return $this->hasMany(Admission::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(StudentAttendance::class);
    }

    public function getEnrolledStudentsCountAttribute(): int
    {
        return $this->students()->count();
    }

    public function getIsFullAttribute(): bool
    {
        return $this->enrolled_students_count >= $this->max_students;
    }
}
