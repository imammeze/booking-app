<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/logo_alhaq.png') }}" type="image/png">
    <title>Registrasi - Booking System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo_alhaq.png') }}" alt="Logo" class="h-20 mx-auto mb-4">
            <h1 class="text-2xl font-bold text-amber-600">Daftar Akun</h1>
            <p class="text-gray-500 text-sm mt-2">Buat akun untuk mulai booking ruangan</p>
        </div>

        <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" class="w-full rounded-lg border-gray-300 focus:ring-amber-500 focus:border-amber-500 py-3 px-4 border" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                <input type="email" name="email" class="w-full rounded-lg border-gray-300 focus:ring-amber-500 focus:border-amber-500 py-3 px-4 border" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                <input type="password" name="password" class="w-full rounded-lg border-gray-300 focus:ring-amber-500 focus:border-amber-500 py-3 px-4 border" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full rounded-lg border-gray-300 focus:ring-amber-500 focus:border-amber-500 py-3 px-4 border" required>
            </div>

            <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 rounded-lg transition shadow-lg mt-4">
                Daftar Akun
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-gray-600">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="text-amber-600 font-bold hover:underline">Masuk</a>
        </div>
    </div>
</body>
</html>