<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{

    protected $fillable = [
        'name',
        'description',
        'image',
        'job_title',
        'company',
        'rating',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'status' => 'string',
        'rating' => 'integer',
        'sort_order' => 'integer',
    ];

    /**
     * Scope a query to only include active testimonials.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include inactive testimonials.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }
}
