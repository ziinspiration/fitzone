<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 flex items-center">
  <div class="w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
      <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
          <div class="grid md:grid-cols-2">
              <div class="p-8">
                  <div class="mb-8 text-center">
                      <h1 class="text-3xl font-bold text-gray-900">Verify your account</h1>
                      <p class="mt-2 text-sm text-gray-600">
                        Hello {{ Session::get('first_name') }} {{ Session::get('last_name') }}
                      </p>
                  </div>

                  <form wire:submit.prevent="verifyOtp" class="space-y-6">
                    @csrf
                    <input
                        type="hidden"
                        name="email"
                        class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white"
                        required
                        value="{{ $email ?? old('email') }}"
                        readonly
                    >

                    <div class="space-y-2">
                        <label for="otp" class="block text-sm font-medium text-gray-700">OTP code</label>
                        <div class="relative group">
                            <input
                                wire:model="otp"
                                type="text"
                                name="otp"
                                id="otp"
                                class="block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition duration-150 group-hover:border-gray-300"
                                required
                                placeholder="Enter your OTP code"
                                aria-label="Enter your OTP code"
                                autofocus
                            >
                        </div>
                    </div>


                    <button
                        type="submit"
                        class="w-full py-3 px-4 text-white bg-primary-600 hover:bg-primary-700 rounded-lg font-medium transition duration-150 focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                        wire:loading.class="opacity-75 cursor-wait">
                        <span wire:loading.remove>Verification</span>
                        <span wire:loading>
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Sending code...</span>
                        </span>
                    </button>
                </form>

                <form wire:submit.prevent="resendOtp" class="flex justify-center mt-3">
                    @csrf
                    <input
                        type="hidden"
                        name="email"
                        class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white"
                        required
                        value="{{ $email ?? old('email') }}"
                        readonly
                    >

                    <p class="text-sm"> Didn't get the code?
                        <button type="submit" class="text-sm text-primary-600 hover:text-primary-500 transition duration-150 underline">Resend the code</button>
                    </p>
                </form>
              </div>

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
      @if (session()->has('success'))
      <div class="mt-6 bg-green-100 p-4 rounded-lg text-green-800 shadow-md">
          <div class="flex items-center">
              <svg class="w-6 h-6 mr-2 text-green-600" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path d="M9 12l2 2l4 -4"></path>
              </svg>
              <span class="font-semibold">{{ session('success') }}</span>
          </div>
      </div>
    @endif

    @if (session()->has('error'))
      <div class="mt-6 bg-red-100 p-4 rounded-lg text-red-800 shadow-md">
          <div class="flex items-center">
              <svg class="w-6 h-6 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
              </svg>
              <span class="font-semibold">{{ session('error') }}</span>
          </div>
      </div>
    @endif
    </div>
  </div>


