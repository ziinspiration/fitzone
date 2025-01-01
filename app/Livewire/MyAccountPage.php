<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

#[Title('My Account - FitZone')]
class MyAccountPage extends Component
{
    use WithFileUploads;

    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $avatar;
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    public function mount()
    {
        $user = Auth::user();
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->phone = $user->phone;
    }

    public function updateProfile()
    {
        try {
            $this->validate([
                'first_name' => 'required|min:3',
                'last_name' => 'nullable|min:3',
                'avatar' => 'nullable|image|max:1024',
            ]);

            $user = Auth::user();
            $user->first_name = $this->first_name;
            $user->last_name = $this->last_name;

            Log::info('Avatar Object:', [$this->avatar]);

            if ($this->avatar) {
                Log::info('Disk Used:', [config('filesystems.default')]);
                Log::info('Before store:', [$this->avatar]);
                $user->avatar = $this->avatar->store('avatars', 'public');
                Log::info('After store:', [$user->avatar]);
            }


            $user->save();
            Log::info('Data User After Save:', [$user]);
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update profile. Please try again.');
            Log::error('Failed to update profile:', ['error' => $e->getMessage()]);
            $this->resetErrorBag();
            throw $e;
        }
    }


    public function updatePassword()
    {
        try {
            $this->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:8|confirmed',
            ]);

            $user = Auth::user();

            if (!Hash::check($this->current_password, $user->password)) {
                throw ValidationException::withMessages([
                    'current_password' => ['Current password does not match.'],
                ]);
            }
            if (Hash::check($this->new_password, $user->password)) {
                throw ValidationException::withMessages([
                    'new_password' => ['New password cannot be same as the current password.'],
                ]);
            }

            $user->password = Hash::make($this->new_password);
            $user->save();

            $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
            session()->flash('success', 'Password updated successfully!');
        } catch (ValidationException $e) {
            session()->flash('error', $e->getMessage());
            Log::error('Failed to update password:', ['error' => $e->getMessage()]);
            $this->resetErrorBag();
            throw $e;
        }
    }
    public function render()
    {
        return view('livewire.my-account-page');
    }
}