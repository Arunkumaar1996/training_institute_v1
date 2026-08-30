<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enquiry extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'enquiry_code',
        'name',
        'mobile',
        'email',
        'course_id',
        'batch_id',
        'lead_source_id',
        'message',
        'status',
        'assigned_to',
        'follow_up_date',
        'admission_id',
    ];

    protected $casts = [
        'follow_up_date' => 'date',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }

    public function leadSource(): BelongsTo
    {
        return $this->belongsTo(LeadSource::class, 'lead_source_id');
    }

    public function source(): BelongsTo
    {
        return $this->belongsTo(LeadSource::class, 'lead_source_id');
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function getNextFollowUpAttribute()
    {
        return $this->follow_up_date;
    }

    public function followUps(): HasMany
    {
        return $this->hasMany(FollowUp::class)->orderByDesc('follow_up_date');
    }

    public function admission(): BelongsTo
    {
        return $this->belongsTo(Admission::class);
    }
}
