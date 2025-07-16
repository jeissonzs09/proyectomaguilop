<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">✏️ Editar Producto</h2>
    </x-slot>

    <div class="p-6 max-w-4xl mx-auto bg-white rounded-md shadow-md">
        {{-- Errores de validación --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded shadow">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulario de edición --}}
        <form method="POST" action="{{ route('producto.update', $producto->ProductoID) }}" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Nombre del producto --}}
            <div>
                <label for="NombreProducto" class="block text-sm font-medium text-gray-700 mb-1">Nombre del producto</label>
                <input type="text" name="NombreProducto" id="NombreProducto" value="{{ old('NombreProducto', $producto->NombreProducto) }}"
                    class="w-full border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring focus:ring-indigo-200" required>
            </div>

            {{-- Descripción --}}
            <div>
                <label for="Descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <textarea name="Descripcion" id="Descripcion" rows="3"
                    class="w-full border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring focus:ring-indigo-200"
                    placeholder="Ej: Detalles del producto">{{ old('Descripcion', $producto->Descripcion) }}</textarea>
            </div>

            {{-- Precios y stock --}}
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label for="PrecioCompra" class="block text-sm font-medium text-gray-700 mb-1">Precio compra (Lps.)</label>
                    <input type="number" step="0.01" name="PrecioCompra" id="PrecioCompra" value="{{ old('PrecioCompra', $producto->PrecioCompra) }}"
                        class="w-full border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring focus:ring-indigo-200" required>
                </div>

                <div>
                    <label for="PrecioVenta" class="block text-sm font-medium text-gray-700 mb-1">Precio venta (Lps.)</label>
                    <input type="number" step="0.01" name="PrecioVenta" id="PrecioVenta" value="{{ old('PrecioVenta', $producto->PrecioVenta) }}"
                        class="w-full border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring focus:ring-indigo-200" required>
                </div>

                <div>
                    <label for="Stock" class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                    <input type="number" name="Stock" id="Stock" value="{{ old('Stock', $producto->Stock) }}"
                        class="w-full border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring focus:ring-indigo-200" required>
                </div>
            </div>

            {{-- Selector de proveedor --}}
            <div>
                <label for="ProveedorID" class="block text-sm font-medium text-gray-700 mb-1">Proveedor</label>
                <select name="ProveedorID" id="ProveedorID"
                    class="w-full border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring focus:ring-indigo-200"
                    required>
                    <option value="">Selecciona un proveedor</option>
                    @foreach ($proveedores as $proveedor)
                        <option value="{{ $proveedor->ProveedorID }}"
                            {{ old('ProveedorID', $producto->ProveedorID) == $proveedor->ProveedorID ? 'selected' : '' }}>
                            {{ $proveedor->Descripcion }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Botones --}}
            <div class="pt-4 flex justify-end space-x-4">
                <a href="{{ route('producto.index') }}"
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-md font-semibold transition">
                    Cancelar
                </a>

                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md font-semibold transition">
                    Actualizar Producto
                </button>
            </div>
        </form>
    </div>
</x-app-layout>





