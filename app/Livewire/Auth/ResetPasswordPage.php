<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;

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
            session()->flash('error', 'Invalid or expired reset token.');
            return redirect()->route('forgot-password');
        }

        $tokenCreatedAt = Carbon::parse($tokenData->created_at);
        if ($tokenCreatedAt->diffInHours(now()) > 1) {
            DB::table('password_reset_tokens')
                ->where('email', $this->email)
                ->delete();

            session()->flash('error', 'Reset token has expired. Please request a new reset link.');
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
            'password' => 'required|confirmed|min:8'
        ], [
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.'
        ]);

        $user = User::where('email', $this->email)->first();

        if (!$user) {
            session()->flash('error', 'Account not found.');
            return back();
        }

        $tokenData = DB::table('password_reset_tokens')
            ->where('email', $this->email)
            ->where('token', $this->token)
            ->first();

        if (!$tokenData) {
            session()->flash('error', 'Invalid or expired token.');
            return redirect()->route('forgot-password');
        }

        $user->password = Hash::make($this->password);
        $user->save();

        DB::table('password_reset_tokens')
            ->where('email', $this->email)
            ->delete();

        return redirect()->route('login')->with('status', 'Your password has been successfully updated. Please login with your new password.');
    }
}