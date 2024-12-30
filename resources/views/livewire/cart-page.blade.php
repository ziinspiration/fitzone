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
                                      <th class="text-left font-medium text-gray-600 py-4 px-6">Product</th>
                                      <th class="text-left font-medium text-gray-600 py-4 px-6">Price</th>
                                      <th class="text-left font-medium text-gray-600 py-4 px-6">Quantity</th>
                                      <th class="text-left font-medium text-gray-600 py-4 px-6">Total</th>
                                      <th class="text-left font-medium text-gray-600 py-4 px-6">Remove</th>
                                  </tr>
                              </thead>
                              <tbody class="divide-y divide-gray-200">
                                  @forelse ($cart_items as $item)
                                  <tr wire:key='{{ $item['product_id'] }}'>
                                      <td class="py-6 px-6">
                                          <div class="flex items-center gap-4">
                                              <img class="h-20 w-20 rounded-lg object-cover" 
                                                   src="{{ url('storage', $item['image']) }}" 
                                                   alt="{{ $item['name'] }}">
                                              <span class="font-medium text-gray-900">{{ $item['name'] }}</span>
                                          </div>
                                      </td>
                                      <td class="py-6 px-6 text-gray-900">
                                          {{ Number::currency($item['total_amount'], 'IDR') }}
                                      </td>
                                      <td class="py-6 px-6">
                                          <div class="flex items-center">
                                            <button wire:click='decreaseQty({{ $item['product_id'] }})'
                                                        class="w-8 h-8 flex items-center justify-center bg-red-700 text-white px-4 py-2 rounded-lg hover:bg-red-900 transition-colors">
                                                    <span class="text-white font-bold">−</span>
                                            </button>
                                                
                                              <span class="mx-4 w-8 text-center text-gray-900">{{ $item['quantity']}}</span>
                                              <button wire:click='increaseQty({{ $item['product_id'] }})'
                                                      class="w-8 h-8 flex items-center justify-center bg-primary-700 text-white px-4 py-2 rounded-lg hover:bg-primary-900 transition-colors">
                                                  <span class="text-white font-bold">+</span>
                                              </button>
                                          </div>
                                      </td>
                                      <td class="py-6 px-6 text-gray-900">
                                          {{ Number::currency($item['total_amount'], 'IDR' )}}
                                      </td>
                                      <td class="py-6 px-6">
                                          <button wire:click='removeItem({{$item['product_id'] }})' 
                                                  class="bg-primary-700 text-white px-4 py-2 rounded-lg hover:bg-primary-900 transition-colors">
                                              <span wire:loading.remove wire:target='removeItem({{ $item['product_id'] }})'>
                                                  Remove
                                              </span>
                                              <span wire:loading wire:target='removeItem({{ $item['product_id'] }})'>
                                                  Removing...
                                              </span>
                                          </button>
                                      </td>
                                  </tr>
                                  @empty
                                  <tr>
                                      <td colspan="5" class="py-12">
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
                              <span>{{ Number::currency(0, 'IDR') }}</span>
                          </div>
                          <div class="flex justify-between text-gray-600">
                              <span>Shipping</span>
                              <span>{{ Number::currency(0, 'IDR') }}</span>
                          </div>
                          
                          <div class="border-t border-gray-200 pt-4">
                              <div class="flex justify-between">
                                  <span class="text-lg font-bold text-gray-900">Total</span>
                                  <span class="text-lg font-bold text-gray-900">
                                      {{ Number::currency($grand_total, 'IDR') }}
                                  </span>
                              </div>
                          </div>
                      </div>

                      @if ($cart_items)
                      <a href="/checkout" 
                         class="mt-8 block w-full bg-primary-700 text-white text-center py-3 px-4 rounded-lg hover:bg-primary-900 transition-colors">
                          Proceed to Checkout
                      </a>
                      @endif
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>