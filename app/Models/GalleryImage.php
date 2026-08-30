<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GalleryImage extends Model
{
    protected $fillable = [
        'gallery_category_id',
        'title',
        'description',
        'image_path',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function setCategoryIdAttribute($value)
    {
        $this->attributes['gallery_category_id'] = $value;
    }

    public function getImageUrlAttribute(): string
    {
        if (!empty($this->image_path)) {
            if (str_starts_with($this->image_path, 'http')) {
                return $this->image_path;
            }
            return asset('storage/' . $this->image_path);
        }
        return 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=800&q=80';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(GalleryCategory::class, 'gallery_category_id');
    }
}
