<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AutoMoto') }} - Auth</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-[Inter] text-slate-900 antialiased bg-slate-50 relative overflow-x-hidden min-h-screen flex flex-col justify-center py-12">
    
    {{-- Design Background Overlay --}}
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-blue-100/50 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-orange-100/50 rounded-full blur-3xl"></div>
    </div>

    <div class="relative z-10 sm:max-w-md w-full mx-auto px-4">
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-700 text-white flex items-center justify-center font-bold text-2xl shadow-sm">
                    A
                </div>
                <span class="text-3xl font-black tracking-tight text-slate-900">Auto<span class="text-blue-600">Moto</span></span>
            </a>
        </div>

        <div class="bg-white px-8 py-10 shadow-lg shadow-slate-200/50 sm:rounded-3xl border border-slate-100 relative">
            {{ $slot }}
        </div>
        
        <div class="text-center mt-8">
            <a href="{{ route('home') }}" class="text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors">
                ← Retour à l'accueil
            </a>
        </div>
    </div>
</body>
</html>
