<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChangeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public string $currentEmail;
    public string $newEmail;

    /**
     * Create a new message instance.
     *
     * @param string $currentEmail
     * @param string $newEmail
     */
    public function __construct(string $currentEmail, string $newEmail)
    {
        $this->currentEmail = $currentEmail;
        $this->newEmail = $newEmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.change-email');
    }
}
