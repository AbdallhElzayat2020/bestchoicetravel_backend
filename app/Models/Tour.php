<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tour extends Model
{

    protected $fillable = [
        'category_id',
        'sub_category_id',
        'country_id',
        'state_id',
        'title',
        'slug',
        'short_description',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'duration',
        'duration_type',
        'cover_image',
        'cover_image_alt',
        'status',
        'show_on_homepage',
        'price',
        'has_offer',
        'price_before_discount',
        'price_after_discount',
        'offer_start_date',
        'offer_end_date',
        'notes',
        'sort_order',
    ];

    protected $casts = [
        'status' => 'string',
        'show_on_homepage' => 'boolean',
        'has_offer' => 'boolean',
        'duration' => 'integer',
        'duration_type' => 'string',
        'price' => 'decimal:2',
        'price_before_discount' => 'decimal:2',
        'price_after_discount' => 'decimal:2',
        'offer_start_date' => 'date',
        'offer_end_date' => 'date',
        'sort_order' => 'integer',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tour) {
            if (empty($tour->slug)) {
                $tour->slug = Str::slug($tour->title);
            }
        });

        static::updating(function ($tour) {
            if ($tour->isDirty('title') && empty($tour->slug)) {
                $tour->slug = Str::slug($tour->title);
            }
        });
    }

    /**
     * Get the category that owns the tour.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the sub category that owns the tour.
     */
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    /**
     * Get the country that owns the tour.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the state that owns the tour.
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /**
     * Get the tour days for the tour.
     */
    public function tourDays()
    {
        return $this->hasMany(TourDay::class)->orderBy('sort_order')->orderBy('day_number');
    }

    /**
     * Get the tour images for the tour.
     */
    public function tourImages()
    {
        return $this->hasMany(TourImage::class)->orderBy('sort_order');
    }

    /**
     * Get the tour variants for the tour (old relationship - kept for backward compatibility).
     */
    public function tourVariants()
    {
        return $this->hasMany(TourVariant::class)->orderBy('sort_order');
    }

    /**
     * Get the standalone tour variants that belong to this tour via pivot table.
     */
    public function variants()
    {
        return $this->belongsToMany(TourVariant::class, 'tour_tour_variant', 'tour_id', 'tour_variant_id')
            ->withTimestamps()
            ->orderBy('sort_order');
    }

    /**
     * Get the seasonal prices for the tour.
     */
    public function seasonalPrices()
    {
        return $this->hasMany(TourSeasonalPrice::class)->orderBy('sort_order');
    }

    /**
     * Scope a query to only include active tours.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include tours shown on homepage.
     */
    public function scopeHomepage($query)
    {
        return $query->where('show_on_homepage', true);
    }

    /**
     * Get the current price (considering offers).
     */
    public function getCurrentPriceAttribute()
    {
        if ($this->has_offer && $this->isOfferActive()) {
            return $this->price_after_discount ?? $this->price;
        }
        return $this->price;
    }

    /**
     * Check if the offer is currently active.
     */
    public function isOfferActive()
    {
        if (!$this->has_offer) {
            return false;
        }

        $now = now();
        $startDate = $this->offer_start_date;
        $endDate = $this->offer_end_date;

        if ($startDate && $now->lt($startDate)) {
            return false;
        }

        if ($endDate && $now->gt($endDate)) {
            return false;
        }

        return true;
    }
}
