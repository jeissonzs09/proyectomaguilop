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
<aside style="width: 250px; background: linear-gradient(to bottom, #ef6c00, #ff9800); color: white; padding-top: 1rem; box-shadow: 2px 0 5px rgba(0,0,0,0.1);">
    {{-- Logo --}}
    <div style="padding: 1rem; border-bottom: 1px solid rgba(255,255,255,0.3); display: flex; align-items: center; gap: 10px;">
        <a href="{{ route('dashboard') }}" style="display: flex; align-items: center; gap: 10px; text-decoration: none; color: white;">
            <img src="{{ asset('images/logo-maguilop.jpg') }}" alt="Logo Maguilop" style="height: 40px; max-width: 100px; object-fit: contain;">
            <span style="font-weight: bold; font-size: 1rem;">Maguilop</span>
        </a>
    </div>

    {{-- Navegación --}}
    <nav style="margin-top: 1rem; font-size: 15px;">
        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
           style="display: flex; align-items: center; gap: 10px; padding: 12px 20px; color: white; text-decoration: none; font-weight: 500;"
           onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)'" onmouseout="this.style.backgroundColor='transparent'">
            <svg xmlns="http://www.w3.org/2000/svg" style="width: 18px; height: 18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6m-6 0H5m8 0v6" />
            </svg>
            Dashboard
        </a>

        {{-- Seguridad (desplegable) --}}
        <div style="padding: 12px 20px; font-weight: bold; text-transform: uppercase; opacity: 0.9; font-size: 13px; display: flex; align-items: center; justify-content: space-between; cursor: pointer;" onclick="toggleSeguridad()">
            <span style="display: flex; align-items: center; gap: 10px;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width: 18px; height: 18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.657-2-3-2-5s1-3 2-3 2 1 2 3-2 3-2 5m0 2v1m0 4h.01" />
                </svg>
                Seguridad
            </span>
            <span style="font-size: 16px;">▼</span>
        </div>
        <div id="submenu-seguridad" style="display: none;">
            <a href="{{ route('usuarios.index') }}"
               style="display: flex; align-items: center; gap: 10px; padding: 10px 35px; color: white; text-decoration: none;"
               onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)'" onmouseout="this.style.backgroundColor='transparent'">
                <svg xmlns="http://www.w3.org/2000/svg" style="width: 16px; height: 16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5V8H2v12h5m0 0v2m0-2h10m0 2v-2" />
                </svg>
                Usuarios
            </a>
            <a href="{{ route('roles.index') }}"
               style="display: flex; align-items: center; gap: 10px; padding: 10px 35px; color: white; text-decoration: none;"
               onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)'" onmouseout="this.style.backgroundColor='transparent'">
                <svg xmlns="http://www.w3.org/2000/svg" style="width: 16px; height: 16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m2 4H7m2-4v6m4-6v6M4 4h16v4H4z" />
                </svg>
                Roles
            </a>
            <a href="{{ route('permisos.index') }}"
               style="display: flex; align-items: center; gap: 10px; padding: 10px 35px; color: white; text-decoration: none;"
               onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)'" onmouseout="this.style.backgroundColor='transparent'">
                <svg xmlns="http://www.w3.org/2000/svg" style="width: 16px; height: 16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Permisos
            </a>
        </div>
    </nav>

    {{-- Script para toggle --}}
    <script>
        function toggleSeguridad() {
            const submenu = document.getElementById('submenu-seguridad');
            submenu.style.display = submenu.style.display === 'none' ? 'block' : 'none';
        }
    </script>

</aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col">
            {{-- Header --}}
<header style="background: linear-gradient(to right, #ef6c00, #ff9800); padding: 16px 24px; color: white; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
    {{-- Título del módulo --}}
    <div style="display: flex; align-items: center; gap: 10px;">
        <svg xmlns="http://www.w3.org/2000/svg" style="width: 22px; height: 22px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17l-3-3 3-3M14.25 7l3 3-3 3" />
        </svg>
        <h1 style="font-size: 20px; font-weight: 600;">{{ $header ?? 'Panel' }}</h1>
    </div>

    {{-- Botón cerrar sesión --}}
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
                style="background-color: #ffffff; color: #ef6c00; font-weight: bold; border: none; padding: 8px 16px; border-radius: 6px; display: flex; align-items: center; gap: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); cursor: pointer;"
                onmouseover="this.style.backgroundColor='#f3f4f6'" onmouseout="this.style.backgroundColor='#ffffff'">
            <svg xmlns="http://www.w3.org/2000/svg" style="width: 16px; height: 16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
            </svg>
            Cerrar sesión
        </button>
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

