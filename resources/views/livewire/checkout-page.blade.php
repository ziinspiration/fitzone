<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto ">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-4 mt-10">
        Checkout
    </h1>
    <form wire:submit.prevent='placeOrder'>
        <div class="grid grid-cols-12 gap-4">
            <div class="md:col-span-12 lg:col-span-8 col-span-12">
                <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-800">
                    <div class="space-y-5">
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label for="first_name" class="text-sm font-semibold text-gray-700">First Name</label>
                                <input wire:model="first_name" name="first_name" type="text"
                                       class="w-full mt-2 py-2 px-4 bg-gray-200 rounded-md" placeholder="Your First name">
                                @error('first_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="last_name" class="text-sm font-semibold text-gray-700">Last Name</label>
                                <input wire:model="last_name" name="last_name" type="text"
                                       class="w-full mt-2 py-2 px-4 bg-gray-200 rounded-md" placeholder="Your Last name">
                                @error('last_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label for="phone" class="text-sm font-semibold text-gray-700">Phone Number</label>
                                <input wire:model="phone" name="phone" type="tel"
                                       class="w-full mt-2 py-2 px-4 bg-gray-200 rounded-md"
                                       placeholder="e.g., 08123456789">
                                @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="street_address" class="text-sm font-semibold text-gray-700">Street Address</label>
                                <input wire:model="street_address" name="street_address" type="text"
                                       class="w-full mt-2 py-2 px-4 bg-gray-200 rounded-md"
                                       placeholder="Street name, house number, neighborhood">
                                @error('street_address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label for="province_id" class="text-sm font-semibold text-gray-700">Province</label>
                                <select wire:model.live="province_id" name="province_id" class="w-full mt-2 py-2 px-4 bg-gray-200 rounded-md">
                                    <option value="">Select Province</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province['province_id'] }}">
                                            {{ $province['province'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('province_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="city_id" class="text-sm font-semibold text-gray-700">City</label>
                                <select wire:model.live="city_id" name="city_id"
                                        class="w-full mt-2 py-2 px-4 bg-gray-200 rounded-md"
                                        {{ empty($cities) ? 'disabled' : '' }}>
                                    <option value="">Select City</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city['city_id'] }}">
                                            {{ $city['city_name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('city_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label for="district" class="text-sm font-semibold text-gray-700">District</label>
                                <input wire:model="district" name="district" type="text"
                                       class="w-full mt-2 py-2 px-4 bg-gray-200 rounded-md"
                                       placeholder="Your District">
                                @error('district') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="postal_code" class="text-sm font-semibold text-gray-700">Postal Code</label>
                                <input wire:model="postal_code" name="postal_code" type="text"
                                       class="w-full mt-2 py-2 px-4 bg-gray-200 rounded-md"
                                       placeholder="5-digit postal code"
                                       maxlength="5">
                                @error('postal_code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <label class="text-sm font-semibold text-gray-700 block mb-3">Shipping Service</label>
                            <div class="space-y-4">
                                @forelse($shipping_rates as $rate)
                                    <div class="flex items-center p-4 border rounded-lg
                                         {{ $selected_service === $rate['code'] ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                                        <input type="radio"
                                               wire:click="selectShippingService('{{ $rate['code'] }}', {{ $rate['cost'] }})"
                                               name="shipping_service"
                                               value="{{ $rate['code'] }}"
                                               {{ $selected_service === $rate['code'] ? 'checked' : '' }}class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                               <label class="ml-3 flex flex-col">
                                                   <span class="block text-sm font-medium text-gray-900">{{ $rate['name'] }}</span>
                                                   <span class="block text-sm text-gray-500">
                                                       Estimated: {{ $rate['etd'] }} Days
                                                   </span>
                                                   <span class="block text-sm font-semibold text-gray-900">
                                                       Rp {{ number_format($rate['cost'], 0, ',', '.') }}
                                                   </span>
                                               </label>
                                           </div>
                                       @empty
                                           <div class="text-gray-500 text-sm">
                                               Please select a city to view available shipping options
                                           </div>
                                       @endforelse
                                       @error('selected_service')
                                           <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                       @enderror
                                   </div>
                               </div>
                           </div>
                       </div>

                   </div>

                   <div class="md:col-span-12 lg:col-span-4 col-span-12">
                       <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                           <div class="text-xl font-bold text-gray-700 dark:text-white mb-4">
                               Order Summary
                           </div>
                           <div class="space-y-3">
                               <div class="flex justify-between">
                                   <span class="text-gray-600">Subtotal</span>
                                   <span class="font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                               </div>
                               <div class="flex justify-between">
                                   <span class="text-gray-600">Tax (10%)</span>
                                   <span class="font-medium">Rp {{ number_format($tax_amount, 0, ',', '.') }}</span>
                               </div>
                               <div class="flex justify-between">
                                   <span class="text-gray-600">Shipping Cost</span>
                                   <span class="font-medium">Rp {{ number_format($shipping_cost, 0, ',', '.') }}</span>
                               </div>
                               <hr class="border-gray-200">
                               <div class="flex justify-between text-lg font-bold">
                                   <span>Total</span>
                                   <span>Rp {{ number_format($grand_total, 0, ',', '.') }}</span>
                               </div>
                           </div>

                           <button type="submit"
                                   class="bg-primary-700 mt-4 w-full p-3 rounded-lg text-lg text-white hover:bg-primary-600"
                                   @if(!$selected_service) disabled @endif
                                   wire:loading.attr="disabled">
                               <span wire:loading.remove wire:target="placeOrder">
                                   Place Order
                               </span>
                               <span wire:loading wire:target="placeOrder">
                                   Processing...
                               </span>
                           </button>
                       </div>

                     <div class="bg-white mt-4 rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                    <div class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                        BASKET SUMMARY
                    </div>
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700" role="list">
                        @foreach ($cart_items as $ci)
                        <li class="py-3 sm:py-4" wire:key='{{ $ci['product_id'] }}'>
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <img alt="{{ $ci['name'] }}" class="w-12 h-12 rounded-full" src="{{ url('storage', $ci->product->images) }}"/>
                                </div>
                                <div class="flex-1 min-w-0 ms-4">
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                        {{ $ci->product->name }}
                                    </p>
                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                        {{ $ci['quantity'] }} X
                                    </p>
                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                        Size : {{ $ci['size'] }}
                                    </p>
                                </div>
                                <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                    Rp {{ number_format($ci['total_price'], 2) }}
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
data-client-key="{{ config('midtrans.client_key') }}">
</script>
    <script>
        window.addEventListener('showPaymentPopup', (event) => {

            let token = event.detail.snapToken.toString();

            console.log('Snap Token:', token);

            try {
                window.snap.pay(token, {
                    onSuccess: function(result) {
                        console.log('success');
                        console.log(result);
                        window.location.href = '/success';
                    },
                    onPending: function(result) {
                        console.log('pending');
                        console.log(result);
                        window.location.href = '/pending';
                    },
                    onError: function(result) {
                        console.log('error');
                        console.log(result);
                        window.location.href = '/error';
                    },
                    onClose: function() {
                        document.getElementById('submit-button').disabled = false;
                        alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                    }
                });
            } catch (error) {
                console.error('Error initializing payment:', error);
                alert('Terjadi kesalahan saat memulai pembayaran');
            }
        });
    </script>
@endpush
