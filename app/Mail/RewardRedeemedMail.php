<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RewardRedeemedMail extends Mailable
{

    use Queueable, SerializesModels;

    public $customer;
    public $reward;

    /**
     * Create a new message instance.
     *
     * @param $customer
     * @param $reward
     */
    public function __construct($customer, $reward)
    {
        $this->customer = $customer;
        $this->reward = $reward;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Parabéns! Você resgatou um prêmio! - FIDELITA APP',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.reward-redeemed',
            with: [
                "customer" => $this->customer,
                "reward" => $this->reward
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
