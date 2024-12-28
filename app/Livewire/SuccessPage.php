<?php

namespace App\Livewire;

use App\Models\Order;
use Illuminate\Contracts\Session\Session;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Title('Success - FitZone')]
class SuccessPage extends Component
{
    #[Url]
    public $session_id;

    public function render()
    {
        $latest_order = Order::with('address')->where('user_id', auth()->user()->id)->latest()->first();

        if ($this->session_id) {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $session_info = Session::retrieve($this->session_id);

            dd($session_info);
        }

        return view('livewire.success-page', [
            'order' => $latest_order,
        ]);
    }
}
