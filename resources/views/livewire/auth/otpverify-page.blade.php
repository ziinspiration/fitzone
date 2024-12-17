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
<div class="min-h-screen bg-gradient-to-br from-gray-900 to-gray-700 flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-gray-800 shadow-2xl rounded-xl border border-gray-700 overflow-hidden">
        <div class="p-8">
            <h2 class="text-3xl text-center text-orange-400 mb-6 font-bold tracking-wide">
                Verifikasi Email Anda
            </h2>

            <form action="{{ route('verification.otp') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-base font-medium mb-2 text-orange-300">
                        Email
                    </label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg
                               text-white placeholder-gray-400
                               focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent
                               transition duration-300"
                        required
                        value="{{ $email ?? old('email') }}"
                        readonly
                    >
                </div>

                <div>
                    <label class="block text-base font-medium mb-2 text-orange-300">
                        Masukkan Kode OTP
                    </label>
                    <div class="flex justify-center space-x-2">
                        <input
                            type="text"
                            name="otp"
                            maxlength="8"
                            class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg
                                   text-white placeholder-gray-400 text-center
                                   focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent
                                   transition duration-300"
                            required
                            pattern="^FIT-\d{4}$"
                            placeholder="Masukkan kode OTP"
                            aria-label="Masukkan kode OTP"
                            autofocus
                        >
                    </div>
                </div>

                <button
                    type="submit"
                    class="w-full bg-orange-600 hover:bg-orange-500 text-white font-bold
                           py-3 px-4 rounded-lg transition duration-300
                           transform hover:scale-[1.02] active:scale-[0.98]
                           focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-opacity-50"
                >
                    Verifikasi
                </button>

            </form>
            <div class="text-center mt-4">
                <span class="text-gray-400">
                    Belum menerima kode?
                    <form action="{{ route('verification.resend') }}" method="POST" style="display: inline;">
                        @csrf
                        <input
                            type="hidden"
                            name="email"
                            class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white"
                            required
                            value="{{ $email ?? old('email') }}"
                            readonly
                        >
                        <button type="submit" class="text-orange-400 hover:underline">Kirim Ulang</button>
                    </form>
                </span>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <script>
    Swal.fire({
        title: 'Successful!',
        text: '{{ session('success') }}',
        icon: 'success',
        confirmButtonText: 'OK'
    });
    </script>
@endif

@if(session('success2'))
    <script>
    Swal.fire({
        title: 'Verification Successful!',
        text: '{{ session('success') }}',
        icon: 'success',
        confirmButtonText: 'OK',
        willClose: () => {
        window.location.href = "{{ route('login') }}";
    }
    });
    </script>
@endif

@if(session('error'))
    <script>
    Swal.fire({
        title: 'Verification Failed',
        text: '{{ session('error') }}',
        icon: 'error',
        confirmButtonText: 'OK'
    });
    </script>
@endif
@livewire('partials.footer')
@livewireScripts()
</body>
</html>
