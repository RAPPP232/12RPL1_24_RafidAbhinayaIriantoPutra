<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16"><!-- FIXED -->
                    <div class="flex flex-1 items-center"><!-- FIXED -->
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('dashboard') }}" class="text-lg sm:text-xl font-bold text-indigo-600">
                                <span class="hidden sm:inline">Pencatatan Pemotongan</span>
                                <span class="sm:hidden">Pencatatan Pemotongan</span>
                            </a>
                        </div>

                        <!-- Desktop Navigation Links -->
                        <div class="hidden lg:flex lg:items-center lg:space-x-4 lg:ml-10"><!-- FIXED -->
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-3 py-2 border-b-2 {{ request()->routeIs('dashboard') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium transition">
                                Dashboard
                            </a>

                            @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
                            <a href="{{ route('productions.index') }}" class="inline-flex items-center px-3 py-2 border-b-2 {{ request()->routeIs('productions.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium transition">
                                Produksi
                            </a>
                            @endif

                            @if(auth()->user()->isAdmin() || auth()->user()->isQCInspector())
                            <a href="{{ route('qc-inspections.index') }}" class="inline-flex items-center px-3 py-2 border-b-2 {{ request()->routeIs('qc-inspections.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium transition">
                                QC Inspeksi
                            </a>
                            @endif

                            @if(auth()->user()->isAdmin())
                            <div class="relative">
                                <button type="button" class="inline-flex items-center px-3 py-2 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 text-sm font-medium transition" onclick="toggleDropdown('master-menu-desktop')">
                                    Master Data
                                    <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <div id="master-menu-desktop" class="hidden absolute left-0 mt-2 w-48 origin-top-left rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                                    <div class="py-1">
                                        <a href="{{ route('parts.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Part & Komponen</a>
                                        <a href="{{ route('users.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">User</a>
                                    </div>
                                </div>
                            </div>

                            {{-- <a href="{{ route('reports.index') }}" class="inline-flex items-center px-3 py-2 border-b-2 {{ request()->routeIs('reports.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium transition">
                                Laporan
                            </a> --}}
                            @endif
                        </div>
                    </div>

                    <!-- User Dropdown (Desktop) -->
                    <div class="hidden lg:flex lg:items-center lg:ml-6">
                        <div class="relative">
                            <button type="button" class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none transition" onclick="toggleDropdown('user-menu-desktop')">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center mr-2">
                                    <span class="text-indigo-600 font-semibold text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                                <span class="hidden xl:block">{{ Auth::user()->name }}</span>
                                <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div id="user-menu-desktop" class="hidden absolute right-0 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                                <div class="py-1">
                                    <div class="px-4 py-2 border-b">
                                        <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                                    </div>
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Log Out</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="flex items-center lg:hidden">
                        <button onclick="toggleMobileMenu()" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition">
                            <svg class="h-6 w-6" id="menu-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg class="h-6 w-6 hidden" id="close-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Navigation Menu -->
            <div id="mobile-menu" class="hidden lg:hidden border-t border-gray-200">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="{{ route('dashboard') }}" class="block pl-3 pr-4 py-2 rounded-md {{ request()->routeIs('dashboard') ? 'bg-indigo-50 border-l-4 border-indigo-500 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} text-base font-medium">
                        Dashboard
                    </a>

                    @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
                    <a href="{{ route('productions.index') }}" class="block pl-3 pr-4 py-2 rounded-md {{ request()->routeIs('productions.*') ? 'bg-indigo-50 border-l-4 border-indigo-500 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} text-base font-medium">
                        Produksi
                    </a>
                    @endif

                    @if(auth()->user()->isAdmin() || auth()->user()->isQCInspector())
                    <a href="{{ route('qc-inspections.index') }}" class="block pl-3 pr-4 py-2 rounded-md {{ request()->routeIs('qc-inspections.*') ? 'bg-indigo-50 border-l-4 border-indigo-500 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} text-base font-medium">
                        QC Inspeksi
                    </a>
                    @endif

                    @if(auth()->user()->isAdmin())
                    <div class="space-y-1">
                        <button onclick="toggleDropdown('master-menu-mobile')" class="w-full flex items-center justify-between pl-3 pr-4 py-2 text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-md text-base font-medium">
                            <span>Master Data</span>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div id="master-menu-mobile" class="hidden pl-6 space-y-1">
                            <a href="{{ route('parts.index') }}" class="block pl-3 pr-4 py-2 rounded-md text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900">Part & Komponen</a>
                            <a href="{{ route('operators.index') }}" class="block pl-3 pr-4 py-2 rounded-md text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900">Operator</a>
                            <a href="{{ route('users.index') }}" class="block pl-3 pr-4 py-2 rounded-md text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900">User</a>
                        </div>
                    </div>

                    <a href="{{ route('reports.index') }}" class="block pl-3 pr-4 py-2 rounded-md {{ request()->routeIs('reports.*') ? 'bg-indigo-50 border-l-4 border-indigo-500 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} text-base font-medium">
                        Laporan
                    </a>
                    @endif
                </div>

                <!-- Mobile User Info -->
                <div class="pt-4 pb-3 border-t border-gray-200">
                    <div class="flex items-center px-4">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center">
                            <span class="text-indigo-600 font-semibold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                    </div>

                    <div class="mt-3 space-y-1 px-2">
                        <a href="{{ route('profile.edit') }}" class="block pl-3 pr-4 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                            Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left pl-3 pr-4 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-4 sm:py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="py-6 sm:py-8 lg:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @if (session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                {{ $slot }}
            </div>
        </main>
    </div>

    <script>
        function toggleDropdown(id) {
            const menu = document.getElementById(id);
            menu.classList.toggle('hidden');
        }

        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const menuIcon = document.getElementById('menu-icon');
            const closeIcon = document.getElementById('close-icon');
            
            menu.classList.toggle('hidden');
            menuIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        }

        document.addEventListener('click', function(event) {
            const dropdowns = ['master-menu-desktop', 'user-menu-desktop'];
            
            dropdowns.forEach(function(dropdownId) {
                const dropdown = document.getElementById(dropdownId);
                if (dropdown && !dropdown.contains(event.target) && !event.target.closest('button')) {
                    dropdown.classList.add('hidden');
                }
            });
        });

        document.querySelectorAll('[id$="-menu-desktop"]').forEach(function(dropdown) {
            dropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    </script>
</body>
</html>
