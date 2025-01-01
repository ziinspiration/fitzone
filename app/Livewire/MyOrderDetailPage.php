<?php

namespace App\Livewire;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use Livewire\Attributes\Title;
use Livewire\Component;


#[Title('Order Detail - Fitzone')]
class MyOrderDetailPage extends Component
{
    public $order_id;

    public function mount($order_id)
    {
        $this->order_id = $order_id;
    }

    public function render()
    {
        $order = Order::with('orderItems.product', 'address')->where('id', $this->order_id)->first();

        return view('livewire.my-order-detail-page', [
            'order_items' => $order->orderItems,
            'address' => $order->address,
            'order' => $order
        ]);
    }
}