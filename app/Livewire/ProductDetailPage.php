<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Title;
use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use Jantinnerezo\LivewireAlert\LivewireAlert;


#[Title('Product Detail - Fitzone')]
class ProductDetailPage extends Component
{
    use LivewireAlert;
    public $slug;
    public $quantity = 1;
    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function render()
    {
        return view('livewire.product-detail-page', [
            'product' => Product::where('slug', $this->slug)->firstOrFail(),
        ]);
    }

    public function increaseQty()
    {
        $this->quantity++;
    }

    public function addToCart($product_id)
    {
        if ($this->quantity <= 0) {
            $this->alert('error', 'Quantity must be greater than zero!', [
                'position' => 'bottom-end',
                'timer' => 3000,
                'toast' => 'true',
            ]);
            return;
        }

        $total_count = CartManagement::addItemToCart($product_id, $this->quantity);

        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);

        $this->alert('success', 'Successfully added to cart!', [
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => 'true',
        ]);
    }

    public function decreaseQty()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }
}