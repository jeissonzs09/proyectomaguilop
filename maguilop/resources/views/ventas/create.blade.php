<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">🛒 Nueva Venta</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-6 bg-white p-6 rounded shadow">
        <form action="{{ route('ventas.store') }}" method="POST">
            @csrf

            {{-- Cliente --}}
            <div class="mb-4">
                <label for="ClienteID" class="block text-gray-700 font-bold mb-2">Cliente</label>
                <select name="ClienteID" id="ClienteID" class="w-full border rounded px-3 py-2" required>
                    <option value="">Seleccione un cliente</option>
                    @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->ClienteID }}">{{ $cliente->NombreCliente }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Empleado --}}
            <div class="mb-4">
                <label for="EmpleadoID" class="block text-gray-700 font-bold mb-2">Empleado</label>
                <select name="EmpleadoID" id="EmpleadoID" class="w-full border rounded px-3 py-2" required>
                    <option value="">Seleccione un empleado</option>
                    @foreach ($empleados as $empleado)
                        <option value="{{ $empleado->EmpleadoID }}">
    {{ $empleado->persona->Nombre }} {{ $empleado->persona->Apellido }}
</option>
                    @endforeach
                </select>
            </div>

            {{-- Fecha --}}
            <div class="mb-4">
                <label for="FechaVenta" class="block text-gray-700 font-bold mb-2">Fecha Venta</label>
                <input type="date" name="FechaVenta" id="FechaVenta"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
    <label for="ProductoID" class="block text-gray-700 font-bold mb-2">Producto</label>
    <select name="ProductoID" id="ProductoID" class="w-full border rounded px-3 py-2" required>
        <option value="">Seleccione un producto</option>
        @foreach ($productos as $producto)
            <option value="{{ $producto->ProductoID }}" data-precio="{{ $producto->PrecioVenta }}">
                {{ $producto->NombreProducto }}
            </option>
        @endforeach
    </select>
</div>

            {{-- Total --}}
            <div class="mb-4">
                <label for="TotalVenta" class="block text-gray-700 font-bold mb-2">Total Venta</label>
                <input type="number" step="0.01" name="TotalVenta" id="TotalVenta" placeholder="Ej: 150.00"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            {{-- Botones --}}
            <div class="flex justify-between">
                <a href="{{ route('ventas.index') }}"
                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                    ❌ Cancelar
                </a>
                <button type="submit"
                    style="background-color: #2563eb; color: white; font-weight: bold; padding: 10px 20px; border-radius: 8px; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); border: none;">
                    💾 Guardar Venta
                </button>
            </div>
        </form>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const productoSelect = document.getElementById('ProductoID');
        const totalInput = document.getElementById('TotalVenta');

        productoSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const precio = selectedOption.getAttribute('data-precio');
            if (precio) {
                totalInput.value = parseFloat(precio).toFixed(2);
            } else {
                totalInput.value = '';
            }
        });
    });
</script>

</x-app-layout>
