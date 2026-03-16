<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourSeasonalPriceItem extends Model
{

    protected $fillable = [
        'seasonal_price_id',
        'price_name',
        'price_value',
        'description',
        'sort_order',
    ];

    protected $casts = [
        'price_value' => 'decimal:2',
        'sort_order' => 'integer',
    ];

    /**
     * Get the seasonal price that owns this item.
     */
    public function seasonalPrice()
    {
        return $this->belongsTo(TourSeasonalPrice::class, 'seasonal_price_id');
    }
}
