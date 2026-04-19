<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Contact extends Model
{

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'category_id',
        'sub_category_id',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /**
     * Get the category that owns the contact.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the sub category that owns the contact.
     */
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    /**
     * Mark contact as read.
     */
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    /**
     * Scope a query to only include unread contacts.
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope a query to only include read contacts.
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    /**
     * Cruise catalog vessel enquiry forms (stored with a fixed subject prefix).
     */
    public function scopeCruiseVesselEnquiries($query)
    {
        return $query->where('subject', 'like', 'Cruise vessel enquiry:%');
    }

    public function isCruiseVesselEnquiry(): bool
    {
        return str_starts_with((string) $this->subject, 'Cruise vessel enquiry:');
    }

    public function cruiseVesselTitle(): ?string
    {
        if (! $this->isCruiseVesselEnquiry()) {
            return null;
        }

        return trim(Str::after((string) $this->subject, 'Cruise vessel enquiry:'));
    }
}
