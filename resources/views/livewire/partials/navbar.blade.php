<header class="flex z-50 sticky top-0 flex-wrap md:justify-start md:flex-nowrap w-full bg-white text-sm py-3 md:py-0 dark:bg-gray-800 shadow-md mb-8">
  <nav class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 start-0 border-b border-gray-200 dark:border-gray-600 mb-8">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
      <!-- Logo -->
      <a href="https://flowbite.com/" class="flex items-center space-x-3 rtl:space-x-reverse">
        <span class="self-center text-3xl font-bold whitespace-nowrap dark:text-white">
          <img src="{{ asset('images/fitzone-logo.png') }}" alt="Fitzone Logo" class="h-12 w-auto">
        </span>
      </a>

      <!-- Profile & Mobile Menu -->
      <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
        @auth
          <!-- Profile Dropdown - Visible di mobile & desktop -->
          <div class="hs-dropdown relative inline-flex">
            <!-- Profile Button -->
            <button id="hs-dropdown-custom-trigger" type="button" class="border border-primary-700 hs-dropdown-toggle py-1 ps-1 pe-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-full border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50">
              <div class="shrink-0 group block">
                <div class="flex items-center">
                  @if(auth()->user()->avatar)
                    <img class="inline-block shrink-0 w-10 h-10 rounded-full" src="{{ Storage::url(auth()->user()->avatar) }}" alt="Avatar">
                  @else
                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                      <span class="text-2xl font-bold text-gray-500">{{ substr(auth()->user()->full_name, 0, 1) }}</span>
                    </div>
                  @endif
                  <!-- Nama hanya tampil di desktop -->
                  <div class="ms-3 hidden md:block">
                    <h3 class="font-semibold text-gray-800 dark:text-white text-left">{{ auth()->user()->name }}</h3>
                    <p class="text-sm font-medium text-gray-400 dark:text-neutral-500 text-left">{{ auth()->user()->full_name }}</p>
                  </div>
                </div>
              </div>
              <svg class="hs-dropdown-open:rotate-180 size-4 hidden md:block" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
            </button>

            <!-- Dropdown Menu -->
            <div class="hs-dropdown-menu transition-all duration-300 opacity-0 hidden min-w-60 bg-white shadow-md rounded-lg mt-2 dark:bg-neutral-800 dark:border dark:border-neutral-700" role="menu">
              <!-- Menu Mobile - Hanya tampil di mobile -->
              <div class="md:hidden px-3 py-2 border-b border-gray-200">
                <a href="/" class="block py-2 text-gray-900 hover:text-primary-700">Home</a>
                <a href="/categories" class="block py-2 text-gray-900 hover:text-primary-700">Categories</a>
                <a href="/products" class="block py-2 text-gray-900 hover:text-primary-700">Products</a>
                <a href="/cart" class="flex items-center py-2 text-gray-900 hover:text-primary-700">
                  Cart
                  <span class="ml-2 py-0.5 px-1.5 rounded-full text-xs font-medium bg-blue-50 border border-primary-700 text-primary-700">{{ $total_count }}</span>
                </a>
              </div>
              <!-- Profile Menu - Tampil di mobile & desktop -->
              <div class="p-1 space-y-0.5">
                <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100" href="/my-orders">My Orders</a>
                <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100" href="/my-account">My Account</a>
                <form action="{{ route('logout') }}" method="POST">
                  @csrf
                  <button type="submit" class="w-full text-left flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100">Logout</button>
                </form>
              </div>
            </div>
          </div>
        @else
          <a href="/signin">
            <button type="button" class="flex items-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center">
              <svg class="flex-shrink-0 w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                <circle cx="12" cy="7" r="4" />
              </svg>
              Sign in
            </button>
          </a>
        @endauth
      </div>

      <!-- Desktop Navigation Menu -->
      <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
        <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
          <li>
            <a href="/" class="block py-2 px-3 {{ request()->is('/') ? 'text-primary-700' : 'text-gray-900' }} rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-primary-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Home</a>
          </li>
          <li>
            <a href="/categories" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-primary-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Categories</a>
          </li>
          <li>
            <a href="/products" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-primary-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Products</a>
          </li>
          <li class="relative">
            <a href="/cart" class="flex items-center py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-primary-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="flex-shrink-0 w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
              </svg>
              <span class="ml-2">Cart</span>
              <span class="ml-2 py-0.5 px-1.5 rounded-full text-xs font-medium bg-blue-50 border border-primary-700 text-primary-700">{{ $total_count }}</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Inisialisasi dropdown
  const dropdownTrigger = document.getElementById('hs-dropdown-custom-trigger');
  const dropdownMenu = dropdownTrigger.nextElementSibling;
  
  dropdownTrigger.addEventListener('click', function() {
    const isOpen = dropdownMenu.classList.contains('opacity-100');
    
    if (isOpen) {
      dropdownMenu.classList.remove('opacity-100');
      dropdownMenu.classList.add('opacity-0');
      setTimeout(() => {
        dropdownMenu.classList.add('hidden');
      }, 300);
    } else {
      dropdownMenu.classList.remove('hidden');
      setTimeout(() => {
        dropdownMenu.classList.remove('opacity-0');
        dropdownMenu.classList.add('opacity-100');
      }, 10);
    }
  });

  // Tutup dropdown ketika klik di luar
  document.addEventListener('click', function(event) {
    if (!dropdownTrigger.contains(event.target) && !dropdownMenu.contains(event.target)) {
      dropdownMenu.classList.remove('opacity-100');
      dropdownMenu.classList.add('opacity-0');
      setTimeout(() => {
        dropdownMenu.classList.add('hidden');
      }, 300);
    }
  });

  // Inisialisasi hamburger menu untuk desktop
  const hamburgerButton = document.querySelector('[data-collapse-toggle="navbar-sticky"]');
  const navbarMenu = document.getElementById('navbar-sticky');
  
  hamburgerButton.addEventListener('click', function() {
    const expanded = this.getAttribute('aria-expanded') === 'true';
    this.setAttribute('aria-expanded', !expanded);
    navbarMenu.classList.toggle('hidden');
  });
});
</script>