<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TripPlanner extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'full_name',
        'nationality',
        'phone',
        'email',
        'adults',
        'children',
        'infants',
        'arrival_date',
        'departure_date',
        'message',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'arrival_date' => 'date',
        'departure_date' => 'date',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function markAsRead(): void
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
}
