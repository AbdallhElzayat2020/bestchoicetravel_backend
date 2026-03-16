<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{

    protected $fillable = [
        'tour_id',
        'full_name',
        'email',
        'phone',
        'nationality',
        'no_of_travellers',
        'accommodation_type_id',
        'selected_variants',
        'total_price',
        'status',
        'notes',
    ];

    protected $casts = [
        'selected_variants' => 'array',
        'total_price' => 'decimal:2',
        'no_of_travellers' => 'integer',
        'status' => 'string',
    ];

    /**
     * Get the tour that owns the booking.
     */
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    /**
     * Get the accommodation type for the booking.
     */
    public function accommodationType()
    {
        return $this->belongsTo(TourSeasonalPriceItem::class, 'accommodation_type_id');
    }



    /**
     * Scope a query to only include pending bookings.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include confirmed bookings.
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope a query to only include cancelled bookings.
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }
}
