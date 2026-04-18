<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CruiseCatalogProgramDay extends Model
{
    protected $fillable = [
        'cruise_catalog_program_id',
        'day_number',
        'day_title',
        'day_status',
        'details',
        'sort_order',
    ];

    protected $casts = [
        'day_number' => 'integer',
        'sort_order' => 'integer',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(CruiseCatalogProgram::class, 'cruise_catalog_program_id');
    }
}
