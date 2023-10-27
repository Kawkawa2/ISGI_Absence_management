<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class loginMail extends Mailable
{
    use Queueable, SerializesModels;
    public $nom;
    public $sender;
    public $reciever;
    public $email;
    public $password;



    /**
     * Create a new message instance.
     */
    public function __construct($nom, $sender, $reciever, $email, $password)
    {
        $this->nom = $nom;
        $this->email = $email;
        $this->password = $password;
        $this->reciever = $reciever;
        $this->sender = $sender;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Login Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'email.loginMail',
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
