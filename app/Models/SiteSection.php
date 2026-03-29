<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSection extends Model
{
    protected $fillable = [
        'key',
        'title',
        'subtitle',
        'description',
        'content',
        'button_text',
        'button_link',
        'image_path',
        'vimeo_url',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'status' => 'string',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
