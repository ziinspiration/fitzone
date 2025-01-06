<?php

namespace App\Helpers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Livewire\Attributes\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartManagement
{
    public static function addItemToCart($product_id, $quantity, $size = null)
    {
        Log::info('addItemToCart called:', [
            'product_id' => $product_id,
            'quantity' => $quantity,
            'size' => $size,
            'user_id' => Auth::id(),
        ]);

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        if ($size === null) {
            $default_size = '36';
            $size = $default_size;
        }

        $existing_item = $cart->items()
            ->where('product_id', $product_id)
            ->where('size', $size)
            ->first();

        if ($existing_item) {
            Log::info('Existing item found:', $existing_item->toArray());
            $existing_item->quantity += $quantity;
            $existing_item->total_price = $existing_item->quantity * $existing_item->unit_price;
            $existing_item->save();
            Log::info('Existing item updated:', $existing_item->toArray());
        } else {
            $product = Product::find($product_id);
            if ($product) {
                $createdItem = $cart->items()->create([
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                    'unit_price' => $product->price,
                    'total_price' => $product->price * $quantity,
                    'size' => $size,
                    'selected' => false,
                ]);
                Log::info('New item created:', $createdItem->toArray());
            } else {
                Log::error('Product not found', ['product_id' => $product_id]);
                return 0;
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
            return $cart->items()->where('selected', true)->pluck('id')->toArray();
        }
        return [];
    }

    public static function addSelectedItem($cart_item_id)
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        if ($cart) {
            $item = $cart->items()->where('id', $cart_item_id)->first();
            if ($item) {
                $item->selected = true;
                $item->save();
                $selected_items = session()->get('selected_items', []);
                if (!in_array($cart_item_id, $selected_items)) {
                    $selected_items[] = $cart_item_id;
                    session()->put('selected_items', $selected_items);
                }
            }
        }
    }


    public static function removeSelectedItem($cart_item_id)
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        if ($cart) {
            $item = $cart->items()->where('id', $cart_item_id)->first();
            if ($item) {
                $item->selected = false;
                $item->save();
                $selected_items = session()->get('selected_items', []);
                $selected_items = array_diff($selected_items, [$cart_item_id]);
                session()->put('selected_items', $selected_items);
            }
        }
    }

    public static function calculateGrandTotal($cart_items)
    {
        return collect($cart_items)->sum('total_price');
    }

    public static function removeCartItem($cart_item_id)
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        if ($cart) {
            $cart->items()->where('id', $cart_item_id)->delete();
        }

        return $cart ? $cart->items : [];
    }

    public static function incrementQuantity($cart_item_id)
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        if ($cart) {
            $item = $cart->items()->where('id', $cart_item_id)->first();
            if ($item) {
                $item->quantity++;
                $item->total_price = $item->quantity * $item->unit_price;
                $item->save();
            }
        }

        return $cart ? $cart->items : [];
    }

    public static function decrementQuantity($cart_item_id)
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        if ($cart) {
            $item = $cart->items()->where('id', $cart_item_id)->first();
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
            'checkout_items' => $selected_items->pluck('id')->toArray(),
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
            ->whereIn('id', $checkout_items)
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

    public static function updateItemSize($cart_item_id, $new_size)
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        if ($cart) {
            $existing_item = $cart->items()
                ->where('product_id', function ($query) use ($cart_item_id) {
                    $query->select('product_id')
                        ->from('cart_items')
                        ->where('id', $cart_item_id)
                        ->first();
                })
                ->where('size', $new_size)
                ->where('id', '!=', $cart_item_id)
                ->first();

            if ($existing_item) {
                $item_to_update = $cart->items()->find($cart_item_id);
                if ($item_to_update) {
                    $existing_item->quantity += $item_to_update->quantity;
                    $existing_item->total_price = $existing_item->quantity * $existing_item->unit_price;
                    $existing_item->save();
                    $item_to_update->delete();
                }
            } else {
                $item = $cart->items()->find($cart_item_id);
                if ($item) {
                    $item->size = $new_size;
                    $item->save();
                }
            }
            return true;
        }
        return false;
    }
}
