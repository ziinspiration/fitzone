<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;

#[Title('My Account - FitZone')]
class MyAccountPage extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $name;
    public $email;
    public $phone;
    public $avatar;
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
    }

    public function updateProfile()
    {
        $validated = $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'required|numeric',
            'avatar' => 'nullable|image|max:1024',
        ]);

        $user = Auth::user();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];

        if ($this->avatar) {
            $user->avatar = $this->avatar->store('avatars', 'public');
        }

        $user->save();

        $this->alert('success', 'Profile updated successfully!');
    }

    public function updatePassword()
    {
        $validated = $this->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($validated['new_password']);
        $user->save();

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        $this->alert('success', 'Password updated successfully!');
    }

    public function render()
    {
        return view('livewire.my-account-page');
    }
}