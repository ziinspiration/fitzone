<?php

namespace App\Livewire;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use Livewire\Attributes\Title;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function downloadPDF()
    {
        $order = Order::with('orderItems.product', 'address')->where('id', $this->order_id)->first();
        $pdf = PDF::loadView('pdf.order-detail', [
            'order' => $order,
            'address' => $order->address
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $order->order_number . '.pdf');
    }
}
