<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Title;
use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Size;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;

#[Title('Product Detail - Fitzone')]
class ProductDetailPage extends Component
{
    use LivewireAlert;
    public $slug;
    public $quantity = 1;
    public $product;
    public $newArrivals;
    public $selectedSizeFromAlpine;


    public function mount($slug)
    {
        $this->slug = $slug;
        $this->product = Product::where('slug', $slug)->firstOrFail();
        $this->newArrivals = Product::with('category')
            ->where('id', '!=', $this->product->id)
            ->latest()
            ->take(6)
            ->get();
    }

    public function render()
    {
        return view('livewire.product-detail-page', [
            'product' => Product::where('slug', $this->slug)->firstOrFail(),
            'newArrivals' => $this->newArrivals,
            'sizes' => Size::all(),
        ]);
    }
    public function increaseQty()
    {
        $this->quantity++;
    }

    public function showLoginAlert()
    {
        $this->alert('warning', 'Please log in first to add items to your basket', [
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true,
        ]);
        $this->dispatch('openModal', component: 'auth.login-modal');
    }


    #[On('size-selected')]
    public function updateSelectedSize($size)
    {
        $this->selectedSizeFromAlpine = $size;
    }



    public function addToCart($productId, $selectedSize)
    {
        Log::info('addToCart values', ['productId' => $productId, 'selectedSize' => $selectedSize]);

        if ($this->quantity <= 0) {
            $this->alert('error', 'Quantity must be greater than zero!', [
                'position' => 'bottom-end',
                'timer' => 3000,
                'toast' => 'true',
            ]);
            return;
        }

        if (!$selectedSize) {
            $this->alert('warning', 'Please select size!', [
                'position' => 'bottom-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            return;
        }

        $total_count = CartManagement::addItemToCart($productId, $this->quantity, $selectedSize);
        Log::info('dispatch-update-cart-count', ['total_count' => $total_count]);
        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);

        if ($total_count > 0) {
            $this->alert('success', 'Successfully added to cart!', [
                'position' => 'bottom-end',
                'timer' => 3000,
                'toast' => 'true',
            ]);
        } else {
            $this->alert('error', 'Failed to add item to cart!', [
                'position' => 'bottom-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }
    }

    public function decreaseQty()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }
}
