<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">📦 Editar Proveedor</h2>
    </x-slot>

    <div class="p-4">
        <form action="{{ route('proveedores.update', $proveedor->ProveedorID) }}" method="POST">
            @csrf
            @method('PUT')

            @if ($errors->any())
                <div class="mb-4">
                    <ul class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-4">
                <label for="PersonaID" class="block text-gray-700 font-bold mb-2">Persona ID</label>
                <input type="number" name="PersonaID" id="PersonaID" value="{{ old('PersonaID', $proveedor->PersonaID) }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="EmpresaID" class="block text-gray-700 font-bold mb-2">Empresa ID</label>
                <input type="number" name="EmpresaID" id="EmpresaID" value="{{ old('EmpresaID', $proveedor->EmpresaID) }}" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label for="RTN" class="block text-gray-700 font-bold mb-2">RTN</label>
                <input type="text" name="RTN" id="RTN" value="{{ old('RTN', $proveedor->RTN) }}" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label for="Descripcion" class="block text-gray-700 font-bold mb-2">Descripción</label>
                <textarea name="Descripcion" id="Descripcion" rows="3" class="w-full border rounded px-3 py-2" placeholder="Descripción del proveedor">{{ old('Descripcion', $proveedor->Descripcion) }}</textarea>
            </div>

            <div class="mb-4">
                <label for="URL_Website" class="block text-gray-700 font-bold mb-2">Sitio Web</label>
                <input type="url" name="URL_Website" id="URL_Website" value="{{ old('URL_Website', $proveedor->URL_Website) }}" class="w-full border rounded px-3 py-2">
                @error('URL_Website') <p class="text-red-600 mt-1 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="Ubicacion" class="block text-gray-700 font-bold mb-2">Ubicación</label>
                <input type="text" name="Ubicacion" id="Ubicacion" value="{{ old('Ubicacion', $proveedor->Ubicacion) }}" placeholder="Ej: Ciudad, País" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label for="Telefono" class="block text-gray-700 font-bold mb-2">Teléfono</label>
                <input type="text" name="Telefono" id="Telefono" value="{{ old('Telefono', $proveedor->Telefono) }}" placeholder="Ej: +504 1234-5678" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label for="CorreoElectronico" class="block text-gray-700 font-bold mb-2">Correo Electrónico</label>
                <input type="email" name="CorreoElectronico" id="CorreoElectronico" value="{{ old('CorreoElectronico', $proveedor->CorreoElectronico) }}" placeholder="correo@ejemplo.com" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label for="TipoProveedor" class="block text-gray-700 font-bold mb-2">Tipo Proveedor</label>
                <select name="TipoProveedor" id="TipoProveedor" class="w-full border rounded px-3 py-2" required>
                    <option value="Local" {{ old('TipoProveedor', $proveedor->TipoProveedor) == 'Local' ? 'selected' : '' }}>Local</option>
                    <option value="Internacional" {{ old('TipoProveedor', $proveedor->TipoProveedor) == 'Internacional' ? 'selected' : '' }}>Internacional</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="FechaRegistro" class="block text-gray-700 font-bold mb-2">Fecha de Registro</label>
                <input type="date" name="FechaRegistro" id="FechaRegistro" value="{{ old('FechaRegistro', $proveedor->FechaRegistro) }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="Estado" class="block text-gray-700 font-bold mb-2">Estado</label>
                <select name="Estado" id="Estado" class="w-full border rounded px-3 py-2" required>
                    <option value="Activo" {{ old('Estado', $proveedor->Estado) == 'Activo' ? 'selected' : '' }}>Activo</option>
                    <option value="Inactivo" {{ old('Estado', $proveedor->Estado) == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('proveedores.index') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
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