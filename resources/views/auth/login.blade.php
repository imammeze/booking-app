<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/logo_alhaq.png') }}" type="image/png">
    <title>Login - Booking System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo_alhaq.png') }}" alt="Logo" class="h-20 mx-auto mb-4">
            <h1 class="text-2xl font-bold text-amber-600">Booking<span class="text-gray-800">Room</span></h1>
            <p class="text-gray-500 text-sm mt-2">Silakan masuk ke akun Anda</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 text-red-500 p-3 rounded-lg text-sm mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-lg border-gray-300 focus:ring-amber-500 focus:border-amber-500 py-3 px-4 border" placeholder="nama@email.com" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                <input type="password" name="password" class="w-full rounded-lg border-gray-300 focus:ring-amber-500 focus:border-amber-500 py-3 px-4 border" placeholder="••••••••" required>
            </div>

            <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 rounded-lg transition shadow-lg">
                Masuk
            </button>

            <p class="text-center font-semibold">Powered by <a class="text-red-500" href="https://sobatberbagi.com">Sobatberbagi.com</a></p>
        </form>
    </div>
</body>
</html>