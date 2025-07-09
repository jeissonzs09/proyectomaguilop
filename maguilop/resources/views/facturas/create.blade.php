<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">📝 Nueva Factura</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-6 bg-white p-6 rounded shadow">
        <form action="{{ route('facturas.store') }}" method="POST">
            @csrf

            <!-- Cliente -->
            <div class="mb-4">
    <label for="ClienteID" class="block text-gray-700 font-bold mb-2">Cliente</label>
    <select name="ClienteID" id="ClienteID" class="w-full border rounded px-3 py-2" required>
        <option value="">Seleccione un cliente</option>
        @foreach ($clientes as $cliente)
            <option value="{{ $cliente->ClienteID }}"
                {{ old('ClienteID', $factura->ClienteID ?? '') == $cliente->ClienteID ? 'selected' : '' }}>
                {{ $cliente->NombreCliente }}
            </option>
        @endforeach
    </select>
</div>


            <!-- Empleado -->
            <div class="mb-4">
    <label for="EmpleadoID" class="block text-gray-700 font-bold mb-2">Empleado</label>
    <select name="EmpleadoID" id="EmpleadoID" class="w-full border rounded px-3 py-2" required>
        <option value="">Seleccione un empleado</option>
        @foreach ($empleados as $empleado)
            <option value="{{ $empleado->EmpleadoID }}"
                {{ old('EmpleadoID', $factura->EmpleadoID ?? '') == $empleado->EmpleadoID ? 'selected' : '' }}>
                {{ $empleado->persona->NombreCompleto }}
            </option>
        @endforeach
    </select>
</div>


            <!-- Fecha -->
            <div class="mb-4">
                <label for="Fecha" class="block text-gray-700 font-bold mb-2">Fecha</label>
                <input type="date" name="Fecha" id="Fecha"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <!-- Total (calculado automáticamente) -->
            <div class="mb-4">
                <label for="Total" class="block text-gray-700 font-bold mb-2">Total (Lps.)</label>
                <input type="number" step="0.01" name="Total" id="Total" placeholder="Total automático"
                    class="w-full border rounded px-3 py-2 bg-gray-100" readonly required>
            </div>

            <!-- Detalles -->
            <div class="mb-6">
    <label class="block text-gray-700 font-bold mb-2">Detalles de la Factura</label>
    <div id="detalles" class="space-y-4">
        <div class="detalle-item grid grid-cols-1 md:grid-cols-4 gap-2">
            <select name="detalles[0][ProductoID]" class="border rounded px-3 py-2" required onchange="calculateSubtotal(this)">
                <option value="">Seleccione un producto</option>
                @foreach($productos as $producto)
                    <option value="{{ $producto->ProductoID }}" data-precio="{{ $producto->PrecioVenta }}">
                        {{ $producto->NombreProducto }}
                    </option>
                @endforeach
            </select>
            <input type="number" name="detalles[0][Cantidad]" placeholder="Cantidad" class="border rounded px-3 py-2" required oninput="calculateSubtotal(this)">
            <input type="number" step="0.01" name="detalles[0][PrecioUnitario]" placeholder="Precio Unitario" class="border rounded px-3 py-2" required oninput="calculateSubtotal(this)">
            <input type="number" step="0.01" name="detalles[0][Subtotal]" placeholder="Subtotal" class="border rounded px-3 py-2 bg-gray-100" readonly required>
        </div>
    </div>
    <button type="button" onclick="addDetalle()" class="mt-2 text-blue-600">➕ Agregar Detalle</button>
</div>


            <!-- Botones -->
            <div class="flex justify-between">
                <a href="{{ route('facturas.index') }}"
                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                    ❌ Cancelar
                </a>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center gap-2">
                    💾 Guardar Factura
                </button>
            </div>
        </form>
    </div>

    <script>
        let detalleIndex = 1;

function addDetalle() {
    const container = document.getElementById('detalles');

    const div = document.createElement('div');
    div.className = 'detalle-item grid grid-cols-1 md:grid-cols-4 gap-2 mt-2';

    div.innerHTML = `
        <select name="detalles[${detalleIndex}][ProductoID]" class="border rounded px-3 py-2" required onchange="fillPrecio(this)">
            <option value="">Seleccione un producto</option>
            @foreach($productos as $producto)
                <option value="{{ $producto->ProductoID }}" data-precio="{{ $producto->PrecioVenta }}">
                    {{ $producto->NombreProducto }}
                </option>
            @endforeach
        </select>
        <input type="number" name="detalles[${detalleIndex}][Cantidad]" placeholder="Cantidad" class="border rounded px-3 py-2" required oninput="calculateSubtotal(this)">
        <input type="number" step="0.01" name="detalles[${detalleIndex}][PrecioUnitario]" placeholder="Precio Unitario" class="border rounded px-3 py-2" required oninput="calculateSubtotal(this)">
        <input type="number" step="0.01" name="detalles[${detalleIndex}][Subtotal]" placeholder="Subtotal" class="border rounded px-3 py-2 bg-gray-100" readonly required>
    `;

    container.appendChild(div);
    detalleIndex++;
}

function fillPrecio(select) {
    const selected = select.options[select.selectedIndex];
    const precio = selected.getAttribute('data-precio');

    const item = select.closest('.detalle-item');
    const precioInput = item.querySelector('input[name*="[PrecioUnitario]"]');
    const cantidadInput = item.querySelector('input[name*="[Cantidad]"]');

    if (precioInput) {
        precioInput.value = parseFloat(precio || 0).toFixed(2);
    }

    calculateSubtotal(cantidadInput || precioInput);
}



        function calculateSubtotal(input) {
            const item = input.closest('.detalle-item');
            const cantidad = item.querySelector('input[name*="[Cantidad]"]').value;
            const precio = item.querySelector('input[name*="[PrecioUnitario]"]').value;
            const subtotal = item.querySelector('input[name*="[Subtotal]"]');
            subtotal.value = (cantidad * precio || 0).toFixed(2);
            updateTotal();
        }

        function updateTotal() {
            let total = 0;
            document.querySelectorAll('input[name*="[Subtotal]"]').forEach(input => {
                total += parseFloat(input.value) || 0;
            });
            document.getElementById('Total').value = total.toFixed(2);
        }
    </script>

    
</x-app-layout>