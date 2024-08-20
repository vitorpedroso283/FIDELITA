<?php

namespace App\Mail;

use App\Models\Customer;
use App\Models\Reward;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MaxPointsRedeemableMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $reward;

    /**
     * Cria uma nova instância da classe.
     *
     * @param \App\Models\Customer $customer
     * @return void
     */
    public function __construct(Customer $customer, Reward $reward)
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
            subject: 'Você possui pontos o suficiente para resgatar o prêmio máximo na Fidelita!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.max-points-redeemable',
            with: [
                "customer" => $this->customer,
                "reward" => $this->customer
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
