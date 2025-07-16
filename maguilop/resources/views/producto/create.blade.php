<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">➕ Registrar Producto</h2>
    </x-slot>

    <div class="p-6 max-w-4xl mx-auto bg-white rounded-md shadow-md">
        {{-- Mensajes de error --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-md shadow">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulario --}}
        <form method="POST" action="{{ route('producto.store') }}" class="space-y-6">
            @csrf

            {{-- Nombre del producto --}}
            <div>
                <label for="NombreProducto" class="block text-sm font-medium text-gray-700 mb-1">Nombre del producto</label>
                <input type="text" name="NombreProducto" id="NombreProducto" value="{{ old('NombreProducto') }}"
                    class="w-full border-gray-300 rounded-md shadow-sm px-4 py-2 focus:outline-none focus:ring focus:ring-indigo-200" required>
            </div>

            {{-- Descripción --}}
            <div>
                <label for="Descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <textarea name="Descripcion" id="Descripcion" rows="3"
                    class="w-full border-gray-300 rounded-md shadow-sm px-4 py-2 focus:outline-none focus:ring focus:ring-indigo-200"
                    placeholder="Ej: No frost, tamaño 12 pies">{{ old('Descripcion') }}</textarea>
            </div>

            {{-- Precios y stock --}}
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label for="PrecioCompra" class="block text-sm font-medium text-gray-700 mb-1">Precio de compra (Lps.)</label>
                    <input type="number" step="0.01" name="PrecioCompra" id="PrecioCompra" value="{{ old('PrecioCompra') }}"
                        class="w-full border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring focus:ring-indigo-200" required>
                </div>

                <div>
                    <label for="PrecioVenta" class="block text-sm font-medium text-gray-700 mb-1">Precio de venta (Lps.)</label>
                    <input type="number" step="0.01" name="PrecioVenta" id="PrecioVenta" value="{{ old('PrecioVenta') }}"
                        class="w-full border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring focus:ring-indigo-200" required>
                </div>

                <div>
                    <label for="Stock" class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                    <input type="number" name="Stock" id="Stock" value="{{ old('Stock') }}"
                        class="w-full border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring focus:ring-indigo-200" required>
                </div>
            </div>

            {{-- Selector de proveedor --}}
            <div>
                <label for="ProveedorID" class="block text-sm font-medium text-gray-700 mb-1">Proveedor</label>
                <select name="ProveedorID" id="ProveedorID"
                    class="w-full border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring focus:ring-indigo-200" required>
                    <option value="">Selecciona un proveedor</option>
                    @foreach ($proveedores as $proveedor)
                        <option value="{{ $proveedor->ProveedorID }}"
                            {{ old('ProveedorID') == $proveedor->ProveedorID ? 'selected' : '' }}>
                            {{ $proveedor->Descripcion }}
                        </option>
                    @endforeach
                </select>
            </div>

<div class="pt-4 flex justify-end space-x-4">
    {{-- Botón cancelar en rojo --}}
    <a href="{{ route('producto.index') }}"
       class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-md font-semibold transition">
        Cancelar
    </a>

    {{-- Botón registrar --}}
    <button type="submit"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md font-semibold transition">
        Registrar Producto
    </button>
</div>

        </form>
    </div>
</x-app-layout>


