<?php

namespace App\Mail;

use App\Models\TripPlanner;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TripPlannerMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public TripPlanner $tripPlanner) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Trip Planner request from '.$this->tripPlanner->full_name,
            replyTo: [$this->tripPlanner->email],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.trip-planner',
        );
    }
}
