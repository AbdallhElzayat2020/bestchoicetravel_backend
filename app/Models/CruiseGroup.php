<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class CruiseGroup extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'group_key',
        'meta_title',
        'meta_description',
        'sort_order',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($group) {
            if (empty($group->slug)) {
                $group->slug = Str::slug($group->name);
            }
            // Auto-generate group_key from slug if not provided
            if (empty($group->group_key)) {
                $group->group_key = Str::slug($group->slug);
            }
        });

        static::updating(function ($group) {
            if ($group->isDirty('name') && empty($group->slug)) {
                $group->slug = Str::slug($group->name);
            }
            // Auto-generate group_key from slug if not provided and slug changed
            if ($group->isDirty('slug') && empty($group->group_key)) {
                $group->group_key = Str::slug($group->slug);
            }
        });
    }

    /**
     * Scope a query to only include active groups.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Cruise experiences belonging to this group.
     */
    public function cruiseExperiences(): HasMany
    {
        return $this->hasMany(CruiseExperience::class)->orderBy('sort_order');
    }
}
