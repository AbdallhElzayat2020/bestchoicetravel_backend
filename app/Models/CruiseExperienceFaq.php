<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CruiseExperienceFaq extends Model
{
    protected $fillable = [
        'cruise_experience_id',
        'faq_id',
        'question',
        'answer',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'status' => 'string',
        'sort_order' => 'integer',
    ];

    public function cruiseExperience(): BelongsTo
    {
        return $this->belongsTo(CruiseExperience::class);
    }

    public function faq(): BelongsTo
    {
        return $this->belongsTo(Faq::class);
    }
}

