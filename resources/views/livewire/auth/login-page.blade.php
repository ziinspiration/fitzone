<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Fitzone' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles()
</head>
<body class="bg-slate-200 dark:bg-slate-700">
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
                    <form action="{{ route('login.submit') }}" method="POST">
                        @csrf
                        <div class="grid gap-y-4">
                            <!-- Form Group for Email -->
                            <div>
                                <label for="email" class="block text-sm mb-2 dark:text-white">Email address</label>
                                <div class="relative">
                                    <input type="email" id="email" name="email" class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" required aria-describedby="email-error" value="{{ old('email') }}">
                                    @error('email')
                                    <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <!-- End Form Group for Email -->

                            <!-- Form Group for Password -->
                            <div>
                                <div class="flex justify-between items-center">
                                    <label for="password" class="block text-sm mb-2 dark:text-white">Password</label>
                                    <a class="text-sm text-blue-600 decoration-2 hover:underline font-medium dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="/forgot-password">Forgot password?</a>
                                </div>
                                <div class="relative">
                                    <input type="password" id="password" name="password" class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" required aria-describedby="password-error">
                                    @error('password')
                                    <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

{{--                            <div class="g-recaptcha m-auto" data-sitekey="{{ config('services.recaptha.site_key', '6Lfl1JsqAAAAAINdsjwG1BoyyzRCFlVYAsAmDsw0') }}"></div>--}}
                            <div class="g-recaptcha m-auto" data-sitekey="6Lfb0psqAAAAAK7X8IDdvm03ffsnlgM4hs-kXWBa"></div>

                            @error('g-recaptcha-response')
                            <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                            @enderror

                            <div class="mt-4">
                                <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">Sign In</button>
                            </div>

                            <div class="mt-1">
                                <p class="text-center text-sm text-gray-600 dark:text-gray-400">OR</p>
                            </div>

                            <div class="mt-1">
                                <a href="{{ route('register.google') }}" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                                    Sign In with Google
                                </a>
                            </div>

                        </div>
                    </form>
                    <!-- End Form -->
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
    <script>
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'Ok'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ url('/') }}';
            }
        });
    </script>
@elseif(session('error'))
    <script>
        Swal.fire({
            title: 'Gagal!',
            text: '{{ session('error') }}',
            icon: 'error',
            confirmButtonText: 'Ok'
        });
    </script>
@endif

@if(session('googleSuccess'))
    <script>
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session('googleSuccess') }}',
            icon: 'success',
            confirmButtonText: 'Ok'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ route('login') }}';
            }
        });
    </script>
@endif

@if(session('success2'))
    <script>
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session('success2') }}',
            icon: 'success',
            confirmButtonText: 'Ok'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ route('login') }}';
            }
        });
    </script>
@endif
@livewire('partials.footer')
@livewireScripts()
</body>
</html>
