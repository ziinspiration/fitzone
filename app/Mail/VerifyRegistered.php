<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Mail\Mailable;

class VerifyRegistered extends Mailable
{
    public $user;
    public $verificationLink;

    public function __construct(User $user, $verificationLink)
    {
        $this->user = $user;
        $this->verificationLink = $verificationLink;
    }

    public function build()
    {
        return $this->subject('Verifikasi Akun - Fitzone')
            ->view('mail.register.verify_registered')
            ->with([
                'user' => $this->user,
                'verificationLink' => $this->verificationLink,
            ]);
    }
}