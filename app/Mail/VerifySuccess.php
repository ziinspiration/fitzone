<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Mail\Mailable;

class VerifySuccess extends Mailable
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Verifikasi Akun - Fitzone')
            ->view('emails.verify_success')
            ->with([
                'user' => $this->user,
            ]);
    }
}
