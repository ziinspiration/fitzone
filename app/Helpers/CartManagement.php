<?php

namespace App\Helpers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Livewire\Attributes\Session;
use Illuminate\Support\Facades\Auth;

class CartManagement
{
    public static function addItemToCart($product_id, $quantity)
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $existing_item = $cart->items()->where('product_id', $product_id)->first();

        if ($existing_item) {
            $existing_item->quantity += $quantity;
            $existing_item->total_price = $existing_item->quantity * $existing_item->unit_price;
            $existing_item->save();
        } else {
            $product = Product::find($product_id);
            if ($product) {
                $cart->items()->create([
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                    'unit_price' => $product->price,
                    'total_price' => $product->price * $quantity,
                    'selected' => false,
                ]);
            }
        }

        return $cart->items->count();
    }

    public static function getCartItemsFromDb()
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        return $cart ? $cart->items()->with('product')->get() : collect();
    }

    public static function getSelectedItemsFromDb()
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        if ($cart) {
            return $cart->items()->where('selected', true)->pluck('product_id')->toArray();
        }
        return [];
    }

    public static function addSelectedItem($product_id)
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        if ($cart) {
            $item = $cart->items()->where('product_id', $product_id)->first();
            if ($item) {
                $item->selected = true;
                $item->save();
                $selected_items = session()->get('selected_items', []);
                if (!in_array($product_id, $selected_items)) {
                    $selected_items[] = $product_id;
                    session()->put('selected_items', $selected_items);
                }
            }
        }
    }

    public static function removeSelectedItem($product_id)
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        if ($cart) {
            $item = $cart->items()->where('product_id', $product_id)->first();
            if ($item) {
                $item->selected = false;
                $item->save();
                $selected_items = session()->get('selected_items', []);
                $selected_items = array_diff($selected_items, [$product_id]);
                session()->put('selected_items', $selected_items);
            }
        }
    }

    public static function calculateGrandTotal($cart_items)
    {
        return collect($cart_items)->sum('total_price');
    }

    public static function removeCartItem($product_id)
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        if ($cart) {
            $cart->items()->where('product_id', $product_id)->delete();
        }

        return $cart ? $cart->items : [];
    }

    public static function incrementQuantity($product_id)
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        if ($cart) {
            $item = $cart->items()->where('product_id', $product_id)->first();
            if ($item) {
                $item->quantity++;
                $item->total_price = $item->quantity * $item->unit_price;
                $item->save();
            }
        }

        return $cart ? $cart->items : [];
    }

    public static function decrementQuantity($product_id)
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        if ($cart) {
            $item = $cart->items()->where('product_id', $product_id)->first();
            if ($item && $item->quantity > 1) {
                $item->quantity--;
                $item->total_price = $item->quantity * $item->unit_price;
                $item->save();
            }
        }

        return $cart ? $cart->items : [];
    }

    public static function clearCart()
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        if ($cart) {
            $cart->items()->delete();
            $cart->delete();
        }
    }

    public static function getSelectedItems()
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        if (!$cart) {
            return collect();
        }

        return $cart->items()
            ->where('selected', true)
            ->with('product')
            ->get();
    }

    public static function prepareCheckout()
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        if (!$cart) {
            return false;
        }

        $selected_items = $cart->items()
            ->where('selected', true)
            ->with('product')
            ->get();

        if ($selected_items->isEmpty()) {
            return false;
        }

        $subtotal = $selected_items->sum('total_price');
        $tax = $subtotal * 0.1;

        session([
            'checkout_items' => $selected_items->pluck('product_id')->toArray(),
            'checkout_subtotal' => $subtotal,
            'checkout_tax' => $tax
        ]);

        return true;
    }
    public static function getSelectedItemsForCheckout()
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        if (!$cart) {
            return collect();
        }

        $checkout_items = session()->get('checkout_items', []);
        return $cart->items()
            ->whereIn('product_id', $checkout_items)
            ->with('product')
            ->get();
    }

    public static function clearSelectedItems()
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        if ($cart) {
            $cart->items()->where('selected', true)->delete();
            if ($cart->items()->count() === 0) {
                $cart->delete();
            }
        }

        session()->forget(['selected_items', 'checkout_items', 'checkout_subtotal', 'checkout_tax']);
    }
}