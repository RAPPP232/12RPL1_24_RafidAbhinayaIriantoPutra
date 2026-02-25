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
    
    <style>
        /* Glassmorphism */
        .glass-effect {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        /* Gradient responsif */
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1.5rem;
        }

        /* Floating animation */
        .floating-logo {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        /* Input Glow */
        .input-glow:focus {
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3);
        }
        
        /* Button */
        .btn-primary {
            transition: all 0.3s ease;
            background: linear-gradient(to right, #4facfe 0%, #00f2fe 100%);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.25);
        }

        /* 🔥 Responsiveness improvements */
        @media (max-width: 640px) {
            .glass-container {
                padding: 1.5rem !important;
                border-radius: 1rem !important;
            }
        }

        @media (min-width: 1024px) {
            .glass-container {
                padding: 2.5rem !important;
                max-width: 420px !important;
            }
        }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased">

    <!-- Background + center wrapper -->
    <div class="gradient-bg">

        <!-- Form Container -->
        <div class="w-full max-w-md sm:max-w-md glass-effect glass-container px-6 py-8 sm:px-8 sm:py-10 shadow-2xl rounded-2xl">
            {{ $slot }}
        </div>

    </div>

</body>
</html>
