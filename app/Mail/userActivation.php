<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class userActivation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $user;
    public $token;

    public function __construct(\Cartalyst\Sentinel\Users\EloquentUser $user, \Cartalyst\Sentinel\Activations\EloquentActivation $token)
    {
        $this->user = $user;
        $this->token = $token->code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.activation');
    }
}
