

<div class="min-h-screen bg-gray-50 dark:bg-gray-900 mt-10">
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm overflow-hidden">
            <div class="flex flex-col lg:flex-row gap-8 p-6">
                {{-- Image Gallery Section --}}
                <div class="w-full lg:w-3/5" x-data="{ 
                    activeImage: '{{ isset($product->images[0]) ? url('storage', $product->images[0]) : url('images/default-product.jpg') }}',
                    zoom: false
                }">
                    {{-- Main Image --}}
                    <div class="relative aspect-square mb-4 overflow-hidden rounded-xl bg-gray-100 dark:bg-gray-900">
                        <img x-bind:src="activeImage" 
                            alt="{{ $product->name ?? 'Product Image' }}"
                            class="w-full h-full object-cover transition duration-300 ease-in-out"
                            x-bind:class="{ 'scale-125 cursor-zoom-out': zoom, 'cursor-zoom-in': !zoom }"
                            @click="zoom = !zoom">
                            
                        @if($product->on_sale)
                            <div class="absolute top-4 right-4">
                                <span class="bg-rose-600 text-white text-sm font-medium px-3 py-1.5 rounded-full">
                                    Sale
                                </span>
                            </div>
                        @endif
                    </div>

                    {{-- Thumbnail Gallery --}}
                    <div class="grid grid-cols-4 gap-4">
                        @forelse ($product->images ?? [] as $image)
                            <button 
                                @click="activeImage = '{{ url('storage', $image) }}'"
                                class="aspect-square rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-900 relative">
                                <img 
                                    src="{{ url('storage', $image) }}" 
                                    alt="{{ $product->name ?? 'Product Image' }}"
                                    class="w-full h-full object-cover hover:opacity-75 transition"
                                    :class="{ 'ring-2 ring-offset-2 ring-black dark:ring-white': activeImage === '{{ url('storage', $image) }}' }">
                            </button>
                        @empty
                            <div class="col-span-4 text-center py-8 text-gray-500 dark:text-gray-400">
                                No additional images available
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Product Info Section --}}
                <div class="w-full lg:w-2/5 flex flex-col">
                    {{-- Brand & Name --}}
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                            {{ $product->brand?->name ?? 'Brand Not Available' }}
                        </h4>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                            {{ $product->name ?? 'Product Name Not Available' }}
                        </h1>
                        <div class="flex items-baseline gap-4">
                            @if(isset($product->price))
                                <span class="text-2xl font-bold text-gray-900 dark:text-white">
                                    {{ Number::currency($product->price, 'IDR') }}
                                </span>
                                @if($product->on_sale && isset($product->original_price))
                                    <span class="text-lg text-gray-500 line-through">
                                        {{ Number::currency($product->original_price, 'IDR') }}
                                    </span>
                                @endif
                            @else
                                <span class="text-2xl font-bold text-gray-900 dark:text-white">
                                    Price Not Available
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="prose prose-sm dark:prose-invert mb-8 [&>ul]:list-disc [&>ul]:ml-4">
                        @if ($product->description)
                            {!! Str::markdown($product->description) !!}
                        @else
                            <p class="text-gray-500 dark:text-gray-400">No description available</p>
                        @endif
                    </div>

                    {{-- Quantity Selector --}}
                    <div class="mb-8">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                            Quantity
                        </label>
                        <div class="flex items-center gap-2">
                            <button wire:click="decreaseQty"
                                class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <span class="text-xl">−</span>
                            </button>
                            <input type="number" wire:model="quantity" readonly
                                class="w-20 h-10 text-center rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800">
                            <button wire:click="increaseQty"
                                class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <span class="text-xl">+</span>
                            </button>
                        </div>
                    </div>

                    {{-- Add to Cart --}}
                    <button wire:click="addToCart({{ $product->id }})"
                        class="w-full bg-primary-700 dark:bg-white text-white dark:text-black font-medium py-4 rounded-xl hover:bg-primary-900 dark:hover:bg-gray-100 transition-colors">
                        <span wire:loading.remove>Add to Cart</span>
                        <span wire:loading>
                            <svg class="animate-spin h-5 w-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </button>

                    {{-- Shipping Info --}}
                    <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                            </svg>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Free shipping on orders over $100</span>
                        </div>
                    </div>

                    {{-- Rest of the component remains the same --}}
                    {{-- Description, Quantity Selector, Add to Cart button, and Shipping Info sections stay unchanged --}}
                </div>
            </div>
        </div>
    </div>
</div>