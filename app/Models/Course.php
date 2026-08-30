<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'course_name',
        'course_code',
        'slug',
        'level',
        'duration',
        'duration_unit',
        'course_fee',
        'discount_fee',
        'final_fee',
        'short_description',
        'full_description',
        'learning_outcomes',
        'requirements',
        'image',
        'brochure_file',
        'certification_available',
        'featured',
        'sort_order',
        'status',
        'seo_title',
        'seo_description',
        'seo_keywords',
    ];

    protected $casts = [
        'course_fee' => 'decimal:2',
        'discount_fee' => 'decimal:2',
        'final_fee' => 'decimal:2',
        'certification_available' => 'boolean',
        'featured' => 'boolean',
        'duration' => 'integer',
        'sort_order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function ($course) {
            if (empty($course->final_fee)) {
                $course->final_fee = max(0, ($course->course_fee ?? 0) - ($course->discount_fee ?? 0));
            }
        });
    }

    public function getFinalFeeAttribute($value)
    {
        if ($value !== null && $value > 0) {
            return (float) $value;
        }
        return (float) max(0, ($this->course_fee ?? 0) - ($this->discount_fee ?? 0));
    }

    public function getImageUrlAttribute(): string
    {
        if (!empty($this->image)) {
            if (str_starts_with($this->image, 'http')) {
                return $this->image;
            }
            return asset('storage/' . $this->image);
        }
        return 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=800&q=80';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(CourseCategory::class, 'category_id');
    }

    public function syllabi(): HasMany
    {
        return $this->hasMany(CourseSyllabus::class)->orderBy('sort_order')->orderBy('module_number');
    }

    public function batches(): HasMany
    {
        return $this->hasMany(Batch::class);
    }

    public function admissions(): HasMany
    {
        return $this->hasMany(Admission::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class);
    }
}
