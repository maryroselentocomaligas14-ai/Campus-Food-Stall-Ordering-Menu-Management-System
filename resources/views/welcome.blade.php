<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Campus Food Stall') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans">
        <div class="min-h-screen bg-gray-50">
            <!-- Navigation -->
            <nav class="p-6 flex justify-between items-center max-w-7xl mx-auto">
                <div class="flex items-center gap-2">
                    <x-application-logo class="h-10 w-auto fill-current text-indigo-600" />
                    <span class="text-xl font-black text-gray-900 tracking-tight">{{ config('app.name', 'CAMPUS FOOD') }}</span>
                </div>
                
                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:text-indigo-600 transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:text-indigo-600 transition">Log in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-5 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-full hover:bg-indigo-700 shadow-md transition">Get Started</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </nav>

            <!-- Hero Section -->
            <main class="max-w-7xl mx-auto px-6 pt-16 pb-24 text-center">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-bold uppercase tracking-wider mb-8">
                    <span class="flex h-2 w-2 rounded-full bg-indigo-500"></span>
                    {{ __('Skip the Queue, Enjoy the Taste') }}
                </div>
                
                <h1 class="text-5xl md:text-7xl font-black text-gray-900 mb-6 leading-tight">
                    Campus Dining <br/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">Made Effortless.</span>
                </h1>
                
                <p class="max-w-2xl mx-auto text-lg text-gray-600 mb-10">
                    The ultimate food stall management and pre-ordering system for students and vendors. Order ahead, track your meal, and support your campus canteen.
                </p>

                <div class="flex flex-col sm:flex-row justify-center gap-4 mb-20">
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-gray-900 text-white font-bold rounded-xl hover:bg-black shadow-xl transition transform hover:-translate-y-1">
                        {{ __('Order Food Now') }}
                    </a>
                    <a href="{{ route('login') }}" class="px-8 py-4 bg-white text-gray-900 font-bold rounded-xl border border-gray-200 hover:bg-gray-50 shadow-sm transition transform hover:-translate-y-1">
                        {{ __('Vendor Portal') }}
                    </a>
                </div>

                <!-- Feature Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="p-8 bg-white rounded-2xl shadow-sm border border-gray-100 text-left">
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-600 mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Pre-order System</h3>
                        <p class="text-gray-600 text-sm">Don't waste time in lines. Browse menus and place your order before you even reach the canteen.</p>
                    </div>

                    <div class="p-8 bg-white rounded-2xl shadow-sm border border-gray-100 text-left">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600 mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Live Tracking</h3>
                        <p class="text-gray-600 text-sm">Get real-time updates on your order status. Know exactly when your food is preparing or ready for pickup.</p>
                    </div>

                    <div class="p-8 bg-white rounded-2xl shadow-sm border border-gray-100 text-left">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center text-green-600 mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Vendor Analytics</h3>
                        <p class="text-gray-600 text-sm">Stall owners can track daily sales, manage their menu inventory, and view customer feedback.</p>
                    </div>
                </div>
            </main>

            <footer class="py-12 border-t border-gray-100 text-center text-sm text-gray-500">
                &copy; 2026 Campus Food Stall Ordering System. All rights reserved.
            </footer>
        </div>
    </body>
</html>
