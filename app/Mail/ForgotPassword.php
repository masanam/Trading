<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    protected $email, $pass;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $pass)
    {
        $this->email = $email;
        $this->pass = $pass;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noreply@volantech.io')
                    ->view('mail.forgot-password.forgot-password')
                    ->with([
                        'email' => $this->email,
                        'password' => $this->pass,
                    ]);
    }
}