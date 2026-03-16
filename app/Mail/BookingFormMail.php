<?php

namespace App\Mail;

use App\Models\Booking;
use App\Models\Tour;
use App\Models\TourVariant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingFormMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var array<int, string> */
    public array $variantNames = [];

    public function __construct(
        public Booking $booking,
        public Tour $tour
    ) {
        $ids = is_array($booking->selected_variants) ? $booking->selected_variants : [];
        if (!empty($ids)) {
            $this->variantNames = TourVariant::whereIn('id', $ids)->pluck('title')->all();
        }
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'حجز جديد: ' . $this->tour->title,
            replyTo: [$this->booking->email],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-form',
        );
    }
}
