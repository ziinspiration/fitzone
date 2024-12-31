<div class="py-14 px-4 md:px-6 2xl:px-20 2xl:container 2xl:mx-auto">
  <h2 class="text-2xl font-bold mb-8 mt-10">Order Details</h2>
  
  <!-- Order Info Cards -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
      <!-- Customer Card -->
      <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center space-x-3 mb-4">
              <svg class="h-6 w-6 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
              <span class="text-sm font-medium text-gray-600">Customer</span>
          </div>
          <div class="text-sm text-gray-900">{{ $address->full_name }}</div>
      </div>

      <!-- Order Date Card -->
      <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center space-x-3 mb-4">
              <svg class="h-6 w-6 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              <span class="text-sm font-medium text-gray-600">Order Date</span>
          </div>
          <div class="text-sm text-gray-900">{{ $order_items[0]->created_at->format('d-m-Y') }}</div>
      </div>

      <!-- Order Status Card -->
      <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center space-x-3 mb-4">
              <svg class="h-6 w-6 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
              </svg>
              <span class="text-sm font-medium text-gray-600">Order Status</span>
          </div>
          @php
              if($order->status == 'new') {
                  $status = '<span class="bg-primary-600 text-white text-sm py-1 px-3 rounded-full">New</span>';
              } elseif($order->status == 'processing') {
                  $status = '<span class="bg-yellow-500 text-white text-sm py-1 px-3 rounded-full">Processing</span>';
              } elseif($order->status == 'shipped') {
                  $status = '<span class="bg-green-500 text-white text-sm py-1 px-3 rounded-full">Shipped</span>';
              } elseif($order->status == 'delivered') {
                  $status = '<span class="bg-green-500 text-white text-sm py-1 px-3 rounded-full">Delivered</span>';
              } elseif($order->status == 'cancelled') {
                  $status = '<span class="bg-red-500 text-white text-sm py-1 px-3 rounded-full">Cancelled</span>';
              }
          @endphp
          {!! $status !!}
      </div>

      <!-- Payment Status Card -->
      <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center space-x-3 mb-4">
              <svg class="h-6 w-6 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
              </svg>
              <span class="text-sm font-medium text-gray-600">Payment Status</span>
          </div>
          @php
              if($order->payment_status == 'pending') {
                  $payment_status = '<span class="bg-primary-600 text-white text-sm py-1 px-3 rounded-full">Pending</span>';
              } elseif($order->payment_status == 'paid') {
                  $payment_status = '<span class="bg-green-500 text-white text-sm py-1 px-3 rounded-full">Paid</span>';
              } elseif($order->payment_status == 'failed') {
                  $payment_status = '<span class="bg-red-500 text-white text-sm py-1 px-3 rounded-full">Failed</span>';
              }
          @endphp
          {!! $payment_status !!}
      </div>
  </div>

  <div class="flex flex-col lg:flex-row gap-6">
      <!-- Order Items -->
      <div class="lg:w-2/3">
          <div class="bg-white rounded-lg shadow p-6 mb-6">
              <h3 class="text-lg font-semibold mb-4">Order Items</h3>
              <div class="overflow-x-auto">
                  <table class="w-full">
                      <thead>
                          <tr class="border-b border-gray-200">
                              <th class="text-left py-4 text-sm font-medium text-gray-700">Product</th>
                              <th class="text-left py-4 text-sm font-medium text-gray-700">Price</th>
                              <th class="text-left py-4 text-sm font-medium text-gray-700">Quantity</th>
                              <th class="text-left py-4 text-sm font-medium text-gray-700">Total</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($order->items as $item)
                          <tr class="border-b border-gray-100" wire:key="{{ $item->id }}">
                              <td class="py-4">
                                  <div class="flex items-center">
                                      <img class="h-16 w-16 rounded-md object-cover mr-4" src="{{ url('storage', $item->product->images[0]) }}" alt="{{ $item->product->name }}">
                                      <span class="text-sm text-gray-900">{{ $item->product->name }}</span>
                                  </div>
                              </td>
                              <td class="py-4 text-sm text-gray-600">{{ Number::currency($item->unit_amount, 'IDR') }}</td>
                              <td class="py-4 text-sm text-gray-600">{{ $item->quantity }}</td>
                              <td class="py-4 text-sm text-gray-900">{{ Number::currency($item->total_amount, 'IDR') }}</td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
          </div>

          <!-- Shipping Address -->
          <div class="bg-white rounded-lg shadow p-6">
              <h3 class="text-lg font-semibold mb-4">Shipping Address</h3>
              <div class="flex flex-col md:flex-row justify-between text-sm">
                  <div class="text-gray-600">
                      <p>{{ $address->street_address }}</p>
                      <p>{{ $address->city }}, {{ $address->state }} {{ $address->zip_code }}</p>
                  </div>
                  <div class="mt-4 md:mt-0">
                      <p class="font-medium text-gray-900">Contact Phone</p>
                      <p class="text-gray-600">{{ $address->phone }}</p>
                  </div>
              </div>
          </div>
      </div>

      <!-- Order Summary -->
      <div class="lg:w-1/3">
          <div class="bg-white rounded-lg shadow p-6">
              <h3 class="text-lg font-semibold mb-4">Order Summary</h3>
              <div class="space-y-3">
                  <div class="flex justify-between text-sm">
                      <span class="text-gray-600">Subtotal</span>
                      <span class="text-gray-900">{{ Number::currency($item->order->grand_total, 'IDR') }}</span>
                  </div>
                  <div class="flex justify-between text-sm">
                      <span class="text-gray-600">Shipping</span>
                      <span class="text-gray-900">₹0.00</span>
                  </div>
                  <div class="flex justify-between text-sm">
                      <span class="text-gray-600">Tax</span>
                      <span class="text-gray-900">₹0.00</span>
                  </div>
                  <div class="pt-3 border-t">
                      <div class="flex justify-between">
                          <span class="font-medium text-gray-900">Total</span>
                          <span class="font-medium text-gray-900">{{ Number::currency($item->order->grand_total, 'IDR') }}</span>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>