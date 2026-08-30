<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FollowUp extends Model
{
    protected $fillable = [
        'enquiry_id',
        'user_id',
        'follow_up_date',
        'follow_up_time',
        'notes',
        'status',
        'next_follow_up_date',
        'next_follow_up_time',
    ];

    protected $casts = [
        'follow_up_date' => 'date',
        'next_follow_up_date' => 'date',
    ];

    public function enquiry(): BelongsTo
    {
        return $this->belongsTo(Enquiry::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getRemarksAttribute()
    {
        return $this->notes;
    }

    public function setRemarksAttribute($value)
    {
        $this->attributes['notes'] = $value;
    }

    public function getNextFollowUpAttribute()
    {
        return $this->next_follow_up_date;
    }

    public function setNextFollowUpAttribute($value)
    {
        $this->attributes['next_follow_up_date'] = $value;
    }
}
