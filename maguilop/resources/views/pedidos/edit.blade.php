<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">✏️ Editar Pedido #{{ $pedido->PedidoID }}</h2>
    </x-slot>

    <div class="max-w-5xl mx-auto p-6 bg-white rounded shadow">
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pedido.update', $pedido->PedidoID) }}" method="POST" class="space-y-6" id="formPedido">
            @csrf
            @method('PUT')

            {{-- Datos del Pedido --}}
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label for="ClienteID" class="block font-semibold mb-1">ClienteID</label>
                    <input type="number" id="ClienteID" name="ClienteID" value="{{ old('ClienteID', $pedido->ClienteID) }}"
                           class="w-full border rounded px-3 py-2" required>
                </div>

                <div>
                    <label for="EmpleadoID" class="block font-semibold mb-1">EmpleadoID</label>
                    <input type="number" id="EmpleadoID" name="EmpleadoID" value="{{ old('EmpleadoID', $pedido->EmpleadoID) }}"
                           class="w-full border rounded px-3 py-2" required>
                </div>

                <div>
                    <label for="FechaPedido" class="block font-semibold mb-1">Fecha Pedido</label>
                    <input type="datetime-local" id="FechaPedido" name="FechaPedido"
                           value="{{ old('FechaPedido', \Carbon\Carbon::parse($pedido->FechaPedido)->format('Y-m-d\TH:i')) }}"
                           class="w-full border rounded px-3 py-2" required>
                </div>

                <div>
                    <label for="FechaEntrega" class="block font-semibold mb-1">Fecha Entrega</label>
                    <input type="date" id="FechaEntrega" name="FechaEntrega"
                           value="{{ old('FechaEntrega', $pedido->FechaEntrega ? \Carbon\Carbon::parse($pedido->FechaEntrega)->format('Y-m-d') : '') }}"
                           class="w-full border rounded px-3 py-2">
                </div>

                <div>
                    <label for="Estado" class="block font-semibold mb-1">Estado</label>
                    <select id="Estado" name="Estado" class="w-full border rounded px-3 py-2" required>
                        @php
                            $estados = ['Pendiente', 'Enviado', 'Entregado', 'Cancelado'];
                            $selectedEstado = old('Estado', $pedido->Estado);
                        @endphp
                        @foreach($estados as $estado)
                            <option value="{{ $estado }}" {{ $selectedEstado === $estado ? 'selected' : '' }}>
                                {{ $estado }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Detalles del pedido (productos) --}}
            <div>
                <h3 class="font-semibold text-lg mb-2">Detalles del Pedido</h3>

                <table class="w-full border rounded-lg shadow text-sm">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="border px-3 py-2">ProductoID</th>
                            <th class="border px-3 py-2">Cantidad</th>
                            <th class="border px-3 py-2">Precio Unitario</th>
                            <th class="border px-3 py-2">Subtotal</th>
                            <th class="border px-3 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="detalleBody">
                        @foreach(old('detalles', $pedido->detalles->toArray()) as $index => $detalle)
                        <tr class="detalle-row">
                            <td class="border px-3 py-2">
                                <input type="number" name="detalles[{{ $index }}][ProductoID]" 
                                       value="{{ $detalle['ProductoID'] ?? '' }}" required
                                       class="w-full border rounded px-2 py-1 producto-id">
                            </td>
                            <td class="border px-3 py-2">
                                <input type="number" name="detalles[{{ $index }}][Cantidad]" min="1"
                                       value="{{ $detalle['Cantidad'] ?? 1 }}" required
                                       class="w-full border rounded px-2 py-1 cantidad" oninput="calcularSubtotal(this)">
                            </td>
                            <td class="border px-3 py-2">
                                <input type="number" step="0.01" min="0" name="detalles[{{ $index }}][PrecioUnitario]"
                                       value="{{ $detalle['PrecioUnitario'] ?? 0 }}" required
                                       class="w-full border rounded px-2 py-1 precio-unitario" oninput="calcularSubtotal(this)">
                            </td>
                            <td class="border px-3 py-2 text-right subtotal">
                                {{ number_format(($detalle['Cantidad'] ?? 0) * ($detalle['PrecioUnitario'] ?? 0), 2) }}
                            </td>
                            <td class="border px-3 py-2 text-center">
                                <button type="button" onclick="eliminarFila(this)" class="text-red-600 font-bold hover:text-red-800">✖️</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <button type="button" class="mt-3 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700" onclick="agregarFila()">➕ Añadir Producto</button>
            </div>

            <div class="flex justify-between pt-6">
                <a href="{{ route('pedidos.index') }}"
                   class="bg-red-600 text-white font-bold px-6 py-2 rounded hover:bg-red-700 inline-flex items-center gap-2">
                   ✖️ Cancelar
                </a>
               <button type="submit"
                        style="background-color: #2563eb; color: white; font-weight: bold; padding: 10px 20px; border-radius: 8px; display: inline-flex; align-items: center; gap: 8px; border: none;">
                    💾 Actualizar Pedido
                </button>
        </form>
    </div>

    <script>
        // Función para recalcular subtotal en la fila actual
        function calcularSubtotal(input) {
            const fila = input.closest('tr');
            const cantidadInput = fila.querySelector('.cantidad');
            const precioInput = fila.querySelector('.precio-unitario');
            const subtotalCell = fila.querySelector('.subtotal');

            let cantidad = parseFloat(cantidadInput.value) || 0;
            let precio = parseFloat(precioInput.value) || 0;
            let subtotal = cantidad * precio;

            subtotalCell.textContent = subtotal.toFixed(2);
        }

        // Función para eliminar fila
        function eliminarFila(button) {
            const fila = button.closest('tr');
            fila.remove();
            reindexarFilas();
        }

        // Función para agregar una nueva fila en detalles
        function agregarFila() {
            const tbody = document.getElementById('detalleBody');
            const index = tbody.children.length;

            const fila = document.createElement('tr');
            fila.classList.add('detalle-row');
            fila.innerHTML = `
                <td class="border px-3 py-2">
                    <input type="number" name="detalles[${index}][ProductoID]" required
                           class="w-full border rounded px-2 py-1 producto-id" />
                </td>
                <td class="border px-3 py-2">
                    <input type="number" name="detalles[${index}][Cantidad]" min="1" value="1" required
                           class="w-full border rounded px-2 py-1 cantidad" oninput="calcularSubtotal(this)" />
                </td>
                <td class="border px-3 py-2">
                    <input type="number" name="detalles[${index}][PrecioUnitario]" step="0.01" min="0" value="0" required
                           class="w-full border rounded px-2 py-1 precio-unitario" oninput="calcularSubtotal(this)" />
                </td>
                <td class="border px-3 py-2 text-right subtotal">0.00</td>
                <td class="border px-3 py-2 text-center">
                    <button type="button" onclick="eliminarFila(this)" class="text-red-600 font-bold hover:text-red-800">✖️</button>
                </td>
            `;

            tbody.appendChild(fila);
        }

        // Reindexar los nombres de los inputs para mantener la numeración correcta después de eliminar filas
        function reindexarFilas() {
            const filas = document.querySelectorAll('#detalleBody tr.detalle-row');
            filas.forEach((fila, i) => {
                fila.querySelectorAll('input').forEach(input => {
                    const name = input.getAttribute('name');
                    const nuevaName = name.replace(/detalles\[\d+\]/, `detalles[${i}]`);
                    input.setAttribute('name', nuevaName);
                });
            });
        }
    </script>
</x-app-layout>
