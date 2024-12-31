<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Session;

#[Title('Success - FitZone')]
class SuccessPage extends Component
{
    #[Url]
    public $session_id;

    public function render()
    {
        $latest_order = Order::with('address')->where('user_id', auth()->user()->id)->latest()->first();

        if (!auth()->check()) {
            dd('User is not authenticated');
        }

        return view('livewire.success-page', [
            'order' => $latest_order,
        ]);
    }
}
