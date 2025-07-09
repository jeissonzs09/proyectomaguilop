<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">✏️ Editar Factura {{ $factura->FacturaID }}</h2>
    </x-slot>

    <div class="p-6 max-w-3xl mx-auto bg-white shadow-md rounded-md">
        <form action="{{ route('facturas.update', $factura->FacturaID) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Cliente -->
            <div>
                <label for="ClienteID" class="block text-gray-700 font-semibold mb-2">Cliente</label>
                <select name="ClienteID" id="ClienteID" required
                        class="w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Seleccione un cliente</option>
                    @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->ClienteID }}" {{ $factura->ClienteID == $cliente->ClienteID ? 'selected' : '' }}>
                            {{ $cliente->NombreCliente }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Empleado -->
            <div>
                <label for="EmpleadoID" class="block text-gray-700 font-semibold mb-2">Empleado</label>
                <select name="EmpleadoID" id="EmpleadoID" required
                        class="w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Seleccione un empleado</option>
                    @foreach ($empleados as $empleado)
                        <option value="{{ $empleado->EmpleadoID }}" {{ $factura->EmpleadoID == $empleado->EmpleadoID ? 'selected' : '' }}>
                            {{ $empleado->persona->NombreCompleto }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Fecha -->
            <div>
                <label for="Fecha" class="block text-gray-700 font-semibold mb-2">Fecha</label>
                <input type="date" name="Fecha" id="Fecha" value="{{ old('Fecha', $factura->Fecha) }}" required
                       class="w-full rounded-md border-gray-300 shadow-sm" />
            </div>

            <!-- Total -->
            <div>
                <label for="Total" class="block text-gray-700 font-semibold mb-2">Total</label>
                <input type="number" step="0.01" name="Total" id="Total" value="{{ old('Total', $factura->Total) }}" readonly
                       class="w-full rounded-md border-gray-300 bg-gray-100" />
            </div>

            <!-- Detalles -->
            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Detalles de la Factura</label>
                <div id="detalles" class="space-y-4">
                    @foreach($factura->detalles as $index => $detalle)
                        <div class="detalle-item grid grid-cols-1 md:grid-cols-4 gap-2">
                            <select name="detalles[{{ $index }}][ProductoID]" class="border rounded px-3 py-2" required onchange="calculateSubtotal(this)">
                                <option value="">Seleccione un producto</option>
                                @foreach($productos as $producto)
                                    <option value="{{ $producto->ProductoID }}"
                                            data-precio="{{ $producto->PrecioVenta }}"
                                            {{ $detalle->ProductoID == $producto->ProductoID ? 'selected' : '' }}>
                                        {{ $producto->NombreProducto }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="number" name="detalles[{{ $index }}][Cantidad]" value="{{ $detalle->Cantidad }}"
                                   class="border rounded px-3 py-2" required oninput="calculateSubtotal(this)">
                            <input type="number" step="0.01" name="detalles[{{ $index }}][PrecioUnitario]" value="{{ $detalle->PrecioUnitario }}"
                                   class="border rounded px-3 py-2" required oninput="calculateSubtotal(this)">
                            <input type="number" step="0.01" name="detalles[{{ $index }}][Subtotal]" value="{{ $detalle->Subtotal }}"
                                   class="border rounded px-3 py-2 bg-gray-100" readonly>
                        </div>
                    @endforeach
                </div>
                <button type="button" onclick="addDetalle()" class="mt-2 text-blue-600">➕ Agregar Detalle</button>
            </div>

            <!-- Botones -->
            <div class="text-end">
                <a href="{{ route('facturas.index') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">❌ Cancelar</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">💾 Actualizar Factura</button>
            </div>
        </form>
    </div>

    <script>
        let detalleIndex = {{ count($factura->detalles) }};
        const productos = @json($productos);

        function addDetalle() {
            const options = productos.map(p => 
                `<option value="${p.ProductoID}" data-precio="${p.PrecioVenta}">${p.NombreProducto}</option>`).join('');

            const html = `
                <div class="detalle-item grid grid-cols-1 md:grid-cols-4 gap-2 mt-2">
                    <select name="detalles[${detalleIndex}][ProductoID]" class="border rounded px-3 py-2" required onchange="calculateSubtotal(this)">
                        <option value="">Seleccione un producto</option>
                        ${options}
                    </select>
                    <input type="number" name="detalles[${detalleIndex}][Cantidad]" class="border rounded px-3 py-2" required oninput="calculateSubtotal(this)">
                    <input type="number" step="0.01" name="detalles[${detalleIndex}][PrecioUnitario]" class="border rounded px-3 py-2" required oninput="calculateSubtotal(this)">
                    <input type="number" step="0.01" name="detalles[${detalleIndex}][Subtotal]" class="border rounded px-3 py-2 bg-gray-100" readonly>
                </div>`;
            document.getElementById('detalles').insertAdjacentHTML('beforeend', html);
            detalleIndex++;
        }

        function calculateSubtotal(el) {
            const row = el.closest('.detalle-item');
            const productoSelect = row.querySelector('select[name*="[ProductoID]"]');
            const precio = productoSelect?.selectedOptions[0]?.dataset?.precio ?? 0;
            const cantidad = row.querySelector('input[name*="[Cantidad]"]').value;
            const precioUnitario = row.querySelector('input[name*="[PrecioUnitario]"]');
            const subtotal = row.querySelector('input[name*="[Subtotal]"]');

            if (precioUnitario && !precioUnitario.value) {
                precioUnitario.value = precio;
            }

            subtotal.value = (parseFloat(cantidad || 0) * parseFloat(precioUnitario.value || 0)).toFixed(2);
            updateTotal();
        }

        function updateTotal() {
            let total = 0;
            document.querySelectorAll('input[name*="[Subtotal]"]').forEach(el => {
                total += parseFloat(el.value) || 0;
            });
            document.getElementById('Total').value = total.toFixed(2);
        }
    </script>
</x-app-layout>

