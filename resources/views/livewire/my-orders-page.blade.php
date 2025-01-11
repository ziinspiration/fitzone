<div class="py-14 px-4 md:px-6 2xl:px-20 2xl:container 2xl:mx-auto">
  <div class="flex flex-col space-y-4">
      <!-- Orders Section -->
      <div class="bg-white rounded-lg shadow p-8 mt-10">
          <h2 class="text-2xl font-bold mb-8">My Orders</h2>

          <div class="overflow-x-auto">
              <table class="min-w-full">
                  <thead>
                      <tr class="border-b border-gray-200">
                          <th class="text-sm font-medium text-gray-700 py-4 text-left">Order</th>
                          <th class="text-sm font-medium text-gray-700 py-4 text-left">Date</th>
                          <th class="text-sm font-medium text-gray-700 py-4 text-left">Order Status</th>
                          <th class="text-sm font-medium text-gray-700 py-4 text-left">Payment Status</th>
                          <th class="text-sm font-medium text-gray-700 py-4 text-left">Order Amount</th>
                          <th class="text-sm font-medium text-gray-700 py-4 text-right">Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($orders as $order)
                      @php
                          $status = '';
                          $payment_status = '';

                          // order status
                          if($order->status == 'new') {
                              $status = '<span class="bg-primary-600 text-white text-sm py-1 px-3 rounded-full">New</span>';
                          }
                          if($order->status == 'processing') {
                              $status = '<span class="bg-yellow-500 text-white text-sm py-1 px-3 rounded-full">Processing</span>';
                          }
                          if($order->status == 'shipped') {
                              $status = '<span class="bg-green-500 text-white text-sm py-1 px-3 rounded-full">Shipped</span>';
                          }
                          if($order->status == 'delivered') {
                              $status = '<span class="bg-green-500 text-white text-sm py-1 px-3 rounded-full">Delivered</span>';
                          }
                          if($order->status == 'cancelled') {
                              $status = '<span class="bg-red-500 text-white text-sm py-1 px-3 rounded-full">Cancelled</span>';
                          }

                          // payment status
                          if($order->payment_status == 'pending') {
                              $payment_status = '<span class="bg-primary-600 text-white text-sm py-1 px-3 rounded-full">Pending</span>';
                          }
                          if($order->payment_status == 'paid') {
                              $payment_status = '<span class="bg-green-500 text-white text-sm py-1 px-3 rounded-full">Paid</span>';
                          }
                          if($order->payment_status == 'failed') {
                              $payment_status = '<span class="bg-red-500 text-white text-sm py-1 px-3 rounded-full">Failed</span>';
                          }
                      @endphp
                      <tr class="border-b border-gray-100" wire:key='{{ $order->id }}'>
                          <td class="py-4 text-sm text-gray-900">{{ $order->id }}</td>
                          <td class="py-4 text-sm text-gray-600">{{ $order->created_at->format('d-m-Y') }}</td>
                          <td class="py-4">{!! $status !!}</td>
                          <td class="py-4">{!! $payment_status !!}</td>
                          <td class="py-4 text-sm text-gray-900">{{ $order->grand_total, 'IDR' }}</td>
                          <td class="py-4 text-right">
                              <a href="/my-orders/{{ $order->id }}"
                                 class="inline-flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                  View Details
                              </a>
                          </td>
                      </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>

          <div class="mt-6">
              {{ $orders->links() }}
          </div>
      </div>

      <!-- Order Summary -->
      <div class="bg-white rounded-lg shadow p-8">
          <h2 class="text-2xl font-bold mb-6">Order Summary</h2>
          <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
              <div class="flex items-center space-x-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                  </svg>
                  <span class="text-sm font-medium text-gray-600">Total Orders</span>
              </div>
              <span class="text-sm text-gray-900">{{ $orders->total() }}</span>
          </div>
      </div>
  </div>
</div>
