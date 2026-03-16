<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Country extends Model
{

    protected $fillable = [
        'name',
        'slug',
        'code',
        'flag',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'status' => 'string',
        'sort_order' => 'integer',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($country) {
            if (empty($country->slug)) {
                $country->slug = Str::slug($country->name);
            }
        });

        static::updating(function ($country) {
            if ($country->isDirty('name') && empty($country->slug)) {
                $country->slug = Str::slug($country->name);
            }
        });
    }

    /**
     * Get the states for the country.
     */
    public function states()
    {
        return $this->hasMany(State::class)->orderBy('sort_order');
    }

    /**
     * Get active states.
     */
    public function activeStates()
    {
        return $this->hasMany(State::class)->where('status', 'active')->orderBy('sort_order');
    }

    /**
     * Get the tours for the country.
     */
    public function tours()
    {
        return $this->hasMany(Tour::class);
    }

    /**
     * Scope a query to only include active countries.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
