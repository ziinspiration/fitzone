<?php

namespace App\Livewire;

use App\Models\Brand;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Home Page - Fitzone')]
class HomePage extends Component
{
    public function render()
    {
        $brands = Brand::where('is_active', 1)->get();
        return view('livewire.home-page', [
            'brands' => $brands
        ]);
    }
}