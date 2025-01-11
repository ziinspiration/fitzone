<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use App\Mail\VerifyEmail;
use App\Mail\VerifySuccess;
use App\Mail\VerifyRegistered;
use App\Helpers\OtpHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Livewire\Attributes\Title;

#[Title('Sign Up - Fitzone')]
class RegisterPage extends Component
{
    public $first_name, $last_name, $email, $password, $password_confirmation;

    public function render()
    {
        return view('livewire.auth.register-page');
    }

    public function verifyEmailFromLink($otp, $email)
    {
        try {
            $user = User::where('email', $email)
                ->where('verification_code', $otp)
                ->where('is_verified', 0)
                ->first();

            if (!$user) {
                return redirect()->route('login')
                    ->with('error', 'The verification link is invalid or has expired.');
            }

            $user->is_verified = 1;
            $user->verification_code = null;
            $user->save();

            Mail::to($user->email)->send(new VerifySuccess($user));

            return redirect()->route('login')
                ->with('success', 'Congratulations! Your account has been verified. Please log in.');
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'An error occurred during verification: ' . $e->getMessage());
        }
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/',
            ],
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'The email you entered is already registered.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.regex' => 'Password must contain letters, numbers, and special characters.',
        ];
    }

    public function register()
    {
        try {
            $validatedData = $this->validate();

            $existingUser = User::where('email', $this->email)->first();

            if ($existingUser && !$existingUser->is_verified) {
                $newOtp = OtpHelper::generateOtp();
                $existingUser->verification_code = $newOtp;
                $existingUser->save();

                $verificationLink = route('verify.email.link', [
                    'otp' => $newOtp,
                    'email' => $existingUser->email
                ]);

                Mail::to($existingUser->email)->send(new VerifyRegistered($existingUser, $verificationLink));

                return redirect()->route('verification')
                    ->with('success', 'A verification email has been sent. Please check your email to verify your account.');
            }

            if ($existingUser && $existingUser->is_verified) {
                return redirect()->route('login')
                    ->with('success', 'Account already verified, please log in.');
            }

            $newOtp = OtpHelper::generateOtp();
            $user = User::create([
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'] ?? '',
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'is_verified' => false,
                'verification_code' => $newOtp,
                'role_id' => 2,
            ]);

            Session::put('verification_email', $user->email);
            Session::put('first_name', $user->first_name);
            Session::put('last_name', $user->last_name);
            Session::put('is_new_user', true);

            $pantun = [
                "Lari pagi tubuh sehat,\nLihat langit cerah memancar.\nSemangat terus, jangan patah,\nImpian besar pasti tercapai!",
                "Lari pagi tubuh sehat,\nSemangat selalu jangan ragu.\nOlahraga jadikan kebiasaan,\nKesehatanmu pasti terjaga!",
                "Di lapangan main sepak bola,\nTak pernah lelah, terus berjuang.\nKerja keras pasti ada hasil,\nDengan semangat, sukses datang.",
            ];

            Mail::to($user->email)->send(new VerifyEmail(
                $user,
                $newOtp,
                $pantun[array_rand($pantun)]
            ));

            return redirect()->route('verification')
                ->with('success', 'Please enter the OTP code that has been sent to your email.');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }
}