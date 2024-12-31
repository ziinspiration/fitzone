<div class="min-h-screen relative flex items-center overflow-hidden bg-gray-50">
  <!-- Enhanced E-commerce Background -->
  <div class="absolute inset-0 z-0 overflow-hidden">
    <!-- Animated Shopping Pattern -->
    <div class="absolute w-full h-full opacity-5">
      <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%239C92AC" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>

    <!-- Dynamic Gradient Blobs -->
    <div class="absolute w-[800px] h-[800px] bg-gradient-to-r from-purple-300/30 to-pink-300/30 rounded-full blur-3xl -top-64 -left-96 animate-blob"></div>
    <div class="absolute w-[800px] h-[800px] bg-gradient-to-r from-indigo-300/30 to-blue-300/30 rounded-full blur-3xl top-96 -right-96 animate-blob animation-delay-2000"></div>
    <div class="absolute w-[600px] h-[600px] bg-gradient-to-r from-pink-300/30 to-yellow-300/30 rounded-full blur-3xl -bottom-64 left-96 animate-blob animation-delay-4000"></div>

    <!-- E-commerce Icons Grid -->
    <div class="absolute inset-0 grid grid-cols-8 grid-rows-8 gap-4 opacity-5">
      <div class="animate-float-slow">📱</div>
      <div class="animate-float-slower">💻</div>
      <div class="animate-float">🛍️</div>
      <div class="animate-float-slow">🎮</div>
      <div class="animate-float-slower">📚</div>
      <div class="animate-float">👕</div>
      <div class="animate-float-slow">⌚</div>
      <div class="animate-float-slower">🎧</div>
    </div>

    <!-- Animated Lines -->
    <div class="absolute inset-0">
      <div class="absolute h-[2px] w-48 bg-gradient-to-r from-transparent via-purple-500/50 to-transparent top-1/4 left-0 animate-slide"></div>
      <div class="absolute h-[2px] w-96 bg-gradient-to-r from-transparent via-blue-500/50 to-transparent bottom-1/3 right-0 animate-slide-delayed"></div>
    </div>
  </div>

  <!-- Content (Keeping original content structure) -->
  <div class="w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative z-10">
    <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl overflow-hidden">
      <div class="grid md:grid-cols-2">
        <!-- Left: Registration Form (keeping original) -->
        <div class="p-8">
          <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-900">Create Your Account</h1>
            <p class="mt-2 text-sm text-gray-600">
              Already have an account?
              <a wire:navigate href="/login" class="text-primary-600 hover:text-primary-500 font-medium ml-1 transition duration-150">
                Sign in here
              </a>
            </p>
          </div>

          <form wire:submit.prevent="save" class="space-y-6">
            <div class="space-y-2">
              <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
              <input wire:model="name" type="text" id="name" class="block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition duration-150" placeholder="Enter your name">
              @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
              <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
              <input wire:model="email" type="email" id="email" class="block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition duration-150" placeholder="Enter your email">
              @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
              <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
              <input wire:model="password" type="password" id="password" class="block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition duration-150" placeholder="Enter your password">
              @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full py-3 px-4 text-white bg-primary-600 hover:bg-primary-700 rounded-lg font-medium transition duration-150">
              <span wire:loading.remove>Sign up</span>
              <span wire:loading>
                <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Creating account...
              </span>
            </button>
          </form>

          <!-- Success Message -->
          <div wire:loading.remove class="mt-6 bg-green-100 p-4 rounded-lg text-green-800 shadow-md">
            <div class="flex items-center">
              <svg class="w-6 h-6 mr-2 text-green-600" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 12l2 2l4 -4"></path>
              </svg>
              <span class="font-semibold">Registration Successful!</span>
            </div>
            <p class="mt-2 text-sm">You have successfully created your account. Start shopping and enjoy exclusive offers!</p>
          </div>
        </div>

        <!-- Right: Enhanced Featured Content -->
        <div class="hidden md:block bg-gradient-to-br from-primary-600 to-primary-700 p-12 text-white">
          <div class="h-full flex flex-col justify-between relative overflow-hidden">
            <!-- Decorative dots -->
            <div class="absolute inset-0 grid grid-cols-6 gap-4 opacity-20">
              <div class="w-2 h-2 rounded-full bg-white animate-pulse"></div>
              <div class="w-2 h-2 rounded-full bg-white animate-pulse delay-100"></div>
              <div class="w-2 h-2 rounded-full bg-white animate-pulse delay-200"></div>
            </div>

            <div class="space-y-6 relative">
              <h2 class="text-3xl font-bold">Join Our Marketplace</h2>
              <p class="text-primary-100">Discover amazing deals and exclusive offers.</p>
            </div>

            <div class="grid grid-cols-2 gap-6 mt-12 relative">
              <div class="bg-white/10 backdrop-blur-lg rounded-lg p-4 transform hover:scale-105 transition-transform">
                <svg class="w-8 h-8 mb-3 text-primary-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <h3 class="font-semibold mb-1">Shop Safely</h3>
                <p class="text-sm text-primary-100">Secure shopping experience.</p>
              </div>
              <div class="bg-white/10 backdrop-blur-lg rounded-lg p-4 transform hover:scale-105 transition-transform">
                <svg class="w-8 h-8 mb-3 text-primary-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="font-semibold mb-1">Easy Returns</h3>
                <p class="text-sm text-primary-100">30-day money back guarantee.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <style>
    @keyframes blob {
      0% { transform: translate(0px, 0px) scale(1); }
      33% { transform: translate(30px, -50px) scale(1.1); }
      66% { transform: translate(-20px, 20px) scale(0.9); }
      100% { transform: translate(0px, 0px) scale(1); }
    }

    @keyframes float {
      0% { transform: translateY(0px); }
      50% { transform: translateY(-20px); }
      100% { transform: translateY(0px); }
    }

    @keyframes slide {
      0% { transform: translateX(-100%); }
      100% { transform: translateX(100%); }
    }

    .animate-blob {
      animation: blob 7s infinite;
    }

    .animate-float {
      animation: float 3s ease-in-out infinite;
    }

    .animate-float-slow {
      animation: float 5s ease-in-out infinite;
    }

    .animate-float-slower {
      animation: float 7s ease-in-out infinite;
    }

    .animate-slide {
      animation: slide 3s linear infinite;
    }

    .animate-slide-delayed {
      animation: slide 3s linear infinite;
      animation-delay: 1.5s;
    }

    .animation-delay-2000 {
      animation-delay: 2s;
    }

    .animation-delay-4000 {
      animation-delay: 4s;
    }
  </style>
</div>
