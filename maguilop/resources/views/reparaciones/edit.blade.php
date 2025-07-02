<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold flex items-center gap-2">
            <i class="fas fa-tools"></i> Editar Reparación #{{ $reparacion->ReparacionID }}
        </h2>
    </x-slot>

    <div class="p-6 max-w-3xl mx-auto bg-white shadow-md rounded-lg">
        <form action="{{ route('reparaciones.update', $reparacion->ReparacionID) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="ClienteID" class="block text-gray-700 font-semibold mb-2">Cliente ID</label>
                <input type="number" name="ClienteID" id="ClienteID" value="{{ old('ClienteID', $reparacion->ClienteID) }}" required
                       class="w-full rounded-md border-gray-300 shadow-sm px-4 py-2 focus:border-indigo-500 focus:ring focus:ring-indigo-200" />
                @error('ClienteID') <p class="text-red-600 mt-1 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="ProductoID" class="block text-gray-700 font-semibold mb-2">Producto ID</label>
                <input type="number" name="ProductoID" id="ProductoID" value="{{ old('ProductoID', $reparacion->ProductoID) }}" required
                       class="w-full rounded-md border-gray-300 shadow-sm px-4 py-2 focus:border-indigo-500 focus:ring focus:ring-indigo-200" />
                @error('ProductoID') <p class="text-red-600 mt-1 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="FechaEntrada" class="block text-gray-700 font-semibold mb-2">Fecha de Entrada</label>
                <input type="datetime-local" name="FechaEntrada" id="FechaEntrada"
                       value="{{ old('FechaEntrada', \Carbon\Carbon::parse($reparacion->FechaEntrada)->format('Y-m-d\TH:i')) }}" required
                       class="w-full rounded-md border-gray-300 shadow-sm px-4 py-2 focus:border-indigo-500 focus:ring focus:ring-indigo-200" />
                @error('FechaEntrada') <p class="text-red-600 mt-1 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="FechaSalida" class="block text-gray-700 font-semibold mb-2">Fecha de Salida</label>
                <input type="datetime-local" name="FechaSalida" id="FechaSalida"
                       value="{{ old('FechaSalida', $reparacion->FechaSalida ? \Carbon\Carbon::parse($reparacion->FechaSalida)->format('Y-m-d\TH:i') : '') }}"
                       class="w-full rounded-md border-gray-300 shadow-sm px-4 py-2 focus:border-indigo-500 focus:ring focus:ring-indigo-200" />
                @error('FechaSalida') <p class="text-red-600 mt-1 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="DescripcionProblema" class="block text-gray-700 font-semibold mb-2">Descripción del Problema</label>
                <textarea name="DescripcionProblema" id="DescripcionProblema" rows="3"
                          class="w-full rounded-md border-gray-300 shadow-sm px-4 py-2 focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                          required>{{ old('DescripcionProblema', $reparacion->DescripcionProblema) }}</textarea>
                @error('DescripcionProblema') <p class="text-red-600 mt-1 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="Estado" class="block text-gray-700 font-semibold mb-2">Estado</label>
                <select name="Estado" id="Estado" required
                        class="w-full rounded-md border-gray-300 shadow-sm px-4 py-2 focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                    <option value="Pendiente" {{ old('Estado', $reparacion->Estado) == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="En proceso" {{ old('Estado', $reparacion->Estado) == 'En proceso' ? 'selected' : '' }}>En proceso</option>
                    <option value="Finalizado" {{ old('Estado', $reparacion->Estado) == 'Finalizado' ? 'selected' : '' }}>Finalizado</option>
                </select>
                @error('Estado') <p class="text-red-600 mt-1 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="Costo" class="block text-gray-700 font-semibold mb-2">Costo (Lps.)</label>
                <input type="number" step="0.01" min="0" name="Costo" id="Costo"
                       value="{{ old('Costo', $reparacion->Costo) }}" required
                       class="w-full rounded-md border-gray-300 shadow-sm px-4 py-2 focus:border-indigo-500 focus:ring focus:ring-indigo-200" />
                @error('Costo') <p class="text-red-600 mt-1 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mt-6 text-end flex justify-between">
                <a href="{{ route('reparaciones.index') }}"
                   class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded shadow inline-flex items-center gap-2">
                    <i class="fas fa-times"></i> Cancelar
                </a>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow inline-flex items-center gap-2">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
