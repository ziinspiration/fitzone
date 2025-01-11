<div class="min-h-screen bg-gray-50">
    <div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="container mx-auto mt-10">
            <h1 class="text-3xl font-bold text-gray-900 mb-5">Shopping Cart</h1>
            <div class="flex flex-col lg:flex-row gap-8">
                <div class="lg:w-3/4">
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 border-b border-gray-200">
                                    <tr>
                                        <th class="text-left font-medium text-gray-600 py-4 px-6">Select</th>
                                        <th class="text-left font-medium text-gray-600 py-4 px-6">Product</th>
                                        <th class="text-left font-medium text-gray-600 py-4 px-6">Size</th>
                                        <th class="text-left font-medium text-gray-600 py-4 px-6">Price</th>
                                        <th class="text-left font-medium text-gray-600 py-4 px-6">Quantity</th>
                                        <th class="text-left font-medium text-gray-600 py-4 px-6">Total</th>
                                        <th class="text-left font-medium text-gray-600 py-4 px-6">Remove</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse ($cart_items as $item)
                                    <tr wire:key='{{ $item->id }}'>
                                      <td class="py-6 px-6 m-auto">
                                          <input type="checkbox" wire:click="selectItem({{ $item->id }}, $event.target.checked)"
                                                 {{ in_array($item->id, $selected_items) ? 'checked' : '' }} />
                                      </td>
                                        <td class="py-6 px-6">
                                          <div class="flex items-center gap-4">
                                              <a href="{{ route('products.show', ['slug' => $item->product->slug]) }}">
                                                  <img class="h-20 w-20 rounded-lg object-cover"
                                                       src="{{ url('storage', $item->product->images[0]) }}"
                                                       alt="{{ $item['name'] }}">
                                                  <span class="font-medium text-gray-900">{{ $item['name'] }}</span>
                                              </a>
                                          </div>

                                        </td>
                                        <td class="py-6 px-6">
                                            @if($sizes)
                                                <select
                                                    wire:change="updateSize('{{ $item->id }}', $event.target.value)"
                                                    class="w-24 rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 text-sm"
                                                >
                                                    @foreach ($sizes as $size)
                                                        <option value="{{ $size->size }}" {{ $item->size === $size->size ? 'selected' : '' }}>
                                                            {{ $size->size }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @else
                                                  <p>Size Not Available</p>
                                             @endif
                                        </td>
                                        <td class="py-6 px-6 text-gray-900">
                                            {{ Number::currency($item['unit_price'], 'IDR') }}
                                        </td>
                                        <td class="py-6 px-6">
                                            <div class="flex items-center">
                                              <button wire:click='decreaseQty({{ $item->id }})'
                                                          class="w-8 h-8 flex items-center justify-center bg-red-700 text-white px-4 py-2 rounded-lg hover:bg-red-900 transition-colors">
                                                      <span class="text-white font-bold">−</span>
                                              </button>

                                                <span class="mx-4 w-8 text-center text-gray-900">{{ $item['quantity']}}</span>
                                                <button wire:click='increaseQty({{ $item['id'] }})'
                                                        class="w-8 h-8 flex items-center justify-center bg-primary-700 text-white px-4 py-2 rounded-lg hover:bg-primary-900 transition-colors">
                                                    <span class="text-white font-bold">+</span>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="py-6 px-6 text-gray-900">
                                            {{ Number::currency($item['total_price'], 'IDR' )}}
                                        </td>
                                        <td class="py-6 px-6">
                                            <button wire:click='removeItem({{$item['id'] }})'
                                                    class="bg-primary-700 text-white px-4 py-2 rounded-lg hover:bg-primary-900 transition-colors">
                                                <span wire:loading.remove wire:target='removeItem({{ $item['id'] }})'>
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </span>
                                                <span wire:loading wire:target='removeItem({{ $item['id'] }})'>
                                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                    </svg>
                                                </span>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="py-12">
                                            <div class="text-center">
                                                <span class="text-2xl font-medium text-gray-400">
                                                    Your cart is empty
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="lg:w-1/4">
                    <div class="bg-white rounded-xl shadow-sm p-6 sticky top-8">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Order Summary</h2>

                        <div class="space-y-4">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span>{{ Number::currency($grand_total, 'IDR') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Taxes</span>
                                <span>{{ Number::currency($tax_amount, 'IDR') }}</span>
                            </div>
                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex justify-between">
                                    <span class="text-lg font-bold text-gray-900">Total</span>
                                    <span class="text-lg font-bold text-gray-900">
                                      <span>{{ Number::currency($grand_total + $tax_amount, 'IDR') }}</span>
                                    </span>
                                </div>
                            </div>
                        </div>


                        @if(count($selected_items) > 0)
                        <button
                            wire:click="proceedToCheckout"
                            class="mt-8 block w-full bg-primary-700 text-white text-center py-3 px-4 rounded-lg hover:bg-primary-900 transition-colors">
                            <span wire:loading.remove wire:target="proceedToCheckout">
                                Checkout
                            </span>
                            <span wire:loading wire:target="proceedToCheckout">
                              Processing...
                            </span>
                        </button>
                    @else
                        <button
                            class="mt-8 block w-full bg-gray-400 text-white text-center py-3 px-4 rounded-lg hover:bg-gray-400 transition-colors"
                            disabled>
                            Select items to checkout
                        </button>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
