<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Title;
use App\Helpers\CartManagement;
use Jantinnerezo\LivewireAlert\LivewireAlert;

#[Title('Product Detail - FitZone')]
class ProductDetailPage extends Component
{
    use LivewireAlert;

    public $slug;
    public $quantity = 1;

    protected $casts = [
        'quantity' => 'integer',
    ];

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function render()
    {
        try {
            $product = Product::where('slug', $this->slug)->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, 'Product not found');
        }

        return view('livewire.product-detail-page', compact('product'));
    }

    public function increaseQty()
    {
        $this->quantity++;
    }

    public function decreaseQty()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        } else {
            $this->alert('warning', 'Quantity cannot be less than 1.');
        }
    }

    public function addToCart($product_id)
    {
        $total_count = CartManagement::addItemToCart($product_id);

        $this->dispatch('update-cart-count', ['total_count' => $total_count]);
        $this->alert('success', 'Item added to cart successfully!', [
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true,
        ]);
    }
}
