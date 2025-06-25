<x-guest-layout>

    <!-- Logo personalizado -->
    <div class="flex justify-center mt-6 mb-4">
        <img src="{{ asset('images/logo-maguilop.jpg') }}" alt="Maguilop Logo" class="h-20 w-auto">
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Nombre de Usuario -->
        <div>
            <x-input-label for="NombreUsuario" :value="__('Nombre de Usuario')" />
            <x-text-input id="NombreUsuario" class="block mt-1 w-full" type="text" name="NombreUsuario" :value="old('NombreUsuario')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('NombreUsuario')" class="mt-2" />
        </div>

        <!-- Contraseña -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        @if (Route::has('password.request'))
        <div class="mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
               href="{{ route('password.request') }}">
                ¿Olvidaste tu contraseña?
            </a>
        </div>
        @endif

        <!-- Recordarme -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Recordar') }}</span>
            </label>
        </div>

        <!-- Botón -->
        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3">
                {{ __('Iniciar Sesión') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>


