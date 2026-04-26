<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'content',
        'banner_image',
        'meta_title',
        'meta_description',
        'meta_author',
        'meta_keywords',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'status' => 'string',
        'sort_order' => 'integer',
    ];

    /**
     * Get page by slug
     */
    public static function getBySlug(string $slug)
    {
        return static::where('slug', $slug)->first();
    }
}
