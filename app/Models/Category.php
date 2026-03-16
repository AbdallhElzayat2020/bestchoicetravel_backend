<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'image_alt',
        'status',
        'sort_order',
        'grid_columns',
        'custom_css',
        'header_background_color',
        'header_text_color',
        'card_style',
        'show_breadcrumb',
        'show_description',
    ];

    protected $casts = [
        'status' => 'string',
        'sort_order' => 'integer',
        'show_breadcrumb' => 'boolean',
        'show_description' => 'boolean',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Get the sub categories for the category.
     */
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class)->orderBy('sort_order');
    }

    /**
     * Get active sub categories.
     */
    public function activeSubCategories()
    {
        return $this->hasMany(SubCategory::class)->where('status', 'active')->orderBy('sort_order');
    }

    /**
     * Get the tours for the category.
     */
    public function tours()
    {
        return $this->hasMany(Tour::class)->orderBy('sort_order');
    }

    /**
     * Get active tours for the category.
     */
    public function activeTours()
    {
        return $this->hasMany(Tour::class)->where('status', 'active')->orderBy('sort_order');
    }

    /**
     * Scope a query to only include active categories.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
