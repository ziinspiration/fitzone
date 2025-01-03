<div class="py-14 px-4 md:px-6 2xl:px-20 2xl:container 2xl:mx-auto">
    <h2 class="text-2xl font-bold mb-8 mt-10">Order Details</h2>
    <button wire:click="downloadPDF" class="flex items-center justify-center gap-2 bg-primary-600 text-white px-4 py-2 rounded-lg mb-10 hover:bg-primary-700">
        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        <span wire:loading.remove wire:target="downloadPDF">Download PDF</span>
        <span wire:loading wire:target="downloadPDF">Generating...</span>
     </button>

    <!-- Order Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        <!-- Customer Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center space-x-3 mb-4">
                <svg class="h-6 w-6 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span class="text-sm font-medium text-gray-600">Customer Account</span>
            </div>
            <div class="text-sm text-gray-900">{{ auth()->user()->full_name }}</div>
        </div>

        <!-- Order Date Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center space-x-3 mb-4">
                <svg class="h-6 w-6 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="text-sm font-medium text-gray-600">Order Date</span>
            </div>
            <div class="text-sm text-gray-900">
                {{ \Carbon\Carbon::parse($order_items[0]->created_at)->locale('en')->isoFormat('dddd, D MMMM YYYY ( HH:mm:ss [WIB] )') }}
            </div>
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
            if($order->status == 'pending') {
                $status = '<span class="bg-primary-600 text-white text-sm py-1 px-3 rounded-full">Pending</span>';
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


        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center space-x-3 mb-4">
                <svg class="h-6 w-6 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span class="text-sm font-medium text-gray-600">Payment Status</span>
            </div>
            @php
            if($order->payment_status == 'pending') {
                $payment_status = '<span class="bg-primary-600 text-white text-sm py-1 px-3 rounded-full">Pending</span>';
            } elseif($order->payment_status == 'processing') {
                $payment_status = '<span class="bg-yellow-500 text-white text-sm py-1 px-3 rounded-full">Processing</span>';
            } elseif($order->payment_status == 'shipped') {
                $payment_status = '<span class="bg-green-500 text-white text-sm py-1 px-3 rounded-full">Shipped</span>';
            } elseif($order->payment_status == 'delivered') {
                $payment_status = '<span class="bg-green-500 text-white text-sm py-1 px-3 rounded-full">Delivered</span>';
            } elseif($order->payment_status == 'cancelled') {
                $payment_status = '<span class="bg-red-500 text-white text-sm py-1 px-3 rounded-full">Cancelled</span>';
            }
        @endphp
           {!! $payment_status !!}
        </div>


        <!-- Payment Status Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center space-x-3 mb-4">
                <svg class="h-6 w-6 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
                </svg>
                <span class="text-sm font-medium text-gray-600">Courier Service</span>
            </div>
            <div class="flex justify-center">
                @if (str_contains(strtolower($order->shipping_service), 'pos'))
                    <img class="h-10 w-15 rounded-md object-cover mr-4" src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/21/POSIND_2023.svg/2560px-POSIND_2023.svg.png" alt="POS Indonesia">
                @elseif (str_contains(strtolower($order->shipping_service), 'jne'))
                    <img class="h-10 w-15 rounded-md object-cover mr-4" src="https://upload.wikimedia.org/wikipedia/commons/9/92/New_Logo_JNE.png" alt="JNE Express">
                @endif
            </div>
            <p class="text-sm font-medium text-gray-800 text-center uppercase mt-2">{{ str_replace('_', ' ', $order->shipping_service) }}</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center space-x-3 mb-4">
                <svg class="h-6 w-6 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
                </svg>
                <span class="text-sm font-medium text-gray-600">Payment Method</span>
            </div>
            <div class="flex justify-center">
                {{-- @if (str_contains(strtolower($order->payment_method), 'pos'))
                    <img class="h-10 w-15 rounded-md object-cover mr-4" src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/21/POSIND_2023.svg/2560px-POSIND_2023.svg.png" alt="POS Indonesia">
                @elseif (str_contains(strtolower($order->payment_method), 'jne'))
                    <img class="h-10 w-15 rounded-md object-cover mr-4" src="https://upload.wikimedia.org/wikipedia/commons/9/92/New_Logo_JNE.png" alt="JNE Express">
                @endif --}}
            </div>
            <p class="text-sm font-medium text-gray-800 text-center uppercase mt-2">{{ str_replace('_', ' ', $order->payment_method) }}</p>
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
                            <tr class="border-b border-gray-200 text-center">
                                <th class="text-center py-4 text-sm font-medium text-gray-700">Product</th>
                                <th class="text-center py-4 text-sm font-medium text-gray-700">Name</th>
                                <th class="text-center py-4 text-sm font-medium text-gray-700">Price</th>
                                <th class="text-center py-4 text-sm font-medium text-gray-700">Quantity</th>
                                <th class="text-center py-4 text-sm font-medium text-gray-700">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderItems as $item)
                            <tr class="border-b border-gray-100 text-center" wire:key="{{ $item->id }}">
                                <td class="py-4">
                                    <div class="flex items-center justify-center">
                                        <img class="h-10 w-10 rounded-md object-cover mr-4" src="{{ url('storage', $item->product->images[0]) }}" alt="{{ $item->product->name }}">
                                    </div>
                                </td>
                                <td class="py-4 text-sm text-gray-600">{{ $item->product->name }}</td>
                                <td class="py-4 text-sm text-gray-600">{{ Number::currency($item->unit_price ?? 0, 'IDR') }}</td>
                                <td class="py-4 text-sm text-gray-600">{{ $item->quantity }}</td>
                                <td class="py-4 text-sm text-gray-900">{{ Number::currency($item->total_price ?? 0, 'IDR') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-2">Shipping Address</h3>
                <div class="flex flex-col md:flex-row justify-between text-sm font-medium mb-2">
                    <div class="text-gray-600">
                        <p>{{ $address->full_name }} ( {{ $address->phone }} )</p>
                        <p></p>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row justify-between text-sm font-medium">
                    <div class="text-gray-600">
                        <p>{{ $address->street_address }} {{ $address->district }}, {{ $address->province_name }}, {{ $address->city_name }}, {{ $address->postal_code }}</p>
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
                        <span class="text-gray-900">{{ Number::currency($order->subtotal ?? 0, 'IDR') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Shipping</span>
                        <span class="text-gray-900">{{ Number::currency($order->shipping_cost ?? 0, 'IDR') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Tax</span>
                        <span class="text-gray-900">{{ Number::currency($order->tax_amount ?? 0, 'IDR') }}</span>
                    </div>
                    <div class="pt-3 border-t">
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-900">Total</span>
                            <span class="font-medium text-gray-900">{{ Number::currency($order->total_amount ?? 0, 'IDR') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>

