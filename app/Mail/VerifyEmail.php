<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Mail\Mailable;

class VerifyEmail extends Mailable
{
    public $user;
    public $otp;
    public $pantun;

    public function __construct(User $user, $otp, $pantun)
    {
        $this->user = $user;
        $this->otp = $otp;
        $this->pantun = $pantun;
    }

    public function build()
    {
        return $this->subject('Kode Verifikasi - Fitzone')
            ->view('emails.verify_email')
            ->with([
                'otp' => $this->otp,
                'pantun' => $this->pantun,
                'user' => $this->user,
            ]);
    }
}
