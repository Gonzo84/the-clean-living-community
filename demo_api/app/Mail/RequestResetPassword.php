<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RequestResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * User instance.
     *
     */
    public $user;

    /**
     * Create a new message instance.
     * @param $user User
     * @return void
     */
    public function __construct(User $user)
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
        return $this->markdown(
            'mail.RequestResetPassword',
            ['resetPasswordUrl' => env('APP_DOMAIN') . '/reset-password/' . $this->user->reset_password_token]
        );
    }
}
