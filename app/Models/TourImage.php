<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourImage extends Model
{

    protected $fillable = [
        'tour_id',
        'image',
        'alt',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    /**
     * Get the tour that owns the tour image.
     */
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
