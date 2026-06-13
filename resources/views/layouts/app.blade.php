<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50 text-slate-900 antialiased selection:bg-indigo-500 selection:text-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Products Operation System')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-full flex-col font-sans">
    <!-- Header/Navbar -->
    <header class="sticky top-0 z-50 border-b border-slate-200/80 bg-white/80 backdrop-blur-md">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <!-- Logo / Brand -->
                <div class="flex items-center gap-8">
                    <a href="{{ url('/') }}" class="flex items-center gap-2.5 font-semibold text-slate-950 transition hover:opacity-90">
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-tr from-indigo-600 to-violet-500 text-white shadow-md shadow-indigo-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                            </svg>
                        </span>
                        <span class="bg-gradient-to-r from-slate-950 to-slate-800 bg-clip-text text-lg tracking-tight text-transparent">StockOps</span>
                    </a>

                    <!-- Nav Links -->
                    <nav class="hidden md:flex items-center gap-6">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-slate-600 transition hover:text-slate-900">Dashboard</a>
                            <a href="{{ route('products.index') }}" class="text-sm font-medium text-slate-600 transition hover:text-slate-900">Products</a>
                        @endauth
                    </nav>
                </div>

                <!-- User actions / Auth -->
                <div class="flex items-center gap-4">
                    @auth
                        <div class="flex items-center gap-3">
                            <span class="hidden sm:inline-block text-xs font-semibold uppercase tracking-wider text-slate-400 bg-slate-100 px-2.5 py-1 rounded-md border border-slate-200/60">
                                {{ auth()->user()->role }}
                            </span>
                            <span class="text-sm font-medium text-slate-700">{{ auth()->user()->name }}</span>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="rounded-lg px-3 py-1.5 text-sm font-medium text-slate-500 hover:text-slate-800 transition hover:bg-slate-55">
                                    Log out
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 transition hover:text-slate-955">Sign in</a>
                        <a href="{{ route('register') }}" class="rounded-lg bg-indigo-600 px-3.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Success & Error Alert Banners -->
    @if(session('success') || session('error') || $errors->any())
        <div class="mx-auto w-full max-w-7xl px-4 pt-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="flex items-center gap-3 rounded-xl border border-emerald-100 bg-emerald-50/50 p-4 text-emerald-800 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 text-emerald-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="flex items-center gap-3 rounded-xl border border-rose-100 bg-rose-50/50 p-4 text-rose-800 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 text-rose-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any() && !Request::is('login') && !Request::is('register'))
                <div class="rounded-xl border border-rose-100 bg-rose-50/50 p-4 text-rose-800 shadow-sm">
                    <div class="flex items-center gap-3 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 text-rose-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        <span class="text-sm font-semibold">Please correct the following errors:</span>
                    </div>
                    <ul class="list-disc pl-8 text-xs space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    @endif

    <!-- Main Content Area -->
    <main class="flex-1 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-200 bg-white py-6">
        <div class="mx-auto max-w-7xl px-4 text-center text-xs text-slate-500 sm:px-6 lg:px-8">
            <p>&copy; {{ date('Y') }} StockOps. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>