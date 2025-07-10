<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">🧑‍💼 Nuevo Empleado</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-6 bg-white p-6 rounded shadow">
        <form action="{{ route('empleados.store') }}" method="POST">
            @csrf

            <!-- SELECT de Personas -->
            <div class="mb-4">
                <label for="PersonaID" class="block text-gray-700 font-bold mb-2">
                    Persona
                </label>
                <select name="PersonaID" id="PersonaID"
                        class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Selecciona una persona --</option>
                    @foreach($personas as $persona)
                        <option value="{{ $persona->PersonaID }}"
                            {{ old('PersonaID') == $persona->PersonaID ? 'selected' : '' }}>
                            {{ $persona->Nombre }} {{ $persona->Apellido }}
                        </option>
                    @endforeach
                </select>
                @error('PersonaID')
                    <div class="text-red-600 mt-1 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <!-- Resto de campos -->
            <div class="mb-4">
                <label for="Departamento" class="block text-gray-700 font-bold mb-2">Departamento</label>
                <input type="text" name="Departamento" id="Departamento"
                       class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="Cargo" class="block text-gray-700 font-bold mb-2">Cargo</label>
                <input type="text" name="Cargo" id="Cargo"
                       class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="FechaContratacion" class="block text-gray-700 font-bold mb-2">
                    Fecha de Contratación
                </label>
                <input type="date" name="FechaContratacion" id="FechaContratacion"
                       class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-6">
                <label for="Salario" class="block text-gray-700 font-bold mb-2">
                    Salario (Lps.)
                </label>
                <input type="number" step="0.01" name="Salario" id="Salario"
                       class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('empleados.index') }}"
                   class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    ❌ Cancelar
                </a>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    💾 Guardar Empleado
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
