<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

#[Title('Sign In - Fitzone')]

class LoginPage extends Component
{
    public $email;
    public $password;
    public $remember = false;
    public $recaptchaResponse = '';

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function render()
    {
        return view('livewire.auth.login-page', [
            'isAuthenticated' => Auth::check()
        ]);
    }

    public function mount()
    {
        $this->listeners = ['recaptchaResponse' => 'updatedRecaptchaResponse'];
    }

    public function updatedRecaptchaResponse($value)
    {
        Log::info('reCAPTCHA Response Updated:', [$value]);
        $this->recaptchaResponse = $value;
        Log::info('reCAPTCHA Response Updated after assign:', [$this->recaptchaResponse]);
    }

    public function signin()
    {
        Log::info('Recaptcha Value before Validate:', [$this->recaptchaResponse]);

        $this->validate();

        $secretKey = '6Lfl1JsqAAAAAMtbt6uYSErqChjjS5bVEmz4POQI';

        $verifyResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secretKey,
            'response' => $this->recaptchaResponse,
        ]);

        Log::info('reCAPTCHA Verify Response Status:', [$verifyResponse->status()]);
        $recaptchaResult = $verifyResponse->json();
        Log::info('reCAPTCHA Verify Response:', [$recaptchaResult]);

        if (!$recaptchaResult['success']) {
            session()->flash('error', 'reCAPTCHA verification failed. Please try again.');
            return;
        }

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();
            $user = Auth::user();

            if (!$user->is_verified) {
                Auth::logout();
                session()->flash('error', 'Your account has not been verified. Please verify your account first.');
                return;
            }

            session()->flash('success', 'You have successfully logged in!');

            if ($user->role_id == 1) {
                return redirect()->intended('/admin');
            } else {
                return redirect()->intended('/');
            }
        }

        session()->flash('error', 'Invalid email or password.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $cookie = cookie('remember_token', '', -1);

        return redirect('/')->with('success', 'You have successfully logged out.')->withCookie($cookie);
    }
}
