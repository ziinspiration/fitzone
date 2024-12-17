{{-- Category Section Start --}}
<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto mt-20">
    <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 sm:gap-6">

        @foreach ($categories as $category)
            <a class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md transition
                dark:bg-slate-900 dark:border-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                href="/products?selected_categories[0]={{ $category->id }}" wire:key='{{ $category->id }}'>
                <div class="p-4 md:p-5">
                    <div class="flex items-center">
                        <img class="h-[5rem] w-[5rem]" src="{{ url('storage', $category->image) }}"
                            alt="{{ $category->name }}">
                        <div class="ms-3">
                            <h3 class="group-hover:text-blue-600 text-2xl font-semibold text-gray-800
                                dark:group-hover:text-gray-400 dark:text-gray-200">
                                {{ $category->name }}
                            </h3>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach

    </div>
</div>
{{-- Category Section End --}}


