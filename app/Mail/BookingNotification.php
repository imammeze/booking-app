<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Permohonan Booking Baru - ' . $this->booking->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.booking_notification', 
        );
    }

    public function attachments(): array
    {
        return [];
    }
}