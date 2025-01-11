<div class="bg-white from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 ">
    <div class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <h1 class="text-6xl font-black tracking-tight">Category in <span class="text-primary-700">Fitzone</span></h1>
                <p class="text-gray-600 text-lg mt-5 mb-8">
                    A new take on the iconic style, the 4RM puts bold colour blocking in a comfortable low profile.
                </p>
            </div>
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Swift Collection -->
                <div class="space-y-4">
                    <div class="relative aspect-[4/3] overflow-hidden">
                        <img src="https://static.nike.com/a/images/f_auto/dpr_0.9,cs_srgb/h_1238,c_limit/fda1199f-7b7a-46e7-bca0-f387dcb87d29/nike-just-do-it.jpg" 
                             alt="Nike Swift Collection" 
                             class="object-cover w-full h-full">
                    </div>
                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-300">Run Ready</p>
                        <h2 class="text-xl font-semibold">The Nike Swift Collection</h2>
                    </div>
                </div>
    
                <!-- Stride Collection -->
                <div class="space-y-4">
                    <div class="relative aspect-[4/3] overflow-hidden">
                        <img src="https://static.nike.com/a/images/f_auto/dpr_2.0,cs_srgb/h_716,c_limit/1a43d947-0615-430e-b9db-034eb6ee1cc7/nike-just-do-it.jpg" 
                             alt="Nike Stride Collection" 
                             class="object-cover w-full h-full">
                    </div>
                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-300">Run Ready</p>
                        <h2 class="text-xl font-semibold">The Nike Stride Collection</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Shop By Sport Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-16">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold">Shop By Sport</h2>
            </div>

            <!-- Category -->
            <div class="relative">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Sport Cards -->
                    @foreach ($categories as $category)
                        <div class="relative">
                            <a wire:key='{{ $category->id }}' href="/products?selected_categories[0]={{ $category->id }}">
                                <div class="aspect-w-4 aspect-h-3 rounded-lg overflow-hidden">
                                    <img src="{{ url('storage', $category->image) }}" 
                                        alt="{{ $category->name }}" 
                                        class="w-full h-full object-cover grayscale hover:grayscale-0 transition duration-300">
                                </div>
                                <div class="absolute bottom-4 left-4">
                                    <span class="bg-white px-4 py-2 rounded-full text-black font-medium hover:bg-gray-300 transition">
                                        {{ $category->name }}
                                    </span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- End Category -->

        </div>
    </div>
</div>