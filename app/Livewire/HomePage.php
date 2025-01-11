<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;


#[Title('Home Page - Fitzone')]
class HomePage extends Component
{
    public $showcaseProducts;
    public $newArrivalProducts;
    public $onSaleProducts;

    public function mount()
    {
        $this->showcaseProducts = Product::inRandomOrder()->take(4)->get();

        $this->newArrivalProducts = Product::latest('created_at')->take(8)->get();

        $this->onSaleProducts = Product::where('on_sale', 1)->get();
    }

    public function render()
    {
        $brands = Brand::where('is_active', 1)->get();
        $categories = Category::where('is_active', 1)->get();
        return view('livewire.home-page', [
            'brands' => $brands,
            'categories' => $categories,
            'showcaseProducts' => $this->showcaseProducts,
            'newArrivalProducts' => $this->newArrivalProducts,
            'onSaleProducts' => $this->onSaleProducts,
        ]);
    }
}