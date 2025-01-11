<?php

namespace App\Livewire;

use Livewire\Component;
use App\Helpers\CartManagement;
use Livewire\Attributes\Title;
use App\Models\Cart;
use App\Models\Size;
use Illuminate\Support\Facades\Log;

#[Title('Cartshop - Fitzone')]
class CartPage extends Component
{
    public $cart_items = [];
    public $selected_items = [];
    public $grand_total = 0;
    public $tax_amount = 0;
    public $select_all = false;
    public $sizes = [];


    public function mount()
    {
        $this->cart_items = CartManagement::getCartItemsFromDb();
        $this->selected_items = CartManagement::getSelectedItemsFromDb();
        $this->sizes = Size::all();

        if (empty($this->selected_items)) {
            $this->grand_total = 0;
            $this->tax_amount = 0;
        } else {
            $this->updateTotal();
        }
    }

    public function selectItem($cart_item_id, $isSelected)
    {
        if ($isSelected) {
            CartManagement::addSelectedItem($cart_item_id);
        } else {
            CartManagement::removeSelectedItem($cart_item_id);
        }

        $this->selected_items = CartManagement::getSelectedItemsFromDb();
        $this->updateTotal();
    }

    public function selectAll()
    {
        $this->select_all = !$this->select_all;

        if ($this->select_all) {
            foreach ($this->cart_items as $item) {
                CartManagement::addSelectedItem($item->id);
            }
        } else {
            foreach ($this->cart_items as $item) {
                CartManagement::removeSelectedItem($item->id);
            }
        }

        $this->selected_items = CartManagement::getSelectedItemsFromDb();
        $this->updateTotal();
    }

    public function updateSize($cart_item_id, $new_size)
    {
        if (CartManagement::updateItemSize($cart_item_id, $new_size)) {
            $this->cart_items = CartManagement::getCartItemsFromDb();
            $this->updateTotal();
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Size updated successfully!'
            ]);
        }
    }

    public function increaseQty($cart_item_id)
    {
        $this->cart_items = CartManagement::incrementQuantity($cart_item_id);
        $this->updateItemTotal($cart_item_id);
    }

    public function decreaseQty($cart_item_id)
    {
        $this->cart_items = CartManagement::decrementQuantity($cart_item_id);
        $this->updateItemTotal($cart_item_id);
    }

    public function removeItem($cart_item_id)
    {
        $this->cart_items = CartManagement::removeCartItem($cart_item_id);
        $this->selected_items = CartManagement::getSelectedItemsFromDb();

        if (empty($this->selected_items)) {
            $this->grand_total = 0;
            $this->tax_amount = 0;
        } else {
            $this->updateTotal();
        }
    }

    private function updateItemTotal($cart_item_id)
    {
        $item = collect($this->cart_items)->firstWhere('id', $cart_item_id);
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
            return in_array($item->id, $this->selected_items);
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
        return view('livewire.cart-page', [
            'sizes' => $this->sizes,
        ]);
    }
}
