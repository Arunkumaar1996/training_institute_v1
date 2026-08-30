<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseSyllabus extends Model
{
    protected $fillable = [
        'course_id',
        'module_number',
        'title',
        'description',
        'topics',
        'duration_hours',
        'sort_order',
    ];

    protected $casts = [
        'module_number' => 'integer',
        'duration_hours' => 'integer',
        'sort_order' => 'integer',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
