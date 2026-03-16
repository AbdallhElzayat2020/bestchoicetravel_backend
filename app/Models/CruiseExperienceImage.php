<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CruiseExperienceImage extends Model
{

    protected $fillable = [
        'cruise_experience_id',
        'image',
        'sort_order',
    ];

    public function cruiseExperience()
    {
        return $this->belongsTo(CruiseExperience::class);
    }
}
