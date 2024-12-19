<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="flex h-full items-center">
      <main class="w-full max-w-md mx-auto p-6">
        <div class="mt-7 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
          <div class="p-4 sm:p-7">
            <div class="text-center">
              <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">Forgot password?</h1>
              <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Remember your password?
                <a class="text-blue-600 decoration-2 hover:underline font-medium dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="/login">
                  Sign in here
                </a>
              </p>
            </div>

            @if(session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mt-5">
              <!-- Form -->
              <form wire:submit.prevent="sendResetLink">
                @csrf
                <div class="grid gap-y-4">
                  <!-- Form Group -->
                  <div>
                    <label for="email" class="block text-sm mb-2 dark:text-white">Email address</label>
                    <div class="relative">
                      <input type="email"
                      wire:model="email"
                      name="email"
                      id="email" class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" required aria-describedby="email-error"  placeholder="Masukkan email Anda"
                      value="{{ old('email') }}"
                      required>
                      @error('email')
                        <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                      @enderror
                    </div>
                  </div>
                  <!-- End Form Group -->
                  <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">Reset password</button>
                </div>
              </form>
              <!-- End Form -->
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
