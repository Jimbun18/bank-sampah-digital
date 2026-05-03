<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SetorSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $data; // Pastikan tipe datanya array

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Struk Setoran Bank Sampah - Berhasil!',
        );
    }

    public function content(): Content
    {
        return new Content(
            // PASTIKAN INI MENGARAH KE SETOR SUCCESS, BUKAN REQUEST JEMPUT
            view: 'emails.setor_success', 
        );
    }
}