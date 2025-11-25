<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Lapor Unhas') }}</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Instrument Sans', sans-serif; }
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 8px 32px 0 rgba(206, 22, 29, 0.1);
        }
        .bg-unhas-pattern {
            background-color: #f8fafc;
            background-image: radial-gradient(#ce161d 0.5px, transparent 0.5px), radial-gradient(#ce161d 0.5px, #f8fafc 0.5px);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
            opacity: 1;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col relative overflow-x-hidden">
    
    <div class="fixed inset-0 z-[-1] bg-unhas-pattern opacity-5"></div>
    <div class="fixed top-0 left-0 w-64 h-64 bg-red-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob"></div>
    <div class="fixed top-0 right-0 w-64 h-64 bg-red-300 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-2000"></div>

    <header class="sticky top-0 z-50 glass border-b border-white/40 shadow-sm">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <img src="https://upload.wikimedia.org/wikipedia/commons/b/bd/Logo-Resmi-Unhas-1.png" alt="Unhas" class="h-10 w-10 drop-shadow-md">
                <div>
                    <h1 class="text-lg font-bold text-red-700 leading-tight">SiLapor</h1>
                    <p class="text-[10px] text-gray-500 uppercase tracking-wider">Universitas Hasanuddin</p>
                </div>
            </div>
            <nav class="hidden md:flex items-center gap-6 text-sm font-medium text-gray-600">
                <a href="{{ route('home') }}" class="hover:text-red-600 transition">Beranda</a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-red-600 transition">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button class="px-4 py-2 bg-red-100 text-red-700 rounded-full hover:bg-red-200 transition">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-white border border-red-100 text-red-600 rounded-full hover:bg-red-50 transition shadow-sm">Login Admin</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="flex-grow container mx-auto px-4 py-8 relative z-10">
        @yield('content')
    </main>

    <footer class="glass border-t border-white/40 mt-auto">
        <div class="mx-auto px-6 py-6 text-center text-sm text-gray-500">
            <p>&copy; {{ date('Y') }} Universitas Hasanuddin. All rights reserved.</p>
        </div>
    </footer>

    <div x-data="{ show: false, message: '' }" 
         @if(session('success')) 
            x-init="show = true; message = '{{ session('success') }}'; setTimeout(() => show = false, 3000)" 
         @endif
         x-show="show" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform translate-y-2"
         class="fixed bottom-5 right-5 z-50 glass-card px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 border-l-4 border-red-500"
         style="display: none;">
        <div class="bg-green-100 text-green-600 rounded-full p-1">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <div>
            <h4 class="font-bold text-gray-800 text-sm">Berhasil!</h4>
            <p class="text-xs text-gray-600" x-text="message"></p>
        </div>
    </div>

</body>
</html>