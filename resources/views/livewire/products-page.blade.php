<div class="min-h-screen bg-gray-50 dark:bg-gray-900 mt-10">
    <div class="mx-auto max-w-[90rem] px-4 py-8 sm:px-6 lg:px-8 ">
        <div class="rounded-2xl bg-white p-6 shadow-sm dark:bg-gray-800 mt-10">
            <h1 class="text-5xl font-bold dark:text-gray-200 mb-5"> Browse Product with <span class="text-primary-700">FitZone</span></h1>
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
                                        <input type="checkbox" wire:model.live="selected_categories" value="{{ $category->id }}"
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
                    </div>
                </div>

                {{-- Products Grid --}}
                <div class="lg:w-3/4">
                    {{-- Sort and Search Bar --}}
                    <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between rounded-xl bg-gray-50 p-4 dark:bg-gray-900">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input
                                wire:model.live.debounce.300ms="search"
                                type="search"
                                class="w-full rounded-lg border-0 bg-white pl-10 pr-4 py-2 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-gray-200 dark:focus:ring-indigo-600"
                                placeholder="Search products..."
                            >
                        </div>

                        <div class="flex items-center justify-between gap-4">
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
                    </div>

                    @if($products->isEmpty())
                        <div class="flex flex-col items-center justify-center p-8 min-h-[400px] rounded-xl bg-gray-50 dark:bg-gray-900">
                            <div class="w-48 h-48 mb-6">
                                <svg class="w-full h-full text-gray-300 dark:text-gray-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.5 15.5L19 19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    <path d="M5 11C5 14.3137 7.68629 17 11 17C12.6597 17 14.1621 16.3261 15.2483 15.2483C16.3261 14.1621 17 12.6597 17 11C17 7.68629 14.3137 5 11 5C7.68629 5 5 7.68629 5 11Z" stroke="currentColor" stroke-width="2"/>
                                    <path d="M12 8V14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    <path d="M15 11H9" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">No Products Found</h3>
                            <p class="text-gray-500 dark:text-gray-400 text-center mb-6">
                                @if($search)
                                    We couldn't find any products matching "{{ $search }}". <br>
                                @else
                                    No products match the selected filters. <br>
                                @endif
                                Try adjusting your search or filters.
                            </p>
                            <div class="flex gap-4">
                                @if($search)
                                    <button
                                        wire:click="$set('search', '')"
                                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                        Clear Search
                                    </button>
                                @endif
                                @if(!empty($selected_categories) || !empty($selected_brands) || $featured || $on_sale)
                                    <button
                                        wire:click="resetFilters"
                                        class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-800 transition-colors">
                                        Reset Filters
                                    </button>
                                @endif
                            </div>
                        </div>
                    @else
                        {{-- Your existing products grid code --}}
                        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($products as $product)
                            <div wire:key="{{ $product->id }}" class="group">
                                <div class="overflow-hidden rounded-2xl bg-white shadow-lg transition-shadow hover:shadow-xl dark:bg-gray-800">
                                    {{-- Image Container --}}
                                    <div class="relative pb-[100%]">
                                        <img src="{{ !empty($product->images) ? url('storage', $product->images[0]) : url('path/to/default/image.jpg') }}"
                                            alt="{{ $product->name }}"
                                            class="absolute inset-0 h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">

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
                                        </div>
                                    </div>

                                    {{-- Content --}}
                                    <div class="p-4">
                                        <div class="h-14 mb-2"> <!-- Fixed height container for title -->
                                            <h3 class="font-medium text-gray-900 dark:text-white line-clamp-2 text-[length:var(--dynamic-font-size,1.125rem)]"
                                                x-data
                                                x-init="
                                                    const text = $el.textContent;
                                                    const length = text.length;
                                                    if (length > 50) {
                                                        $el.style.setProperty('--dynamic-font-size', '0.875rem');
                                                    } else if (length > 30) {
                                                        $el.style.setProperty('--dynamic-font-size', '1rem');
                                                    }
                                                ">
                                                {{ $product->name }}
                                            </h3>
                                        </div>
                                        <div class="mb-4 text-xl font-bold text-emerald-600 dark:text-emerald-400">
                                            {{ Number::currency($product->price, 'IDR') }}
                                        </div>
                                        <button
                                            @auth
                                                wire:click="addToCart({{ $product->id }})"
                                            @else
                                                wire:click="showLoginAlert"
                                            @endauth
                                                class="flex w-full items-center justify-center gap-2 rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600">
                                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                            @auth
                                                <span wire:loading.remove wire:target="addToCart({{ $product->id }})">
                                                    Add to Cart
                                                </span>
                                                <span wire:loading wire:target="addToCart({{ $product->id }})">
                                                    Adding...
                                                </span>
                                            @else
                                                <span>
                                                    Add to Cart
                                                </span>
                                            @endauth
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
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
