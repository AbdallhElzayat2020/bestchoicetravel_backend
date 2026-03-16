<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourDay extends Model
{

    protected $fillable = [
        'tour_id',
        'day_number',
        'day_title',
        'details',
        'sort_order',
    ];

    protected $casts = [
        'day_number' => 'integer',
        'sort_order' => 'integer',
    ];

    /**
     * Get the tour that owns the tour day.
     */
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
