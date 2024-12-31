<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

#[Title('Reset Password')]
class ResetPasswordPage extends Component
{
    public $token;
    #[Url]
    public $email;
    public $password;
    public $password_confirmation;
    public $error;

    public function mount($token)
    {
        $this->token = $token;
        if (empty($this->email)) {
            $email = $this->getEmailFromToken($token);
            if ($email) {
                $this->email = $email;
            }
        }
    }

    protected function getEmailFromToken($token)
    {
        $tokenData = DB::table('password_reset_tokens')
            ->where('token', Hash::make($token))
            ->first();
            
        return $tokenData ? $tokenData->email : null;
    }

    public function save()
    {
        $this->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
            ]
        ], [
            'password.regex' => 'Password harus mengandung minimal 1 huruf besar, 1 huruf kecil, dan 1 angka'
        ]);

        try {
            $status = Password::reset(
                [
                    'email' => $this->email,
                    'password' => $this->password,
                    'password_confirmation' => $this->password_confirmation,
                    'token' => $this->token
                ],
                function (User $user, string $password) {
                    $user->forceFill([
                        'password' => Hash::make($password),
                        'remember_token' => Str::random(60)
                    ])->save();

                    event(new PasswordReset($user));
                }
            );

            if ($status === Password::PASSWORD_RESET) {
                // Dispatch event untuk SweetAlert
                $this->dispatch('success', [
                    'message' => 'Password berhasil direset!'
                ]);
            } else {
                $this->dispatch('error', [
                    'message' => trans($status)
                ]);
            }
        } catch (\Exception $e) {
            $this->dispatch('error', [
                'message' => "Terjadi kesalahan saat mereset password. " . $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.auth.reset-password-page');
    }
}