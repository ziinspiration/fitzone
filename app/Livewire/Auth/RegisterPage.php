<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use App\Mail\VerifyEmail;
use App\Mail\VerifySuccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class RegisterPage extends Component
{
    public function render()
    {
        return view('livewire.auth.register-page');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => [
                'required',
                'string',
                'confirmed',
                'min:8',
                'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/',
            ],
        ], [
            'email.unique' => 'Email sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password harus minimal 8 karakter.',
            'password.regex' => 'Password harus mengandung huruf, angka, dan karakter spesial.',
        ]);

        try {
            $verificationCode = 'FIT-' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

            $user = User::create([
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'] ?? '',
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'is_verified' => false,
                'verification_code' => $verificationCode,
            ]);

            Session::put('verification_email', $user->email);

            $pantun = [
                "Lari pagi tubuh sehat,\nLihat langit cerah memancar.\nSemangat terus, jangan patah,\nImpian besar pasti tercapai!",
                "Lari pagi tubuh sehat,\nSemangat selalu jangan ragu.\nOlahraga jadikan kebiasaan,\nKesehatanmu pasti terjaga!",
                "Di lapangan main sepak bola,\nTak pernah lelah, terus berjuang.\nKerja keras pasti ada hasil,\nDengan semangat, sukses datang.",
            ];

            $randomPantun = $pantun[array_rand($pantun)];

            Mail::to($user->email)->send(new VerifyEmail($user, $verificationCode, $randomPantun));

            return redirect()->route('verification')->with('success', 'Pendaftaran berhasil. Silakan periksa email Anda untuk kode verifikasi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat pendaftaran: ' . $e->getMessage())->withInput();
        }
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $nameParts = explode(' ', $googleUser->getName());
            $firstName = $nameParts[0];
            $lastName = isset($nameParts[1]) ? $nameParts[1] : '';

            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                return redirect()->route('register')->with('googleError', 'Email sudah terdaftar.');
            }

            $user = User::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $googleUser->getEmail(),
                'password' => bcrypt(Str::random(16)),
                'is_verified' => true,
                'avatar' => $googleUser->getAvatar(),
            ]);

            return redirect()->route('login')->with('googleSuccess', 'Registrasi dengan akun Google berhasil.');
        } catch (\Exception $e) {
            return redirect()->route('register')->with('googleError', 'Terjadi kesalahan saat registrasi dengan Google: ' . $e->getMessage());
        }
    }

    public function showVerificationPage()
    {
        $email = Session::get('verification_email');
        return view('livewire.auth.otpverify-page', compact('email'));
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|string|size:8',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && $user->verification_code === $request->otp) {
            $user->is_verified = true;
            $user->verification_code = null;
            $user->save();

            Session::forget('verification_email');

            Mail::to($user->email)->send(new VerifySuccess($user));

            return redirect()->route('login')->with('success2', 'Akun Anda berhasil diverifikasi. Silakan masuk.');
        } else {
            return redirect()->back()->with('error', 'Kode OTP salah atau tidak valid.');
        }
    }

    public function resendOtp(Request $request)
    {
        $email = Session::get('verification_email');

        if (!$email) {
            return redirect()->route('signup')->with('error', 'Sesi verifikasi telah kedaluwarsa.');
        }

        $user = User::where('email', $email)->first();

        if ($user) {
            $newOtp = 'FIT-' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
            $user->verification_code = $newOtp;
            $user->save();

            $pantun = "Semangat terus, ini kode verifikasi baru Anda: " . $newOtp;

            Mail::to($user->email)->send(new VerifyEmail($user, $newOtp, $pantun));

            return redirect()->route('verification')->with('success', 'Kode OTP baru telah dikirim ke email Anda.');
        }

        return redirect()->route('signup')->with('error', 'Email tidak ditemukan.');
    }
}
