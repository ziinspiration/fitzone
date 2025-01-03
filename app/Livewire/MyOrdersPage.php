<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Orders - Fitzone')]
class MyOrdersPage extends Component
{

    use WithPagination;

    public function render()
    {
        $my_orders = Order::where('user_id', auth()->id())
            ->latest()
            ->with('orderItems.product')
            ->paginate(5);

        return view('livewire.my-orders-page', [
            'orders' => $my_orders,
        ]);
    }
}