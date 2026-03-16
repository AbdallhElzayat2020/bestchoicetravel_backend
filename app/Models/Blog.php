<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'description',
        'cover_image',
        'category',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'author',
        'status',
        'show_on_homepage',
        'published_at',
        'sort_order',
    ];

    protected $casts = [
        'status' => 'string',
        'show_on_homepage' => 'boolean',
        'published_at' => 'datetime',
        'sort_order' => 'integer',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
        });

        static::updating(function ($blog) {
            if ($blog->isDirty('title') && empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
        });
    }

    /**
     * Scope a query to only include active blogs.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include blogs shown on homepage.
     */
    public function scopeHomepage($query)
    {
        return $query->where('show_on_homepage', true);
    }

    /**
     * Scope a query to only include published blogs.
     */
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }
}
