<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PenarikanRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pengajuan Penarikan Saldo Diproses',
        );
    }

    public function content(): Content
    {
        return new Content(
            // Pastikan mengarah ke file desain penarikan_request
            view: 'emails.penarikan_request',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}