<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="flex h-full items-center">
      <main class="w-full max-w-md mx-auto p-6">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
          <div class="p-4 sm:p-7">
            <div class="text-center">
              <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">Sign in</h1>
              <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Don't have an account yet?
                <a wire:navigate class="text-blue-600 decoration-2 hover:underline font-medium dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="/register">
                  Sign up here
                </a>
              </p>
            </div>
  
            <hr class="my-5 border-slate-300">
  
            <!-- Form -->
            <form wire:submit.prevent='save'>

              @if (session('error'))
              <div class="mt-4 mb-5 p-4 bg-red-100 border border-red-300 text-red-700 rounded-lg shadow-sm flex items-start" role="alert" tabindex="-1" aria-labelledby="error-alert-title">
                <svg class="w-6 h-6 mr-3 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-.75-11.25a.75.75 0 011.5 0v3.5a.75.75 0 01-1.5 0v-3.5zm.75 6.5a.875.875 0 100-1.75.875.875 0 000 1.75z" clip-rule="evenodd" />
                </svg>
                <div>
                  <span id="error-alert-title" class="font-semibold text-lg">Error!</span>
                  <p class="mt-1 text-sm">{{ session('error') }}</p>
                </div>
              </div>
              @endif

              

              <div class="grid gap-y-4">
                <!-- Form Group -->
                <div>
                  <label for="email" class="block text-sm mb-2 dark:text-white">Email address</label>
                  <div class="relative">
                    <input type="email" id="email" wire:model="email" class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" aria-describedby="email-error">
                    @error('email')
                    <div class="hidden absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                      <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                      </svg>
                    </div>
                    @enderror
                  </div>
                  @error('email')
                  <p class="hidden text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                  @enderror
                </div>
                <!-- End Form Group -->
  
                <!-- Form Group -->
                <div>
                  <div class="flex justify-between items-center">
                    <label for="password" class="block text-sm mb-2 dark:text-white">Password</label>
                    <a class="text-sm text-blue-600 decoration-2 hover:underline font-medium dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="/forgot">Forgot password?</a>
                  </div>
                  <div class="relative">
                    <input type="password" id="password" wire:model="password" class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" aria-describedby="password-error">
                    @error('password')
                    <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                      <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                      </svg>
                    </div>
                    @enderror
                  </div>
                  @error('password')
                  <p class="hidden text-xs text-red-600 mt-2" id="password-error">{{ $message }}</p>
                  @enderror
                </div>
                <!-- End Form Group -->
                <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">Sign in</button>
              </div>
            </form>
            <!-- End Form -->
          </div>
        </div>
    </div>
  </div>