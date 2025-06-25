<x-guest-layout>
    <form method="POST" action="{{ route('2fa.code.verify') }}">
        @csrf

            <div class="flex justify-center mt-6 mb-4">
        <img src="{{ asset('images/logo-maguilop.jpg') }}" alt="Maguilop Logo" class="h-20 w-auto">
    </div>

        <h2 class="text-lg font-bold mb-4">🔐 Verificación en dos pasos</h2>

        <p class="mb-4">Revisa tu correo electrónico. Ingresa el código de 6 dígitos:</p>

        <div>
            <x-input-label for="code" :value="__('Código')" />
            <x-text-input id="code" type="text" name="code" required autofocus />
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-primary-button>Verificar</x-primary-button>
        </div>
    </form>
    @if (session('status'))
    <p class="text-green-600 mt-4">{{ session('status') }}</p>
@endif

<form method="POST" action="{{ route('2fa.code.resend') }}" class="mt-4">
    @csrf
    <x-primary-button>Reenviar código</x-primary-button>
</form>
</x-guest-layout>
