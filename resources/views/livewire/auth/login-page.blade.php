<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 flex items-center">
  <div class="w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
      <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
          <div class="grid md:grid-cols-2">
              <!-- Left: Login Form -->
              <div class="p-8">
                  <div class="mb-8 text-center">
                      <h1 class="text-3xl font-bold text-gray-900">Welcome Back</h1>
                      <p class="mt-2 text-sm text-gray-600">
                          Don't have an account?
                          <a wire:navigate href="/register" class="text-primary-600 hover:text-primary-500 font-medium ml-1 transition duration-150">
                              Create account
                          </a>
                      </p>
                  </div>

                  <form wire:submit.prevent="save" class="space-y-6">
                      @if (session('error'))
                      <div class="p-4 bg-red-50 border border-red-200 rounded-lg flex items-start space-x-3" role="alert">
                          <AlertCircle class="w-5 h-5 text-red-600 flex-shrink-0" />
                          <div class="text-sm text-red-600">{{ session('error') }}</div>
                      </div>
                      @endif

                      <div class="space-y-2">
                          <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                          <div class="relative group">
                              <input 
                                  wire:model="email"
                                  type="email" 
                                  id="email"
                                  class="block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition duration-150 group-hover:border-gray-300"
                                  placeholder="Enter your email"
                              >
                              @error('email')
                              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                              @enderror
                          </div>
                      </div>

                      <div class="space-y-2">
                          <div class="flex justify-between">
                              <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                              <a href="/forgot" class="text-sm text-primary-600 hover:text-primary-500 transition duration-150">
                                  Forgot password?
                              </a>
                          </div>
                          <div class="relative group">
                              <input 
                                  wire:model="password"
                                  type="password" 
                                  id="password"
                                  class="block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition duration-150 group-hover:border-gray-300"
                                  placeholder="Enter your password"
                              >
                              @error('password')
                              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                              @enderror
                          </div>
                      </div>

                      <button 
                          type="submit"
                          class="w-full py-3 px-4 text-white bg-primary-600 hover:bg-primary-700 rounded-lg font-medium transition duration-150 focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                          wire:loading.class="opacity-75 cursor-wait"
                      >
                          <span wire:loading.remove>Sign in</span>
                          <span wire:loading>
                              <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" fill="none" viewBox="0 0 24 24">
                                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                              </svg>
                              Signing in...
                          </span>
                      </button>
                  </form>
              </div>

              <!-- Right: Featured Content -->
              <div class="hidden md:block bg-gradient-to-br from-primary-600 to-primary-700 p-12 text-white">
                  <div class="h-full flex flex-col justify-between">
                      <div class="space-y-6">
                          <h2 class="text-3xl font-bold">Shop With Confidence</h2>
                          <p class="text-primary-100">Access your orders, wishlist, and personalized recommendations.</p>
                      </div>

                      <div class="grid grid-cols-2 gap-6 mt-12">
                          <div class="bg-white/10 backdrop-blur-lg rounded-lg p-4 transform hover:scale-105 transition-transform">
                              <svg class="w-8 h-8 mb-3 text-primary-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                              </svg>
                              <h3 class="font-semibold mb-1">Fast Shipping</h3>
                              <p class="text-sm text-primary-100">Free delivery on eligible orders</p>
                          </div>
                          <div class="bg-white/10 backdrop-blur-lg rounded-lg p-4 transform hover:scale-105 transition-transform">
                              <svg class="w-8 h-8 mb-3 text-primary-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                              </svg>
                              <h3 class="font-semibold mb-1">Secure Shopping</h3>
                              <p class="text-sm text-primary-100">100% secure payment</p>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>