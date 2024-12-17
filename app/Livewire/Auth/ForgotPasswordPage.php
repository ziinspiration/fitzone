<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Mail\ForgotPass;

#[Title('Forgot Password - Fitzone')]

class ForgotPasswordPage extends Component
{
    public $email = '';

    public function render()
    {
        return view('livewire.auth.forgot-password-page');
    }

    public function sendResetLink()
    {
        $this->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'No account found with this email address.'
        ]);

        $user = User::where('email', $this->email)->first();

        if (!$user) {
            session()->flash('error', 'No account found with this email.');
            return back();
        }

        DB::table('password_reset_tokens')
            ->where('email', $this->email)
            ->delete();

        $token = Str::random(60);
        DB::table('password_reset_tokens')->insert([
            'email' => $this->email,
            'token' => $token,
            'created_at' => now()
        ]);

        $resetUrl = url('/new-password?token=' . $token . '&email=' . urlencode($this->email));

        try {
            Mail::to($this->email)->send(new ForgotPass($resetUrl, $user));

            session()->flash('status', 'We have sent a password reset link to your email.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to send reset link. Please try again.');
        }
    }
}