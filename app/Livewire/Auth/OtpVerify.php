<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use App\Mail\VerifyEmail;
use App\Mail\VerifySuccess;
use App\Mail\VerifyRegistered;
use App\Helpers\OtpHelper;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Log;

#[Title('OTP Verification - Fitzone')]
class OtpVerify extends Component
{
    public $otp;
    public $email;

    public function mount()
    {
        $this->email = Session::get('verification_email');
    }

    public function render()
    {
        return view('livewire.auth.otpverify-page');
    }

    private function generateOtp()
    {
        return OtpHelper::generateOtp();
    }

    public function verifyOtp()
    {
        Log::info('verifyOtp triggered', ['email' => $this->email, 'otp' => $this->otp]);

        if (!$this->otp || !$this->email) {
            Log::info('Invalid OTP or email');
            return redirect()->route('verification')
                ->with('error', 'OTP or email is missing.');
        }

        Log::info('Verifying OTP', ['email' => $this->email, 'otp' => $this->otp]);

        $user = User::where('email', $this->email)
            ->where('verification_code', $this->otp)
            ->first();

        if (!$user) {
            Log::info('Invalid OTP or email', ['email' => $this->email, 'otp' => $this->otp]);
            return redirect()->route('verification')
                ->with('error', 'The OTP code is invalid.');
        }

        Log::info('User found, verifying...', ['user' => $user]);

        $user->is_verified = true;
        $user->verification_code = null;
        $user->save();

        Session::forget('verification_email');
        Session::forget('is_new_user');

        Mail::to($user->email)->send(new VerifySuccess($user));

        return redirect()->to('signin')
            ->with('success', 'Your account has been successfully verified. Please log in.');
    }

    public function resendOtp()
    {
        if (!$this->email) {
            session()->flash('error', 'Verification session has expired. Please try again.');
            return redirect()->route('signup');
        }

        $user = User::where('email', $this->email)->first();

        if (!$user) {
            session()->flash('error', 'Email not found. Please sign up first.');
            return redirect()->route('signup');
        }

        $newOtp = OtpHelper::generateOtp();
        $user->verification_code = $newOtp;
        $user->save();

        $isNewUser = Session::get('is_new_user', false);

        if ($isNewUser) {
            Mail::to($user->email)->send(new VerifyEmail(
                $user,
                $newOtp,
                "This is your new OTP code. Please use it to verify your account."
            ));

            session()->flash('success', 'A new OTP code has been sent to your email.');
            return redirect()->route('verification');
        } else {
            $verificationLink = route('verify.email', ['otp' => $newOtp, 'email' => $user->email]);
            Mail::to($user->email)->send(new VerifyRegistered($user, $verificationLink));

            session()->flash('success', 'A new verification link has been sent to your email.');
            return redirect()->route('login');
        }
    }
}