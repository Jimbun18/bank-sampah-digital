<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RequestJemputMail extends Mailable
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
            subject: 'Konfirmasi Request Jemput Sampah',
        );
    }

    public function content(): Content
    {
        return new Content(
            // NAH, INI DIA PENYEBABNYA! 
            // Sebelumnya tertulis 'view.name', sekarang kita arahkan ke file desain kita
            view: 'emails.request_jemput', 
        );
    }

    public function attachments(): array
    {
        return [];
    }
}