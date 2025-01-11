<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Address;
use Livewire\Component;
use App\Models\OrderItem;
use Livewire\Attributes\Title;
use App\Helpers\CartManagement;
use App\Services\MidtransService;
use Illuminate\Support\Facades\DB;
use App\Services\RajaOngkirService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

#[Title('Checkout - Fitzone')]
class CheckoutPage extends Component
{
    public $first_name;
    public $last_name;
    public $phone;
    public $street_address;
    public $province_id;
    public $province_name;
    public $city_id;
    public $city_name;
    public $district;
    public $postal_code;
    public $selected_service;
    public $shipping_cost = 0;
    public $provinces = [];
    public $cities = [];
    public $shipping_rates = [];
    public $checkout_items = [];
    public $subtotal = 0;
    public $tax_amount = 0;
    public $grand_total = 0;
    public $snap_token;
    protected $rules = [
        'first_name' => 'required|min:3',
        'last_name' => 'required|min:3',
        'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        'street_address' => 'required|min:10',
        'province_id' => 'required',
        'city_id' => 'required',
        'district' => 'required|min:3',
        'postal_code' => 'required|numeric|digits:5',
        'selected_service' => 'required',
    ];

    protected $messages = [
        'first_name.required' => 'First name is required',
        'first_name.min' => 'First name must be at least 3 characters',
        'last_name.required' => 'Last name is required',
        'last_name.min' => 'Last name must be at least 3 characters',
        'phone.required' => 'Phone number is required',
        'phone.regex' => 'Invalid phone number format',
        'phone.min' => 'Phone number must be at least 10 digits',
        'street_address.required' => 'Street address is required',
        'street_address.min' => 'Street address is too short',
        'province_id.required' => 'Province must be selected',
        'city_id.required' => 'City must be selected',
        'district.required' => 'District is required',
        'district.min' => 'District name is too short',
        'postal_code.required' => 'Postal code is required',
        'postal_code.numeric' => 'Postal code must be a number',
        'postal_code.digits' => 'Postal code must be 5 digits',
        'selected_service.required' => 'Shipping service must be selected',
    ];


    public $cart_items = [];

    public function mount()
    {
        if (!session()->has('checkout_items')) {
            return redirect()->route('cart')
                ->with('error', 'Please select items to checkout first');
        }

        $this->cart_items = collect(CartManagement::getSelectedItemsForCheckout());

        if (empty($this->cart_items)) {
            return redirect()->route('cart')
                ->with('error', 'Checkout items not found');
        }

        $this->subtotal = session('checkout_subtotal', 0);
        $this->tax_amount = session('checkout_tax', 0);
        $this->calculateTotals();

        $lastAddress = Address::where('user_id', Auth::id())
            ->latest()
            ->first();

        if ($lastAddress) {
            $this->first_name = $lastAddress->first_name;
            $this->last_name = $lastAddress->last_name;
            $this->phone = $lastAddress->phone;
            $this->street_address = $lastAddress->street_address;
            $this->district = $lastAddress->district;
            $this->postal_code = $lastAddress->postal_code;
            $this->province_id = $lastAddress->province_id;
            $this->city_id = $lastAddress->city_id;
        }

        try {
            $rajaOngkir = new RajaOngkirService();
            $provinces = $rajaOngkir->getProvinces();
            $this->provinces = $provinces;

            if (empty($provinces)) {
                Log::warning('No provinces returned from RajaOngkir API');
            }

            $this->provinces = $provinces;

            if ($lastAddress && $lastAddress->province_id) {
                $cities = $rajaOngkir->getCities($lastAddress->province_id);

                if (empty($cities)) {
                    Log::warning('No cities returned for province_id: ' . $lastAddress->province_id);
                }

                $this->cities = $cities;
                $this->calculateShippingRates();
            }
        } catch (\Exception $e) {
            Log::error('RajaOngkir Mount Error: ' . $e->getMessage());
            session()->flash('error', 'Failed to load provinces and cities data: ' . $e->getMessage());
        }
    }

    public function updatedProvinceId($value)
    {
        $this->reset(['cities', 'city_id', 'shipping_rates', 'shipping_cost', 'selected_service']);

        if ($value) {
            try {
                $rajaOngkir = new RajaOngkirService();
                $response = $rajaOngkir->getCities($value);

                if (empty($response)) {
                    throw new \Exception('No city data found');
                }

                $this->cities = $response;
                $province = collect($this->provinces)->firstWhere('province_id', $value);
                $this->province_name = $province['province'];
                $this->calculateTotals();
            } catch (\Exception $e) {
                Log::error('Province Update Error: ' . $e->getMessage());
                session()->flash('error', 'Failed to load city data: ' . $e->getMessage());
            }
        }
    }

    public function updatedCityId($value)
    {
        $this->reset(['shipping_rates', 'shipping_cost', 'selected_service']);

        if ($value) {
            try {
                $city = collect($this->cities)->firstWhere('city_id', $value);
                $this->city_name = $city['city_name'];
                $this->calculateShippingRates();
                $this->calculateTotals();
            } catch (\Exception $e) {
                Log::error('City Update Error: ' . $e->getMessage(), [
                    'trace' => $e->getTraceAsString(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]);
                session()->flash('error', 'Failed to load shipping rates');
            }
        }
    }

    public function selectShippingService($code, $cost)
    {
        $this->selected_service = $code;
        $this->shipping_cost = $cost;
        $this->calculateTotals();
    }

    protected function calculateShippingRates()
    {
        if (!$this->city_id) {
            return;
        }

        try {
            $rajaOngkir = new RajaOngkirService();

            $total_weight = 0;

            if (!empty($this->cart_items)) {
                $total_weight = collect($this->cart_items)->sum(function ($item) {
                    $weightPerItem = $item['product']['weight'] ?? 1000;
                    return $item['quantity'] * $weightPerItem;
                });
            } else {
                Log::error('Cart is empty or invalid', ['cart_items' => $this->cart_items]);
                return;
            }

            Log::info('Total Weight:', ['weight' => $total_weight]);

            $rounded_weight = round($total_weight);
            Log::info('Rounded Weight:', ['weight' => $rounded_weight]);

            $couriers = ['jne', 'pos'];
            $this->shipping_rates = [];

            foreach ($couriers as $courier) {
                $rates = $rajaOngkir->getShippingCost(
                    origin: '23',
                    destination: $this->city_id,
                    weight: $rounded_weight,
                    courier: $courier
                );

                if (!empty($rates) && isset($rates[0]['costs'])) {
                    foreach ($rates[0]['costs'] as $cost) {
                        $this->shipping_rates[] = [
                            'code' => $courier . '_' . strtolower($cost['service']),
                            'name' => strtoupper($courier) . ' ' . $cost['service'],
                            'cost' => $cost['cost'][0]['value'],
                            'etd' => $cost['cost'][0]['etd'] ?? '-'
                        ];
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Shipping Rate Error: ' . $e->getMessage());
            session()->flash('error', 'Failed to calculate shipping cost');
        }
    }
    protected function calculateTotals()
    {
        $this->grand_total = $this->subtotal + $this->tax_amount + $this->shipping_cost;
    }

    public function placeOrder()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $address = Address::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'phone' => $this->phone,
                    'postal_code' => $this->postal_code
                ],
                [
                    'first_name' => $this->first_name,
                    'last_name' => $this->last_name,
                    'street_address' => $this->street_address,
                    'province_id' => $this->province_id,
                    'city_id' => $this->city_id,
                    'district' => $this->district
                ]
            );

            $order = Order::create([
                'user_id' => Auth::id(),
                'address_id' => $address->id,
                'order_number' => 'ORD-' . time() . '-' . Auth::id(),
                'subtotal' => $this->subtotal,
                'tax_amount' => $this->tax_amount,
                'shipping_cost' => $this->shipping_cost,
                'shipping_service' => $this->selected_service,
                'total_amount' => $this->grand_total,
                'status' => 'Pending',
            ]);

            $midtrans = new MidtransService();
            $snapToken = $midtrans->createTransaction($order);

            $order->payment_token = $snapToken;
            $order->save();

            foreach ($this->cart_items as $item) {
                $total_price = $item['quantity'] * $item['product']['price'];
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'size' => $item['size'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['product']['price'],
                    'total_price' => $total_price,
                ]);
            }

            $this->snap_token = (string) $snapToken;

            DB::commit();

            $this->dispatch('showPaymentPopup', snapToken: $this->snap_token);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order Creation Error: ' . $e->getMessage());
            session()->flash('error', 'Gagal membuat order. Silakan coba lagi.');
            throw $e;
        }
    }

    public function render()
    {
        Log::info('Debug Checkout State:', [
            'provinces' => count($this->provinces),
            'cities' => count($this->cities),
            'shipping_rates' => count($this->shipping_rates),
        ]);

        return view('livewire.checkout-page');
    }
}
