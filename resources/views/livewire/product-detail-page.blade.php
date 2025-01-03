<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm overflow-hidden mt-10">
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

                    <div class="mb-8">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                            Select Size
                        </label>
                        <div class="flex flex-wrap gap-2">
                            <button 
                                type="button" 
                                class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"
                                :class="{ 'bg-primary-700 text-white dark:bg-primary-600 dark:text-white': selectedSize === '36' }"
                                @click="selectedSize = '36'">
                                36
                            </button>
                            <button 
                                type="button" 
                                class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"
                                :class="{ 'bg-primary-700 text-white dark:bg-primary-600 dark:text-white': selectedSize === '37' }"
                                @click="selectedSize = '37'">
                                37
                            </button>
                            <button 
                                type="button" 
                                class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"
                                :class="{ 'bg-primary-700 text-white dark:bg-primary-600 dark:text-white': selectedSize === '38' }"
                                @click="selectedSize = '38'">
                                38
                            </button>
                            <button 
                                type="button" 
                                class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"
                                :class="{ 'bg-primary-700 text-white dark:bg-primary-600 dark:text-white': selectedSize === '39' }"
                                @click="selectedSize = '39'">
                                39
                            </button>
                            <button 
                                type="button" 
                                class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"
                                :class="{ 'bg-primary-700 text-white dark:bg-primary-600 dark:text-white': selectedSize === '40' }"
                                @click="selectedSize = '40'">
                                40
                            </button>
                            <button 
                                type="button" 
                                class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"
                                :class="{ 'bg-primary-700 text-white dark:bg-primary-600 dark:text-white': selectedSize === '41' }"
                                @click="selectedSize = '41'">
                                41
                            </button>
                            <button 
                                type="button" 
                                class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"
                                :class="{ 'bg-primary-700 text-white dark:bg-primary-600 dark:text-white': selectedSize === '42' }"
                                @click="selectedSize = '42'">
                                42
                            </button>
                        </div>
                    </div>
                    


                    {{-- Add to Cart --}}
                    <button wire:click="addToCart({{ $product->id }})"
                        @if (!auth()->check())
                            wire:click.prevent="redirectToLogin"
                            disabled
                        @endif
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
                            <span class="text-sm text-gray-600 dark:text-gray-400">Shipping using POS Indonesia & Jne</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Product Reviews --}}
            <div class="max-w-6xl mx-auto px-4 mt-8 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
                    {{-- Reviews Header --}}
                    <div class="border-b pb-4">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Product Reviews</h2>
                        <div class="mt-4 flex items-center gap-6">
                            {{-- Average Rating --}}
                            <div class="flex items-center gap-3">
                                <span class="text-3xl font-bold text-gray-900 dark:text-white">4.9</span>
                                <div>
                                    <div class="flex text-yellow-400">
                                        @for ($i = 0; $i < 5; $i++)
                                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">238 reviews</span>
                                </div>
                            </div>
                            {{-- Rating Distribution --}}
                            <div class="flex-1 space-y-2">
                                @foreach ([5, 4, 3, 2, 1] as $star)
                                    <div class="flex items-center gap-2 text-sm">
                                        <span class="w-6 text-gray-700 dark:text-gray-300">{{ $star }}</span>
                                        <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                            <div class="h-full bg-primary-700" style="width: {{ $star * 20 }}%;"></div>
                                        </div>
                                        <span class="w-8 text-right text-gray-700 dark:text-gray-300">{{ $star * 20 }}%</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Filter Section --}}
                    <div class="py-4 border-b">
                        <div class="flex gap-3">
                            <button class="px-4 py-2 border rounded-full text-sm font-medium text-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 dark:text-gray-300">All</button>
                            <button class="px-4 py-2 border rounded-full text-sm font-medium text-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 dark:text-gray-300">⭐ 5</button>
                            <button class="px-4 py-2 border rounded-full text-sm font-medium text-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 dark:text-gray-300">With Photos</button>
                        </div>
                    </div>

                    {{-- Review List --}}
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        {{-- Single Review --}}
                        <div class="py-6">
                            <div class="flex items-center justify-between mb-2">
                                {{-- Reviewer Information --}}
                                <div class="flex items-center gap-3">
                                    <img src="https://images.unsplash.com/photo-1568602471122-7832951cc4c5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=300&h=300&q=80" class="w-10 h-10 rounded-full" alt="Reviewer">
                                    <span class="font-medium text-gray-900 dark:text-white">John D.</span>
                                </div>
                                {{-- Rating Stars --}}
                                <div class="flex text-yellow-400">
                                    @for ($i = 0; $i < 5; $i++)
                                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                            <div class="text-gray-600 dark:text-gray-400 text-sm mb-2">
                                Dec 12, 2023 | Variation: Black
                            </div>
                            <p class="text-gray-900 dark:text-gray-200 mb-4">
                                The product matches the description, and the shipping was fast. Highly recommended seller!
                            </p>

                            
                            <div x-data="{ isPreviewOpen: false, previewImage: '' }">
                                <div class="flex gap-2 mb-4">
                                    <!-- Thumbnail Images -->
                                    <img 
                                        src="https://www.adidas.co.id/media/catalog/product/i/f/if3502_6_footwear_photography_front20lateral20top20view_grey.jpg" 
                                        class="w-20 h-20 rounded-md object-cover cursor-pointer" 
                                        alt="Review Image"
                                        @click="isPreviewOpen = true; previewImage = $event.target.src"
                                    >
                                    <img 
                                        src="https://www.adidas.co.id/media/catalog/product/i/f/if3502_2_footwear_photography_side20lateral20view_grey.jpg" 
                                        class="w-20 h-20 rounded-md object-cover cursor-pointer" 
                                        alt="Review Image"
                                        @click="isPreviewOpen = true; previewImage = $event.target.src"
                                    >
                                </div>
                            
                                <!-- Modal for Image Preview -->
                                <div 
                                    x-show="isPreviewOpen" 
                                    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-75 z-50"
                                    x-cloak
                                >
                                    <div class="relative">
                                        <!-- Close Button -->
                                        <button 
                                            class="absolute top-2 right-2 text-dark text-xl" 
                                            @click="isPreviewOpen = false"
                                        >
                                            &times;
                                        </button>
                                        <!-- Full Image -->
                                        <img 
                                            :src="previewImage" 
                                            class="max-w-full max-h-[90vh] rounded-md"
                                            alt="Full Preview"
                                        >
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4 text-gray-600 dark:text-gray-400 text-sm">
                                <button class="flex items-center gap-1 hover:text-gray-900 dark:hover:text-white">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
                                    </svg>
                                    Helpful
                                </button>
                            </div>
                        </div>
                        {{-- Repeat Review Item as Needed --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
