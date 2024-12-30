<div class="bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 ">
    
    <div class="max-w-[85rem] px-6 py-12 mx-auto">
        <h5 class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl dark:text-white mt-5">
            <span class="text-primary-700">
                FitZone
            </span>Category
        </h5>
        <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mt-10">
            @foreach ($categories as $category)
                <a wire:key='{{ $category->id }}' 
                   href="/products?selected_categories[0]={{ $category->id }}"
                   class="group bg-white dark:bg-gray-800 rounded-xl overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700">
                    
                    <div class="relative h-48 overflow-hidden">
                        <img class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500" 
                             src="{{ url('storage', $category->image) }}"
                             alt="{{ $category->name }}"
                             onerror="this.src='/images/placeholder.jpg'">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6">
                            <h3 class="text-2xl font-bold text-white mb-1">
                                {{ $category->name }}
                            </h3>
                            <p class="text-gray-200 text-sm">
                                View Collection →
                            </p>
                        </div>
                    </div>

                </a>
            @endforeach
        </div>
    </div>
</div>