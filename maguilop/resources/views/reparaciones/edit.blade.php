<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">✏️ Editar Reparación #{{ $reparacion->ReparacionID }}</h2>
    </x-slot>

    <div class="p-6 max-w-3xl mx-auto bg-white shadow-md rounded-md">
        <form action="{{ route('reparaciones.update', $reparacion->ReparacionID) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="ClienteID" class="block text-gray-700 font-semibold mb-2">Cliente ID</label>
                <input type="number" name="ClienteID" id="ClienteID" value="{{ old('ClienteID', $reparacion->ClienteID) }}" required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                @error('ClienteID') <p class="text-red-600 mt-1 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="ProductoID" class="block text-gray-700 font-semibold mb-2">Producto ID</label>
                <input type="number" name="ProductoID" id="ProductoID" value="{{ old('ProductoID', $reparacion->ProductoID) }}" required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                @error('ProductoID') <p class="text-red-600 mt-1 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="FechaEntrada" class="block text-gray-700 font-semibold mb-2">Fecha Entrada</label>
                <input type="datetime-local" name="FechaEntrada" id="FechaEntrada" value="{{ old('FechaEntrada', \Carbon\Carbon::parse($reparacion->FechaEntrada)->format('Y-m-d\TH:i')) }}" required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                @error('FechaEntrada') <p class="text-red-600 mt-1 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="FechaSalida" class="block text-gray-700 font-semibold mb-2">Fecha Salida</label>
                <input type="datetime-local" name="FechaSalida" id="FechaSalida" value="{{ old('FechaSalida', $reparacion->FechaSalida ? \Carbon\Carbon::parse($reparacion->FechaSalida)->format('Y-m-d\TH:i') : '') }}"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                @error('FechaSalida') <p class="text-red-600 mt-1 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="DescripcionProblema" class="block text-gray-700 font-semibold mb-2">Descripción del Problema</label>
                <textarea name="DescripcionProblema" id="DescripcionProblema" rows="3"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('DescripcionProblema', $reparacion->DescripcionProblema) }}</textarea>
                @error('DescripcionProblema') <p class="text-red-600 mt-1 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="Estado" class="block text-gray-700 font-semibold mb-2">Estado</label>
                <select name="Estado" id="Estado" required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="Pendiente" {{ old('Estado', $reparacion->Estado) == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="En proceso" {{ old('Estado', $reparacion->Estado) == 'En proceso' ? 'selected' : '' }}>En proceso</option>
                    <option value="Finalizado" {{ old('Estado', $reparacion->Estado) == 'Finalizado' ? 'selected' : '' }}>Finalizado</option>
                </select>
                @error('Estado') <p class="text-red-600 mt-1 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="Costo" class="block text-gray-700 font-semibold mb-2">Costo</label>
                <input type="number" step="0.01" min="0" name="Costo" id="Costo" value="{{ old('Costo', $reparacion->Costo) }}" required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                @error('Costo') <p class="text-red-600 mt-1 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mt-6 text-end">
                <a href="{{ route('reparaciones.index') }}"
                   style="background-color: #dc2626; color: white; font-weight: bold; padding: 10px 20px; border-radius: 8px; display: inline-flex; align-items: center; gap: 8px; text-decoration: none;">
                   ❌ Cancelar
                </a>
                <button type="submit"
                        style="background-color: #2563eb; color: white; font-weight: bold; padding: 10px 20px; border-radius: 8px; display: inline-flex; align-items: center; gap: 8px; border: none;">
                    💾 Guardar cambios
                </button>
            </div>
        </form>
    </div>
</x-app-layout>