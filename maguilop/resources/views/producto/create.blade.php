<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">➕ Registrar Producto</h2>
    </x-slot>

    <div class="p-4 max-w-4xl mx-auto">
        {{-- Mostrar errores --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('producto.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="NombreProducto" class="block font-semibold mb-1">Nombre del Producto</label>
                <input type="text" id="NombreProducto" name="NombreProducto"
                       value="{{ old('NombreProducto') }}"
                       placeholder="Ej: Refrigeradora LG"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600"
                       required>
            </div>

            <div>
                <label for="Descripcion" class="block font-semibold mb-1">Descripción</label>
                <textarea id="Descripcion" name="Descripcion" rows="3"
                          placeholder="Ej: No Frost, 12 pies"
                          class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('Descripcion') }}</textarea>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label for="TipoProductoID" class="block font-semibold mb-1">TipoProductoID</label>
                    <input type="number" id="TipoProductoID" name="TipoProductoID" value="{{ old('TipoProductoID') }}"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div>
                    <label for="CategorialID" class="block font-semibold mb-1">CategorialID</label>
                    <input type="number" id="CategorialID" name="CategorialID" value="{{ old('CategorialID') }}"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div>
                    <label for="MarcaID" class="block font-semibold mb-1">MarcaID</label>
                    <input type="number" id="MarcaID" name="MarcaID" value="{{ old('MarcaID') }}"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label for="UnidadID" class="block font-semibold mb-1">UnidadID</label>
                    <input type="number" id="UnidadID" name="UnidadID" value="{{ old('UnidadID') }}"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div>
                    <label for="PrecioCompra" class="block font-semibold mb-1">Precio Compra (Lps.)</label>
                    <input type="number" step="0.01" id="PrecioCompra" name="PrecioCompra" value="{{ old('PrecioCompra') }}"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div>
                    <label for="PrecioVenta" class="block font-semibold mb-1">Precio Venta (Lps.)</label>
                    <input type="number" step="0.01" id="PrecioVenta" name="PrecioVenta" value="{{ old('PrecioVenta') }}"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label for="Stock" class="block font-semibold mb-1">Stock</label>
                    <input type="number" id="Stock" name="Stock" value="{{ old('Stock') }}"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div>
                    <label for="ProveedorID" class="block font-semibold mb-1">ProveedorID</label>
                    <input type="number" id="ProveedorID" name="ProveedorID" value="{{ old('ProveedorID') }}"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div>
                    <label for="AlmacenID" class="block font-semibold mb-1">AlmacenID</label>
                    <input type="number" id="AlmacenID" name="AlmacenID" value="{{ old('AlmacenID') }}"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
            </div>

            <div>
                <label for="EmbalajeID" class="block font-semibold mb-1">EmbalajeID</label>
                <input type="number" id="EmbalajeID" name="EmbalajeID" value="{{ old('EmbalajeID') }}"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <div class="pt-4">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-semibold transition">
                    Registrar Producto
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
