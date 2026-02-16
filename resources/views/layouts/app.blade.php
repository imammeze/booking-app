<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Booking System') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="icon" href="{{ asset('images/logo_alhaq.png') }}" type="image/png">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <div class="min-h-screen flex flex-col">
        
        <nav x-data="{ open: false }" class="bg-white border-b border-gray-200 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="shrink-0 flex items-center">
                            <a href="/" class="flex items-center gap-2">
                                <img src="{{ asset('images/logo_alhaq.png') }}" alt="Logo Masjid Al Haq" class="h-12 w-auto">
                                <div class="flex flex-col leading-tight">
                                    <span class="text-lg font-bold text-amber-600 tracking-tight">Masjid Al Haq</span>
                                    <span class="text-[10px] text-gray-500 font-medium uppercase tracking-widest">Booking System</span>
                                </div>
                            </a>
                        </div>

                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            @auth
                                @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 {{ request()->routeIs('admin.dashboard') ? 'text-amber-600 border-b-2 border-amber-500' : 'text-gray-500 hover:text-gray-700' }}">
                                        List Booking User
                                    </a>
                                    <a href="{{ route('admin.rooms.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 {{ request()->routeIs('admin.rooms.index') ? 'text-amber-600 border-b-2 border-amber-500' : 'text-gray-500 hover:text-gray-700' }}">
                                        List Room
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('bookings.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 {{ request()->routeIs('bookings.index') ? 'text-amber-600 border-b-2 border-amber-500' : 'text-gray-500 hover:text-gray-700' }}">
                                    Jadwal Ruangan
                                </a>
                            @endauth
                        </div>
                    </div>

                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        @auth
                            <div class="ml-3 relative" x-data="{ dropdownOpen: false }">
                                <button @click="dropdownOpen = !dropdownOpen" class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition">
                                    <div>{{ Auth::user()->name ?? 'User' }}</div>
                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" /></svg>
                                    </div>
                                </button>
                            
                                <div x-show="dropdownOpen" @click.away="dropdownOpen = false" x-cloak class="absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 z-[50]">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 font-medium">Log Out</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-gray-700">Admin Login</a>
                        @endauth
                    </div>

                    <div class="-mr-2 flex items-center sm:hidden">
                        <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div 
                x-show="open" 
                x-cloak
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-2"
                @click.away="open = false"
                class="absolute top-16 inset-x-0 z-[50] bg-white border-b border-gray-200 shadow-xl sm:hidden"
            >
                <div class="pt-2 pb-3 space-y-1">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="block pl-3 pr-4 py-3 border-l-4 {{ request()->routeIs('admin.dashboard') ? 'border-amber-500 text-amber-700 bg-amber-50' : 'border-transparent text-gray-600' }} text-base font-medium">List Booking User</a>
                            <a href="{{ route('admin.rooms.index') }}" class="block pl-3 pr-4 py-3 border-l-4 {{ request()->routeIs('admin.rooms.index') ? 'border-amber-500 text-amber-700 bg-amber-50' : 'border-transparent text-gray-600' }} text-base font-medium">List Room</a>
                        @endif
                        
                        <div class="border-t border-gray-100 pt-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left pl-3 pr-4 py-3 text-base font-medium text-red-600 hover:bg-red-50">Log Out</button>
                            </form>
                        </div>
                    @else  
                        <a href="{{ route('bookings.index') }}" class="block pl-3 pr-4 py-3 border-l-4 {{ request()->routeIs('bookings.index') ? 'border-amber-500 text-amber-700 bg-amber-50' : 'border-transparent text-gray-600' }} text-base font-medium">Jadwal Ruangan</a>
                        
                        <div class="border-t border-gray-100 pt-2">
                            <a href="{{ route('login') }}" class="block pl-3 pr-4 py-3 text-base font-medium text-gray-500 hover:bg-gray-50">Admin Login</a>
                        </div>
                    @endauth
                    
                </div>
            </div>
        </nav>

        <main class="grow relative">
            @if (session('success') || session('error') || $errors->any())
            <div x-data="{ show: true }" 
                 x-show="show" 
                 x-init="setTimeout(() => show = false, 5000)"
                 x-cloak
                 class="fixed top-20 right-4 z-[100] max-w-sm w-full">
                
                @if (session('success'))
                <div class="bg-green-500 text-white p-4 rounded-lg shadow-xl flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                @if (session('error') || $errors->any())
                <div class="bg-red-500 text-white p-4 rounded-lg shadow-xl flex items-center mt-2">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    <span>{{ session('error') ?? $errors->first() }}</span>
                </div>
                @endif
            </div>
            @endif

            @yield('content')
        </main>

        <footer class="bg-white border-t border-gray-200 py-6 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <p class="text-center text-sm text-gray-500">
                    &copy; {{ date('Y') }} {{ config('app.name') }}. Developed by Sobatberbagi.com
                </p>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>