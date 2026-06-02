<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    // 1. Deklarasikan variabel publik agar otomatis bisa dibaca oleh file Blade email
    public $otp;

    /**
     * Create a new message instance.
     * * @param string|int $otp
     */
    public function __construct($otp)
    {
        // 2. Masukkan kiriman kode OTP dari controller ke dalam variabel class
        $this->otp = $otp;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            // 3. Ubah subjek email agar lebih profesional dilihat oleh user
            subject: 'Kode Verifikasi OTP - Rektor Kost',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            // 4. Arahkan ke file blade template email yang akan dibuat (contoh: resources/views/emails/otp.blade.php)
            view: 'emails.otp',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}