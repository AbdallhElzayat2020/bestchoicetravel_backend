<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourVariant extends Model
{

    protected $fillable = [
        'title',
        'description',
        'image',
        'additional_duration',
        'additional_duration_type',
        'additional_price',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'additional_duration' => 'integer',
        'additional_price' => 'decimal:2',
        'sort_order' => 'integer',
    ];

    /**
     * Get the tours that use this variant.
     */
    public function tours()
    {
        return $this->belongsToMany(Tour::class, 'tour_tour_variant', 'tour_variant_id', 'tour_id')
            ->withTimestamps();
    }

    /**
     * Scope a query to only include active variants.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
