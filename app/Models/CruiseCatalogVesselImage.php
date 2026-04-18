<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CruiseCatalogVesselImage extends Model
{
    protected $fillable = [
        'cruise_catalog_vessel_id',
        'image_path',
        'alt',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function vessel(): BelongsTo
    {
        return $this->belongsTo(CruiseCatalogVessel::class, 'cruise_catalog_vessel_id');
    }
}
