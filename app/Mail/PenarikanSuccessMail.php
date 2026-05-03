<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PenarikanSuccessMail extends Mailable
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
            subject: 'Penarikan Saldo Berhasil - Bukti Transfer',
        );
    }

    public function content(): Content
    {
        return new Content(
            // Pastikan mengarah ke file desain penarikan_success
            view: 'emails.penarikan_success',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}