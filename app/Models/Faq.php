<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{

    protected $fillable = [
        'question',
        'answer',
        'status',
        'sort_order',
        'show_on_homepage',
    ];

    protected $casts = [
        'status' => 'string',
        'sort_order' => 'integer',
        'show_on_homepage' => 'boolean',
    ];

    /**
     * Scope a query to only include active FAQs.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include inactive FAQs.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }
}
