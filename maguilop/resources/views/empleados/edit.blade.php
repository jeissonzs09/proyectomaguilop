<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">✏️ Editar Empleado #{{ $empleado->EmpleadoID }}</h2>
    </x-slot>

    <div class="p-6 max-w-3xl mx-auto bg-white shadow-md rounded-md">
        <form action="{{ route('empleados.update', $empleado->EmpleadoID) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

          

            <div>
                <label for="PersonaID" class="block text-gray-700 font-semibold mb-2">Persona ID</label>
                <input type="number" name="PersonaID" id="PersonaID" 
                       value="{{ old('PersonaID', $empleado->PersonaID) }}" 
                       required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                @error('PersonaID') 
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p> 
                @enderror
            </div>

            <div>
                <label for="Departamento" class="block text-gray-700 font-semibold mb-2">Departamento</label>
                <input type="text" name="Departamento" id="Departamento" 
                       value="{{ old('Departamento', $empleado->Departamento) }}" 
                       required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                @error('Departamento') 
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p> 
                @enderror
            </div>

            <div>
                <label for="Cargo" class="block text-gray-700 font-semibold mb-2">Cargo</label>
                <input type="text" name="Cargo" id="Cargo" 
                       value="{{ old('Cargo', $empleado->Cargo) }}" 
                       required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                @error('Cargo') 
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p> 
                @enderror
            </div>

            <div>
                <label for="FechaContratacion" class="block text-gray-700 font-semibold mb-2">Fecha de Contratación</label>
                <input type="date" name="FechaContratacion" id="FechaContratacion" 
                       value="{{ old('FechaContratacion', isset($empleado->FechaContratacion) ? \Carbon\Carbon::parse($empleado->FechaContratacion)->format('Y-m-d') : '') }}" 
                       required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                @error('FechaContratacion') 
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p> 
                @enderror
            </div>

            <div>
                <label for="Salario" class="block text-gray-700 font-semibold mb-2">Salario</label>
                <input type="number" step="0.01" min="0" name="Salario" id="Salario" 
                       value="{{ old('Salario', $empleado->Salario) }}" 
                       required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                @error('Salario') 
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p> 
                @enderror
            </div>

             <div class="mt-6 text-end">
                <a href="{{ route('reparaciones.index') }}"
                   style="background-color: #dc2626; color: white; font-weight: bold; padding: 10px 20px; border-radius: 8px; display: inline-flex; align-items: center; gap: 8px; text-decoration: none;">
                   ❌ Cancelar
                </a>
                <button type="submit"
                        style="background-color: #2563eb; color: white; font-weight: bold; padding: 10px 20px; border-radius: 8px; display: inline-flex; align-items: center; gap: 8px; border: none;">
                    💾 Actualizar Empleado
                </button>
            </div>
        </form>
    </div>
</x-app-layout>