<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\Attributes\Title;

#[Title('Success - FitZone')]
class SuccessPage extends Component
{
    #[Url]
    public $session_id;

    public function render()
    {
        if (!auth()->check()) {
            abort(403, 'User is not authenticated');
        }

        $latest_order = Order::with('address')->where('user_id', auth()->user()->id)->latest()->first();

        if (!$latest_order) {
            abort(404, 'Order not found');
        }

        return view('livewire.success-page', [
            'order' => $latest_order,
        ]);
    }
}
