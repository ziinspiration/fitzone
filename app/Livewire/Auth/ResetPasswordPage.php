<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

#[Title('Reset Password - Fitzone')]
class ResetPasswordPage extends Component
{
    public $token;
    public $email;
    public $password;
    public $password_confirmation;

    public function mount(Request $request)
    {
        $this->token = $request->query('token');
        $this->email = $request->query('email');

        $tokenData = DB::table('password_reset_tokens')
            ->where('email', $this->email)
            ->where('token', $this->token)
            ->first();

        if (!$tokenData) {
            session()->flash('error', 'The reset token is invalid or has expired.');
            return redirect()->route('forgot-password');
        }

        $tokenCreatedAt = Carbon::parse($tokenData->created_at);
        if ($tokenCreatedAt->diffInHours(now()) > 1) {
            DB::table('password_reset_tokens')
                ->where('email', $this->email)
                ->delete();

            session()->flash('error', 'The reset token has expired. Please request a new reset link.');
            return redirect()->route('forgot-password');
        }
    }

    public function render()
    {
        return view('livewire.auth.reset-password-page');
    }

    public function updatePassword()
    {
        $this->validate([
            'email' => 'required|email|exists:users,email',
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&]/',
            ]
        ], [
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.regex' => 'Password must contain lowercase letters, uppercase letters, numbers, and symbols.',
        ]);

        $user = User::where('email', $this->email)->first();

        if (!$user) {
            session()->flash('error', 'Account not found.');
            return back();
        }

        if (Hash::check($this->password, $user->password)) {
            session()->flash('error', 'The new password cannot be the same as the old password.');
            return back();
        }

        $user->password = Hash::make($this->password);
        $user->save();

        DB::table('password_reset_tokens')
            ->where('email', $this->email)
            ->delete();

        session()->flash('success', 'Your password has been successfully updated. Please log in with your new password.');

        return redirect()->to('/signin');
    }
}