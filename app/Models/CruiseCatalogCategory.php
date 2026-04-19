<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class CruiseCatalogCategory extends Model
{
    protected $fillable = [
        'name',
        'h1_title',
        'h2_title',
        'slug',
        'description',
        'banner_image',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function programs(): HasMany
    {
        return $this->hasMany(CruiseCatalogProgram::class, 'cruise_catalog_category_id')
            ->orderBy('sort_order');
    }

    public function vessels(): HasMany
    {
        return $this->hasMany(CruiseCatalogVessel::class, 'cruise_catalog_category_id')
            ->orderBy('sort_order');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
