<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourSeasonalPrice extends Model
{

    protected $fillable = [
        'tour_id',
        'season_name',
        'start_month',
        'end_month',
        'price_value',
        'description',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'start_month' => 'integer',
        'end_month' => 'integer',
        'price_value' => 'decimal:2',
        'sort_order' => 'integer',
    ];

    /**
     * Get the tour that owns the seasonal price.
     */
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    /**
     * Get the price items for this seasonal price.
     */
    public function priceItems()
    {
        return $this->hasMany(TourSeasonalPriceItem::class, 'seasonal_price_id')->orderBy('sort_order');
    }

    /**
     * Scope a query to only include active seasonal prices.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Get month name
     */
    public function getStartMonthNameAttribute()
    {
        $months = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        ];
        return $months[$this->start_month] ?? '';
    }

    /**
     * Get month name
     */
    public function getEndMonthNameAttribute()
    {
        $months = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        ];
        return $months[$this->end_month] ?? '';
    }
}
