<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PointsEarnedMail extends Mailable
{
    public $customer;
    public $points;

    use Queueable, SerializesModels;

   /**
     * Create a new message instance.
     *
     * @param $customer
     * @param $points
     */
    public function __construct($customer, $points)
    {
        $this->customer = $customer;
        $this->points = $points;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Novos Pontos adquiridos no Fidelita - FIDELITA APP',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.points-earned',
            with: [
                'points' => $this->points,
                'customer' => $this->customer
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
