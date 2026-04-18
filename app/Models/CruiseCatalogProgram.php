<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class CruiseCatalogProgram extends Model
{
    protected $fillable = [
        'cruise_catalog_category_id',
        'title',
        'slug',
        'short_description',
        'duration_days',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'duration_days' => 'integer',
        'sort_order' => 'integer',
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

    public function days(): HasMany
    {
        return $this->hasMany(CruiseCatalogProgramDay::class, 'cruise_catalog_program_id')
            ->orderBy('sort_order')
            ->orderBy('day_number');
    }

    public function vessels(): BelongsToMany
    {
        return $this->belongsToMany(
            CruiseCatalogVessel::class,
            'cruise_catalog_program_vessel',
            'cruise_catalog_program_id',
            'cruise_catalog_vessel_id'
        )->withPivot('sort_order')->withTimestamps()->orderByPivot('sort_order');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
