<?php

namespace App\Livewire;

use Livewire\Component;
use App\Helpers\CartManagement;
use Livewire\Attributes\Title;

#[Title('Cartshop - Fitzone')]
class CartPage extends Component
{
    public $cart_items = [];
    public $selected_items = [];
    public $grand_total = 0;
    public $tax_amount = 0;
    public $select_all = false;

    public function mount()
    {
        $this->cart_items = CartManagement::getCartItemsFromDb();
        $this->selected_items = CartManagement::getSelectedItemsFromDb();

        if (empty($this->selected_items)) {
            $this->grand_total = 0;
            $this->tax_amount = 0;
        } else {
            $this->updateTotal();
        }
    }

    public function selectItem($product_id, $isSelected)
    {
        if ($isSelected) {
            CartManagement::addSelectedItem($product_id);
        } else {
            CartManagement::removeSelectedItem($product_id);
        }

        $this->selected_items = CartManagement::getSelectedItemsFromDb();
        $this->updateTotal();
    }

    public function selectAll()
    {
        $this->select_all = !$this->select_all;

        if ($this->select_all) {
            foreach ($this->cart_items as $item) {
                CartManagement::addSelectedItem($item->product_id);
            }
        } else {
            foreach ($this->cart_items as $item) {
                CartManagement::removeSelectedItem($item->product_id);
            }
        }

        $this->selected_items = CartManagement::getSelectedItemsFromDb();
        $this->updateTotal();
    }

    public function increaseQty($product_id)
    {
        $this->cart_items = CartManagement::incrementQuantity($product_id);
        $this->updateItemTotal($product_id);
    }

    public function decreaseQty($product_id)
    {
        $this->cart_items = CartManagement::decrementQuantity($product_id);
        $this->updateItemTotal($product_id);
    }

    public function removeItem($product_id)
    {
        $this->cart_items = CartManagement::removeCartItem($product_id);
        $this->selected_items = CartManagement::getSelectedItemsFromDb();

        if (empty($this->selected_items)) {
            $this->grand_total = 0;
            $this->tax_amount = 0;
        } else {
            $this->updateTotal();
        }
    }

    private function updateItemTotal($product_id)
    {
        $item = collect($this->cart_items)->firstWhere('product_id', $product_id);
        if ($item) {
            $item->total_price = $item->quantity * $item->unit_price;
        }
        $this->updateTotal();
    }

    private function updateTotal()
    {
        if (empty($this->selected_items)) {
            $this->grand_total = 0;
            $this->tax_amount = 0;
            return;
        }

        $selected_items_data = collect($this->cart_items)->filter(function ($item) {
            return in_array($item->product_id, $this->selected_items);
        });

        $this->grand_total = $selected_items_data->sum('total_price');
        $this->tax_amount = $this->grand_total * 0.1;
    }

    public function proceedToCheckout()
    {
        if (CartManagement::prepareCheckout()) {
            return $this->redirect(route('checkout.page'));
        }

        session()->flash('error', 'Please select at least one item to checkout');
        return null;
    }

    public function render()
    {
        return view('livewire.cart-page');
    }
}