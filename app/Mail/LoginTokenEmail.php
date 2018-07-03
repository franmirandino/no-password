<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class LoginTokenEmail extends Mailable
{
    public $user;


    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {        
        return $this->markdown('emails.login-token')->with('link', $this->buildLink());
    }

    public function buildLink()
    {
        return route('login-token', [
            'email' => $this->user->email, 
            'token' => bcrypt($this->user->login_token)
        ]);
    }
}
