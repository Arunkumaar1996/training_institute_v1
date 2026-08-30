<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_code',
        'user_id',
        'first_name',
        'last_name',
        'dob',
        'gender',
        'blood_group',
        'id_proof_type',
        'id_proof_number',
        'mobile',
        'alternate_mobile',
        'email',
        'address',
        'city',
        'state',
        'country',
        'pincode',
        'parent_name',
        'guardian_name',
        'parent_mobile',
        'parent_occupation',
        'emergency_contact',
        'qualification',
        'institution',
        'passing_year',
        'previous_experience',
        'photo',
        'status',
    ];

    protected $casts = [
        'dob' => 'date',
    ];

    public function getPhotoUrlAttribute(): string
    {
        if (!empty($this->photo)) {
            if (str_starts_with($this->photo, 'http')) {
                return $this->photo;
            }
            return asset('storage/' . $this->photo);
        }
        return 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=200&q=80';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function batches(): BelongsToMany
    {
        return $this->belongsToMany(Batch::class, 'batch_student')->withPivot('assigned_date', 'status')->withTimestamps();
    }

    public function admissions(): HasMany
    {
        return $this->hasMany(Admission::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(StudentDocument::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(StudentNote::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(StudentAttendance::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function getAttendancePercentageAttribute(): float
    {
        $total = $this->attendances()->count();
        if ($total === 0) {
            return 0.0;
        }
        $present = $this->attendances()->whereIn('status', ['Present', 'Late'])->count();
        return round(($present / $total) * 100, 1);
    }
}
