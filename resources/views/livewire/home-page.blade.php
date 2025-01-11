<div class="bg-white">
    {{-- Hero Section Start V.2 with Carousel --}}
    <section
        x-data="carousel()"
        x-init="startCarousel()"
        class="bg-white dark:bg-gray-900 pt-20 relative">
        <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
            <div class="mr-auto place-self-center lg:col-span-7">
                <h2 class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl dark:text-white">
                    With <span class="text-primary-700">FitZone</span>, Discover Quality Shoes at Affordable Prices!
                </h2>
                <a href="/products" class="inline-flex items-center justify-center px-5 py-3 mr-3 text-base font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:focus:ring-primary-900">
                    Shop Now!
                    <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </a>
                <a href="#" class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-gray-900 border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                    Speak to Sales
                </a>
            </div>
            <div class="hidden lg:mt-0 lg:col-span-5 lg:flex relative h-[600px] overflow-hidden">
                <div class="relative w-full h-full">
                    <template x-for="(image, index) in images" :key="index">
                        <img
                            x-show="currentIndex === index"
                            x-transition:enter="transition transform duration-700 ease-in-out"
                            x-transition:enter-start="opacity-0 translate-y-full"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition transform duration-700 ease-in-out"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-full"
                            :src="image"
                            alt="Shoe Image"
                            class="w-full h-auto object-contain"
                        >
                    </template>
                </div>
            </div>
        </div>
        </section>

        <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        <script>
        function carousel() {
            return {
                images: [
                    'https://www.adidas.co.id/media/catalog/product/j/i/ji1458_2_footwear_photography_side20lateral20view_grey.jpg',
                    'https://www.adidas.co.id/media/catalog/product/i/f/if3502_2_footwear_photography_side20lateral20view_grey.jpg',
                    'https://www.adidas.co.id/media/catalog/product/j/i/ji1547_2_footwear_photography_side20lateral20view_grey.jpg'
                ],
                currentIndex: 0,
                carouselInterval: null,
                startCarousel() {
                    this.carouselInterval = setInterval(() => {
                        this.currentIndex = (this.currentIndex + 1) % this.images.length;
                    }, 3000); // Change image every 3 seconds
                },
                stopCarousel() {
                    clearInterval(this.carouselInterval);
                }
            }
        }
    </script>
    {{-- Hero Section End V.2 --}}

    <main class="max-w-7xl mx-auto px-4">
        <!-- Don't Miss Section -->
        <h2 class="text-2xl font-bold mt-8 mb-6">Don't Miss</h2>

        <!-- Product Showcase -->
        <div class="space-y-8">
            <!-- Full Width Image -->
            <div class="aspect-[16/9] w-full">
                <img
                    src="https://static.nike.com/a/images/f_auto/dpr_1.1,cs_srgb/h_2175,c_limit/7c6be620-7bd5-490f-8efa-c29b89d8a97d/nike-just-do-it.jpg"
                    alt="Air Jordan 4RM showcase with lifestyle and product shots"
                    class="w-full h-full object-cover"
                >
            </div>

            <!-- Product Info -->
            <div class="text-center space-y-4 max-w-2xl mx-auto">
                <p class="text-sm font-medium">Men's Air Jordan 4RM</p>
                <h1 class="text-6xl font-black tracking-tight">RIDE EASY</h1>
                <p class="text-lg">A new take on the iconic style, the 4RM puts bold colour blocking in a comfortable low profile.</p>

                <!-- Shop Button -->
                <div class="pt-4">
                    <a href="#" class="inline-block bg-black text-white px-8 py-2 rounded-full hover:bg-gray-800 transition-colors">
                        Shop
                    </a>
                </div>
            </div>
        </div>
    </main>




    <!-- Brand Logos Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mt-10" x-data="{ activeSlide: 0 }">
        <!-- Section Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold">Our Premium Brands</h2>

            <div class="flex items-center gap-2">
                <button @click="$refs.productCarousel.scrollLeft -= $refs.productCarousel.clientWidth" class="bg-white rounded-full p-2 shadow-lg hover:bg-gray-50 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button @click="$refs.productCarousel.scrollLeft += $refs.productCarousel.clientWidth" class="bg-white rounded-full p-2 shadow-lg hover:bg-gray-50 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Brand Logo Horizontal Scroll -->
        <div class="relative overflow-hidden">
            <div x-ref="productCarousel" class="flex gap-20 overflow-x-auto snap-x snap-mandatory scrollbar-hide scroll-smooth">
                @foreach ($brands as $brand)
                    <a href="/products?selected_brands[0]={{ $brand->id }}"
                    class="w-32 h-32 flex-shrink-0 flex items-center justify-center group transition-transform duration-300 hover:-translate-y-1">
                        <img src="{{ url('storage', $brand->image) }}"
                            alt="{{ $brand->name }}"
                            class="w-32 h-auto object-contain opacity-60 transition-opacity duration-300 group-hover:opacity-100">
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    <!-- End Brand Logos Section -->



    {{-- New Arrival --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mt-10" x-data="{ activeSlide: 0 }">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold">New Arrivals</h2>
            <div class="flex items-center gap-2">
                <button @click="$refs.productCarousel.scrollLeft -= $refs.productCarousel.clientWidth"
                        class="bg-white rounded-full p-2 shadow-lg hover:bg-gray-50 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button @click="$refs.productCarousel.scrollLeft += $refs.productCarousel.clientWidth"
                        class="bg-white rounded-full p-2 shadow-lg hover:bg-gray-50 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Product Carousel -->
        <div class="relative overflow-hidden">
            <div x-ref="productCarousel"
                 class="flex gap-6 overflow-x-auto snap-x snap-mandatory scrollbar-hide scroll-smooth">
                @foreach ($newArrivalProducts as $na)
                <div wire:key="{{ $na->id }}"
                     class="flex-none w-full md:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)] snap-start">
                    <a href="/products/{{ $na->slug }}">
                        <div class="relative mb-4 pb-[100%]">
                            <img src="{{ url('storage', $na->images) }}"
                                 alt="{{ $na->name }}"
                                 class="absolute inset-0 w-full h-full object-cover">
                        </div>
                        <div class="h-14 mb-1">
                            <h3 class="font-medium line-clamp-2 text-[length:var(--dynamic-font-size,1.125rem)]"
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
                                {{ $na->name }}
                            </h3>
                        </div>
                        <div class="h-6">
                            <p class="text-gray-600 text-sm mb-2 truncate">{{ $na->category->name }}</p>
                        </div>
                        <p class="font-medium">{{ Number::currency($na->price, 'IDR') }}</p>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    {{-- End New Arrival --}}


    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mt-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">
            <div class="relative overflow-hidden group">
                <div class="aspect-w-16 aspect-h-9">
                    <img src="https://www.adidas.co.id/media/scandiweb/slider/n/a/nav-men-d_tcm207-819364_2.jpg"
                         alt="Men's Category" class="object-cover w-full h-full">
                </div>
            </div>

            <div class="relative overflow-hidden group">
                <div class="aspect-w-16 aspect-h-9">
                    <img src="https://www.adidas.co.id/media/scandiweb/slider/n/a/nav-kids-d_tcm207-819367_2.jpg"
                         alt="Kids Category" class="object-cover w-full h-full">
                </div>
            </div>

            <div class="relative overflow-hidden group">
                <div class="aspect-w-16 aspect-h-9">
                    <img src="https://www.adidas.co.id/media/scandiweb/slider/n/a/nav-women-d_tcm207-819363_2.jpg"
                         alt="Women's Category" class="object-cover w-full h-full">
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @forelse ($showcaseProducts as $sp)
                <div wire:key="{{ $sp->id }}" class="group">
                    <a href="/products/{{ $sp->slug }}">
                        <div class="mb-2 w-full h-32 overflow-hidden">
                            <img src="{{ isset($sp->images[0]) ? url('storage', $sp->images[0]) : url('images/default-product.jpg') }}"
                                 alt="{{ $sp->name }}"
                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                        </div>
                        <h3 class="text-center uppercase text-sm font-bold tracking-wider">{{ $sp->name }}</h3>
                    </a>
                </div>
            @empty
                <div class="col-span-4 text-center py-8 text-gray-500 dark:text-gray-400">
                    No showcase products available
                </div>
            @endforelse
        </div>
    </div>



    {{-- On Sale --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ activeSlide: 0 }">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold">On Sale</h2>
            <div class="flex items-center gap-2">
                <button @click="$refs.productCarousel.scrollLeft -= $refs.productCarousel.clientWidth"
                        class="bg-white rounded-full p-2 shadow-lg hover:bg-gray-50 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button @click="$refs.productCarousel.scrollLeft += $refs.productCarousel.clientWidth"
                        class="bg-white rounded-full p-2 shadow-lg hover:bg-gray-50 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Product Carousel -->
        <div class="relative overflow-hidden">
            <div x-ref="productCarousel"
                 class="flex gap-6 overflow-x-auto snap-x snap-mandatory scrollbar-hide scroll-smooth">
                @forelse($onSaleProducts as $product)
                    <div wire:key="{{ $product->id }}"
                         class="flex-none w-full md:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)] snap-start">
                        <a href="/products/{{ $product->slug }}">
                            <div class="relative mb-4 pb-[100%]"> <!-- This creates the square aspect ratio -->
                                <img src="{{ isset($product->images[0]) ? url('storage', $product->images[0]) : url('images/default-product.jpg') }}"
                                     alt="{{ $product->name }}"
                                     class="absolute inset-0 w-full h-full object-cover">
                            </div>
                            <h3 class="font-medium line-clamp-2 text-[length:var(--dynamic-font-size,1.125rem)]"
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
                                {{ $na->name }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-2">{{ $product->category?->name }}</p>
                            <p class="font-medium">{{ Number::currency($product->price, 'IDR') }}</p>
                        </a>
                    </div>
                @empty
                    <div class="col-span-4 text-center py-8 text-gray-500 dark:text-gray-400">
                        No on sale products available
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    {{-- End On Sale --}}



    <!-- Member Benefits Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 bg-white">
        <div class="relative" x-data="{ activeSlide: 0 } ">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold">Member Benefits</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">
                <!-- Member Product Card -->
                <div class="relative aspect-[5/7] group overflow-hidden">
                    <img src="https://static.nike.com/a/images/f_auto/dpr_0.9,cs_srgb/h_710,c_limit/cb28c551-b85b-479f-8fc3-40ad4e7c9ca4/nike-just-do-it.jpg"
                         alt="Member Product"
                         class="w-full h-full object-cover">
                    <div class="absolute bottom-0 left-0 right-0 p-8 bg-gradient-to-t from-black/60">
                        <span class="text-white text-sm mb-2 block">Member Product</span>
                        <h3 class="text-white text-2xl font-medium mb-4">Your Exclusive Access</h3>
                    </div>
                </div>

                <!-- Fitzone by You Card -->
                <div class="relative aspect-[5/7] group overflow-hidden">
                    <img src="https://static.nike.com/a/images/f_auto/dpr_0.9,cs_srgb/h_710,c_limit/100ca749-1a94-4f98-bc43-a58e7e9cdbcf/nike-just-do-it.png"
                         alt="Fitzone by You"
                         class="w-full h-full object-cover">
                    <div class="absolute bottom-0 left-0 right-0 p-8 bg-gradient-to-t from-black/60">
                        <span class="text-white text-sm mb-2 block">Fitzone by You</span>
                        <h3 class="text-white text-2xl font-medium mb-4">Your Customisation Service</h3>
                    </div>
                </div>

                <!-- Member Rewards Card -->
                <div class="relative aspect-[5/7] group overflow-hidden">
                    <img src="https://static.nike.com/a/images/f_auto/dpr_0.9,cs_srgb/h_710,c_limit/39412611-0af5-4770-8c2e-ef5c23bc6a3d/nike-just-do-it.jpg"
                         alt="Member Rewards"
                         class="w-full h-full object-cover">
                    <div class="absolute bottom-0 left-0 right-0 p-8 bg-gradient-to-t from-black/60">
                        <span class="text-white text-sm mb-2 block">Member Rewards</span>
                        <h3 class="text-white text-2xl font-medium mb-4">How We Say Thank You</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Member Benefits Section -->

    <style>
        /* Hide scrollbar but keep functionality */
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
    </style>

</div>
