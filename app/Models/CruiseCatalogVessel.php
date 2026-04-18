<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class CruiseCatalogVessel extends Model
{
    protected $fillable = [
        'cruise_catalog_category_id',
        'title',
        'slug',
        'short_description',
        'description',
        'cover_image',
        'price_tier_1',
        'price_tier_2',
        'price_tier_3',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'price_tier_1' => 'decimal:2',
        'price_tier_2' => 'decimal:2',
        'price_tier_3' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(CruiseCatalogCategory::class, 'cruise_catalog_category_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(CruiseCatalogVesselImage::class, 'cruise_catalog_vessel_id')
            ->orderBy('sort_order');
    }

    public function programs(): BelongsToMany
    {
        return $this->belongsToMany(
            CruiseCatalogProgram::class,
            'cruise_catalog_program_vessel',
            'cruise_catalog_vessel_id',
            'cruise_catalog_program_id'
        )->withPivot('sort_order')->withTimestamps()->orderByPivot('sort_order');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
