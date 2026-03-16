<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{

    protected $fillable = [
        'title',
        'description',
        'image',
        'status',
        'sort_order',
        'link',
        'button_text',
    ];

    protected $casts = [
        'status' => 'string',
        'sort_order' => 'integer',
    ];

    /**
     * Scope a query to only include active sliders.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include inactive sliders.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }
}
