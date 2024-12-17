<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="flex h-full items-center">
      <main class="w-full max-w-md mx-auto p-6">
        <div class="mt-7 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
          <div class="p-4 sm:p-7">
            <div class="text-center">
              <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">Reset password</h1>
            </div>

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mt-5">
              <!-- Form -->
              <form wire:submit.prevent="updatePassword">
                <input type="hidden" wire:model="token" value="{{ request()->query('token') }}">
                <input type="hidden" wire:model="email" value="{{ request()->query('email') }}">

                <div class="grid gap-y-4">
                  <!-- Form Group -->
                  <div>
                    <label for="password" class="block text-sm mb-2 dark:text-white">Password</label>
                    <div class="relative">
                      <input type="password"
                             id="password"
                             wire:model="password"
                             class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600"
                             required
                             aria-describedby="password-error">
                      @error('password')
                        <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                      @enderror
                    </div>
                  </div>
                  <!-- End Form Group -->

                  <div>
                    <label for="password_confirmation" class="block text-sm mb-2 dark:text-white">Confirm Password</label>
                    <div class="relative">
                      <input type="password"
                             id="password_confirmation"
                             wire:model="password_confirmation"
                             class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600"
                             required
                             aria-describedby="password_confirmation-error">
                      @error('password_confirmation')
                        <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                      @enderror
                    </div>
                  </div>

                  <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    Save password
                  </button>
                </div>
              </form>
              <!-- End Form -->
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
