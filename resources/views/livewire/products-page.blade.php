<div class="min-h-screen bg-gray-50 dark:bg-gray-900 mt-10">
    <div class="mx-auto max-w-[90rem] px-4 py-8 sm:px-6 lg:px-8 ">
        <div class="rounded-2xl bg-white p-6 shadow-sm dark:bg-gray-800 mt-10">
            <h1 class="text-5xl font-bold dark:text-gray-200 mb-5"> Browse Product with <span class="text-primary-700">FitZone
            </span> </h1>
            <div class="flex flex-col gap-8 lg:flex-row">
                {{-- Filters Sidebar --}}
                <div class="lg:w-1/4">
                    <div class="space-y-6">
                        {{-- Categories Filter --}}
                        <div class="rounded-xl bg-gray-50 p-5 dark:bg-gray-900">
                            <div class="mb-4 flex items-center justify-between">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Categories</h3>
                                <svg class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="space-y-3">
                                @foreach ($categories as $category)
                                    <label class="flex items-center gap-3" wire:key="{{ $category->id }}">
                                        <input type="checkbox" wire:model.live="selected_categories" 
                                            value="{{ $category->id }}" 
                                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $category->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Brands Filter --}}
                        <div class="rounded-xl bg-gray-50 p-5 dark:bg-gray-900">
                            <div class="mb-4 flex items-center justify-between">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Brands</h3>
                                <svg class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="space-y-3">
                                @foreach ($brands as $brand)
                                    <label class="flex items-center gap-3" wire:key="{{ $brand->id }}">
                                        <input type="checkbox" wire:model.live="selected_brands" 
                                            value="{{ $brand->id }}" 
                                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $brand->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Product Status --}}
                        <div class="rounded-xl bg-gray-50 p-5 dark:bg-gray-900">
                            <div class="mb-4 flex items-center justify-between">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Product Status</h3>
                                <svg class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="space-y-3">
                                <label class="flex items-center gap-3">
                                    <input type="checkbox" wire:model.live="featured" value="1" 
                                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Featured Products</span>
                                </label>
                                <label class="flex items-center gap-3">
                                    <input type="checkbox" wire:model.live="on_sale" value="1" 
                                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">On Sale</span>
                                </label>
                            </div>
                        </div>

                        {{-- Price Range --}}
                        <div class="rounded-xl bg-gray-50 p-5 dark:bg-gray-900">
                            <div class="mb-4 flex items-center justify-between">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Price Range</h3>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ Number::currency($price_range, 'IDR') }}
                                </span>
                                <input type="range" wire:model.live="price_range"
                                    class="mt-2 w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
                                    min="0" max="50000000" step="100000">
                                <div class="mt-2 flex justify-between text-xs text-gray-600 dark:text-gray-400">
                                    <span>{{ Number::currency(0, 'IDR') }}</span>
                                    <span>{{ Number::currency(50000000, 'IDR') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Products Grid --}}
                <div class="lg:w-3/4">
                    {{-- Sort Bar --}}
                    <div class="mb-6 flex items-center justify-between rounded-xl bg-gray-50 p-4 dark:bg-gray-900">
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            Showing {{ $products->count() }} products
                        </span>
                        <select wire:model.live="sort" 
                            class="rounded-lg border-0 bg-white px-4 py-2 text-sm shadow-sm dark:bg-gray-800 dark:text-gray-200">
                            <option value="latest">Sort by latest</option>
                            <option value="price_low">Price: Low to High</option>
                            <option value="price_high">Price: High to Low</option>
                            <option value="name">Name</option>
                        </select>
                    </div>

                    {{-- Products Grid --}}
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($products as $product)
                            <div wire:key="{{ $product->id }}" class="group">
                                <div class="overflow-hidden rounded-2xl bg-white shadow-lg transition-shadow hover:shadow-xl dark:bg-gray-800">
                                    {{-- Image Container --}}
                                    <div class="relative aspect-square">
                                        <img src="{{ !empty($product->images) ? url('storage', $product->images[0]) : url('path/to/default/image.jpg') }}"
                                            alt="{{ $product->name }}"
                                            class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                                        
                                        {{-- Badges --}}
                                        @if($product->featured)
                                            <span class="absolute left-2 top-2 rounded-full bg-indigo-600 px-2 py-1 text-xs text-white">
                                                Featured
                                            </span>
                                        @endif
                                        @if($product->on_sale)
                                            <span class="absolute right-2 top-2 rounded-full bg-rose-600 px-2 py-1 text-xs text-white">
                                                Sale
                                            </span>
                                        @endif

                                        {{-- Quick Actions --}}
                                        <div class="absolute inset-0 flex items-center justify-center gap-3 bg-black/40 opacity-0 backdrop-blur-sm transition-opacity group-hover:opacity-100">
                                            <a href="/products/{{ $product->slug }}" 
                                                class="rounded-full bg-white p-2 text-gray-900 transition-transform hover:scale-110 dark:bg-gray-800 dark:text-white">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <button class="rounded-full bg-white p-2 text-gray-900 transition-transform hover:scale-110 dark:bg-gray-800 dark:text-white">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    {{-- Content --}}
                                    <div class="p-4">
                                        <h3 class="mb-2 text-lg font-medium text-gray-900 dark:text-white">
                                            {{ $product->name }}
                                        </h3>
                                        <div class="mb-4 text-xl font-bold text-emerald-600 dark:text-emerald-400">
                                            {{ Number::currency($product->price, 'IDR') }}
                                        </div>
                                        <button wire:click="addToCart({{ $product->id }})"
                                            class="flex w-full items-center justify-center gap-2 rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600">
                                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                            <span wire:loading.remove wire:target="addToCart({{ $product->id }})">
                                                Add to Cart
                                            </span>
                                            <span wire:loading wire:target="addToCart({{ $product->id }})">
                                                Adding...
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach 
                    </div>


                    {{-- Pagination --}}
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>