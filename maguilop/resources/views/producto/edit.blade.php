<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">✏️ Editar Producto</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto p-6 bg-white rounded shadow">
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('producto.update', $producto->ProductoID) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="NombreProducto" class="block font-semibold mb-1">Nombre del Producto</label>
                <input type="text" id="NombreProducto" name="NombreProducto"
                       value="{{ old('NombreProducto', $producto->NombreProducto) }}"
                       placeholder="Ej: Refrigeradora LG"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600"
                       required>
            </div>

            <div>
                <label for="Descripcion" class="block font-semibold mb-1">Descripción</label>
                <textarea id="Descripcion" name="Descripcion" rows="3"
                          placeholder="Ej: No Frost, 12 pies"
                          class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('Descripcion', $producto->Descripcion) }}</textarea>
            </div>

            <div>
                <label for="TipoProductoID" class="block font-semibold mb-1">TipoProductoID</label>
                <input type="number" id="TipoProductoID" name="TipoProductoID" value="{{ old('TipoProductoID', $producto->TipoProductoID) }}"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <div>
                <label for="CategorialID" class="block font-semibold mb-1">CategorialID</label>
                <input type="number" id="CategorialID" name="CategorialID" value="{{ old('CategorialID', $producto->CategorialID) }}"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <div>
                <label for="MarcaID" class="block font-semibold mb-1">MarcaID</label>
                <input type="number" id="MarcaID" name="MarcaID" value="{{ old('MarcaID', $producto->MarcaID) }}"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <div>
                <label for="UnidadID" class="block font-semibold mb-1">UnidadID</label>
                <input type="number" id="UnidadID" name="UnidadID" value="{{ old('UnidadID', $producto->UnidadID) }}"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <div>
                <label for="PrecioCompra" class="block font-semibold mb-1">Precio Compra (Lps.)</label>
                <input type="number" step="0.01" id="PrecioCompra" name="PrecioCompra" value="{{ old('PrecioCompra', $producto->PrecioCompra) }}"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <div>
                <label for="PrecioVenta" class="block font-semibold mb-1">Precio Venta (Lps.)</label>
                <input type="number" step="0.01" id="PrecioVenta" name="PrecioVenta" value="{{ old('PrecioVenta', $producto->PrecioVenta) }}"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <div>
                <label for="Stock" class="block font-semibold mb-1">Stock</label>
                <input type="number" id="Stock" name="Stock" value="{{ old('Stock', $producto->Stock) }}"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <div>
                <label for="ProveedorID" class="block font-semibold mb-1">ProveedorID</label>
                <input type="number" id="ProveedorID" name="ProveedorID" value="{{ old('ProveedorID', $producto->ProveedorID) }}"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <div>
                <label for="AlmacenID" class="block font-semibold mb-1">AlmacenID</label>
                <input type="number" id="AlmacenID" name="AlmacenID" value="{{ old('AlmacenID', $producto->AlmacenID) }}"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <div>
                <label for="EmbalajeID" class="block font-semibold mb-1">EmbalajeID</label>
                <input type="number" id="EmbalajeID" name="EmbalajeID" value="{{ old('EmbalajeID', $producto->EmbalajeID) }}"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <div class="flex justify-between pt-6">
                <a href="{{ route('producto.index') }}"
                style="background-color: #dc2626; color: white; font-weight: bold; padding: 10px 20px; border-radius: 8px; display: inline-flex; align-items: center; gap: 8px; text-decoration: none;">
                    ✖️ Cancelar
                </a>

                <button type="submit"
                        style="background-color:rgb(73, 62, 226); color: white; font-weight: bold; padding: 10px 20px; border-radius: 8px; display: inline-flex; align-items: center; gap: 8px; text-decoration: none;">
                    💾 Guardar cambios
                </button>
            </div>
        </form>
    </div>
</x-app-layout>




