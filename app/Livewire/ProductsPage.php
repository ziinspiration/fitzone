<?php

namespace App\Livewire;

use App\Livewire\Partials\Navbar;
use App\Models\Brand;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Helpers\CartManagement;

#[Title('Products - Fitzone')]
class ProductsPage extends Component
{
    use LivewireAlert;
    use WithPagination;

    #[Url]
    public $selected_categories = [];

    #[Url]
    public $selected_brands = [];

    #[Url]
    public $featured = [];

    #[Url]
    public $on_sale = [];

    public $price_range = 5000;

    public function addToCart($product_id)
    {
        $total_count = CartManagement::addItemToCart($product_id, 1);
        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);
        $this->alert('success', 'Successfully added to cart!', [ // Memperbaiki typo di sini
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true, // Mengubah 'true' menjadi boolean
        ]);
    }

    public function render()
    {
        $productQuery = Product::query()->where('is_active', 1);

        if ($this->search) {
            $productQuery->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->selected_categories)) {
            $productQuery->whereIn('category_id', $this->selected_categories);
        }

        if (!empty($this->selected_brands)) {
            $productQuery->whereIn('brand_id', $this->selected_brands);
        }

        if ($this->featured) {
            $productQuery->where('is_featured', 1);
        }

        if ($this->on_sale) {
            $productQuery->where('on_sale', 1);
        }

        $productQuery->when($this->sort === 'latest', fn($q) => $q->latest())
            ->when($this->sort === 'price_low', fn($q) => $q->orderBy('price'))
            ->when($this->sort === 'price_high', fn($q) => $q->orderByDesc('price'))
            ->when($this->sort === 'name', fn($q) => $q->orderBy('name'));

        return view('livewire.products-page', [
            'products' => $productQuery->paginate(9),
            'brands' => Brand::where('is_active', 1)->get(['id', 'name', 'slug']),
            'categories' => Category::where('is_active', 1)->get(['id', 'name', 'slug']),
        ]);
    }
}
