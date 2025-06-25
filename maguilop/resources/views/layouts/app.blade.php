<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800">

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside class="w-64 bg-white border-r shadow-md">
<div class="p-4 border-b flex items-center space-x-2">
    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
<img src="{{ asset('images/logo-maguilop.jpg') }}"
     alt="Logo Maguilop"
     class="h-[40px] max-w-[100px] object-contain"
     style="height: 40px; width: auto; max-width: 100px;">
        <span class="font-semibold text-sm"></span>
    </a>
</div>




            <nav class="mt-4 space-y-2 px-4">
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('dashboard') ? 'bg-gray-200 font-semibold' : '' }}">
                    🏠 Dashboard
                </a>
                <a href="{{ route('usuarios.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('usuarios.index') ? 'bg-gray-200 font-semibold' : '' }}">
                    👥 Usuarios
                </a>
                <a href="{{ route('roles.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('roles.index') ? 'bg-gray-200 font-semibold' : '' }}">
                    🔐 Roles
                </a>
                <a href="{{ route('permisos.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('permisos.index') ? 'bg-gray-200 font-semibold' : '' }}">
                    ⚙️ Permisos
                </a>
            </nav>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col">
            {{-- Header --}}
            <header class="bg-white border-b p-4 flex justify-between items-center shadow-sm">
                <h1 class="text-xl font-semibold">{{ $header ?? 'Panel' }}</h1>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-red-600 hover:underline">Cerrar sesión</button>
                </form>
            </header>

            {{-- Content --}}
            <main class="p-6 flex-1">
                {{ $slot }}
            </main>
        </div>
    </div>

</body>
</html>

