<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">✏️ Editar Factura {{ $factura->FacturaID }}</h2>
    </x-slot>

    <div class="p-6 max-w-3xl mx-auto bg-white shadow-md rounded-md">
        <form action="{{ route('facturas.update', $factura->FacturaID) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="ClienteID" class="block text-gray-700 font-semibold mb-2">Cliente ID</label>
                <input type="number" name="ClienteID" id="ClienteID" value="{{ old('ClienteID', $factura->ClienteID) }}" required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                @error('ClienteID') <p class="text-red-600 mt-1 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="EmpleadoID" class="block text-gray-700 font-semibold mb-2">Empleado ID</label>
                <input type="number" name="EmpleadoID" id="EmpleadoID" value="{{ old('EmpleadoID', $factura->EmpleadoID) }}" required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                @error('EmpleadoID') <p class="text-red-600 mt-1 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="Fecha" class="block text-gray-700 font-semibold mb-2">Fecha</label>
                <input type="date" name="Fecha" id="Fecha" value="{{ old('Fecha', $factura->Fecha) }}" required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                @error('Fecha') <p class="text-red-600 mt-1 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="Total" class="block text-gray-700 font-semibold mb-2">Total</label>
                <input type="number" step="0.01" name="Total" id="Total" value="{{ old('Total', $factura->Total) }}" required readonly
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                @error('Total') <p class="text-red-600 mt-1 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Detalles de la Factura</label>
                <div id="detalles" class="space-y-4">
                    @foreach($factura->detalles as $index => $detalle)
                        <div class="detalle-item">
                            <input type="number" name="detalles[{{ $index }}][ProductoID]" value="{{ $detalle->ProductoID }}" placeholder="Producto ID" class="w-full border rounded px-3 py-2" required oninput="calculateSubtotal(this)">
                            <input type="number" name="detalles[{{ $index }}][Cantidad]" value="{{ $detalle->Cantidad }}" placeholder="Cantidad" class="w-full border rounded px-3 py-2" required oninput="calculateSubtotal(this)">
                            <input type="number" step="0.01" name="detalles[{{ $index }}][PrecioUnitario]" value="{{ $detalle->PrecioUnitario }}" placeholder="Precio Unitario" class="w-full border rounded px-3 py-2" required oninput="calculateSubtotal(this)">
                            <input type="number" step="0.01" name="detalles[{{ $index }}][Subtotal]" value="{{ $detalle->Subtotal }}" placeholder="Subtotal" class="w-full border rounded px-3 py-2" readonly>
                        </div>
                    @endforeach
                </div>
                <button type="button" onclick="addDetalle()" class="mt-2 text-blue-600">Agregar Detalle</button>
            </div>

            <div class="mt-6 text-end">
                <a href="{{ route('facturas.index') }}"
                   style="background-color: #dc2626; color: white; font-weight: bold; padding: 10px 20px; border-radius: 8px; display: inline-flex; align-items: center; gap: 8px; text-decoration: none;">
                   ❌ Cancelar
                </a>
                <button type="submit"
                        style="background-color: #2563eb; color: white; font-weight: bold; padding: 10px 20px; border-radius: 8px; display: inline-flex; align-items: center; gap: 8px; border: none;">
                    💾 Actualizar Factura
                </button>
            </div>
        </form>
    </div>

    <script>
        let detalleIndex = {{ count($factura->detalles) }};
        function addDetalle() {
            const detalleHtml = `
                <div class="detalle-item">
                    <input type="number" name="detalles[${detalleIndex}][ProductoID]" placeholder="Producto ID" class="w-full border rounded px-3 py-2" required oninput="calculateSubtotal(this)">
                    <input type="number" name="detalles[${detalleIndex}][Cantidad]" placeholder="Cantidad" class="w-full border rounded px-3 py-2" required oninput="calculateSubtotal(this)">
                    <input type="number" step="0.01" name="detalles[${detalleIndex}][PrecioUnitario]" placeholder="Precio Unitario" class="w-full border rounded px-3 py-2" required oninput="calculateSubtotal(this)">
                    <input type="number" step="0.01" name="detalles[${detalleIndex}][Subtotal]" placeholder="Subtotal" class="w-full border rounded px-3 py-2" readonly>
                </div>`;
            document.getElementById('detalles').insertAdjacentHTML('beforeend', detalleHtml);
            detalleIndex++;
        }

        function calculateSubtotal(input) {
            const detalleItem = input.closest('.detalle-item');
            const cantidad = detalleItem.querySelector('input[name*="[Cantidad]"]').value;
            const precioUnitario = detalleItem.querySelector('input[name*="[PrecioUnitario]"]').value;
            const subtotalField = detalleItem.querySelector('input[name*="[Subtotal]"]');

            const subtotal = (cantidad * precioUnitario) || 0;
            subtotalField.value = subtotal.toFixed(2);

            updateTotal();
        }

        function updateTotal() {
            let total = 0;
            document.querySelectorAll('input[name*="[Subtotal]"]').forEach(subtotalField => {
                total += parseFloat(subtotalField.value) || 0;
            });
            document.getElementById('Total').value = total.toFixed(2);
        }
    </script>
</x-app-layout>