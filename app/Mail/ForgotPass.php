<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Mail\Mailable;

class ForgotPass extends Mailable
{
    public $resetUrl;
    public $user;

    public function __construct($resetUrl, User $user)
    {
        $this->resetUrl = $resetUrl;
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Reset Password - Fitzone')
            ->view('mail.login.reset_password');
    }
}