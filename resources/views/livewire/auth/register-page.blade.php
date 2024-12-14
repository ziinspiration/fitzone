<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="flex h-full items-center">
      <main class="w-full max-w-md mx-auto p-6">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
          <div class="p-4 sm:p-7">
            <div class="text-center">
              <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">Sign up</h1>
              <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Already have an account?
                <a class="text-blue-600 decoration-2 hover:underline font-medium dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="/login">
                  Sign in here
                </a>
              </p>
            </div>
            <hr class="my-5 border-slate-300">
            <!-- Form -->
            <form action="{{ route('signup') }}" method="POST">
                @csrf
              <div class="grid gap-y-4">
                <!-- Form Group -->
                <div>
                  <label for="first-name" class="block text-sm mb-2 dark:text-white">Nama depan</label>
                  <input type="text" id="first-name" name="first_name" class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" required>
                </div>

                <div>
                    <label for="last-name" class="block text-sm mb-2 dark:text-white">Nama belakang</label>
                    <input type="text" id="last-name" name="last_name" class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                </div>

                <div>
                  <label for="email" class="block text-sm mb-2 dark:text-white">Alamat email</label>
                  <input type="email" id="email" name="email" class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" required>
                </div>

                <div>
                    <label for="password" class="block text-sm mb-2 dark:text-white">Password</label>
                    <input type="password" id="password" name="password" class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" required>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm mb-2 dark:text-white">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" required>
                </div>

                <div class="mt-4">
                  <button type="submit" class="w-full py-3 px-4 bg-blue-600 text-white rounded-lg text-sm">Daftar</button>
                </div>
              </div>
            </form>
            <!-- End Form -->
          </div>
        </div>
    </div>
  </div>
