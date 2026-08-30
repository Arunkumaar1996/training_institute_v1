<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trainer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'trainer_code',
        'name',
        'email',
        'mobile',
        'alternate_mobile',
        'qualification',
        'specialization',
        'experience_years',
        'joining_date',
        'salary',
        'skills',
        'bio',
        'address',
        'photo',
        'status',
    ];

    protected $casts = [
        'joining_date' => 'date',
        'salary' => 'decimal:2',
        'experience_years' => 'integer',
    ];

    public function getPhotoUrlAttribute(): string
    {
        if (!empty($this->photo)) {
            if (str_starts_with($this->photo, 'http')) {
                return $this->photo;
            }
            return asset('storage/' . $this->photo);
        }
        return 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=300&q=80';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function batches(): HasMany
    {
        return $this->hasMany(Batch::class, 'trainer_id');
    }

    public function assignedBatches(): BelongsToMany
    {
        return $this->belongsToMany(Batch::class, 'batch_trainer');
    }

    public function admissions(): HasMany
    {
        return $this->hasMany(Admission::class);
    }

    public function studentAttendances(): HasMany
    {
        return $this->hasMany(StudentAttendance::class);
    }
}
