<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Http;

#[Title('Sign In Page - Fitzone')]

class LoginPage extends Component
{
    public function render()
    {
        return view('livewire.auth.login-page', [
            'isAuthenticated' => Auth::check()
        ]);
    }

    public function login(Request $request)
    {
        $recaptchaResponse = $request->input('g-recaptcha-response');

        if (!$recaptchaResponse) {
            session()->flash('error', 'Harap lengkapi reCAPTCHA.');
            return redirect()->back()->withInput($request->only('email'));
        }

        $secretKey = config('services.recaptha.secret_key', '6Lfb0psqAAAAACf2ybsKlQv1R_hT161JdC5ICN8f');

        $verifyResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secretKey,
            'response' => $recaptchaResponse,
            'remoteip' => $request->ip()
        ]);

        $verifyResponse = Http::asForm()
            ->withOptions(['verify' => false])  // Disable SSL verification
            ->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secretKey,
                'response' => $recaptchaResponse,
                'remoteip' => $request->ip()
            ]);


        $recaptchaResult = $verifyResponse->json();

        if (!$recaptchaResult['success']) {
            session()->flash('error', 'Verifikasi reCAPTCHA gagal. Silakan coba lagi.');
            return redirect()->back()->withInput($request->only('email'));
        }

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            if (!$user->is_verified) {
                Auth::logout();
                session()->flash('error', 'Akun Anda belum diverifikasi. Harap verifikasi akun terlebih dahulu.');
                return redirect()->back()->withInput($request->only('email'));
            }

            session()->flash('success', 'Anda berhasil login!');
            return redirect()->intended('/');
        }

        session()->flash('error', 'Email atau password tidak valid.');
        return redirect()->back()->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $cookie = cookie('remember_token', '', -1);

        return redirect('/')->with('success', 'Anda berhasil logout.')->withCookie($cookie);
    }
}
