                                                                                                                                                                                                                      <x-app-layout><x-slot name="header">
        <h2 class="text-xl font-bold">🛒 Nuevo Pedido</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-6 bg-white p-6 rounded shadow">
        <form action="{{ route('pedidos.store') }}" method="POST" id="formPedido">
            @csrf

            <div class="mb-4">
                <label for="ClienteID" class="block text-gray-700 font-bold mb-2">Cliente ID</label>
                <input type="number" name="ClienteID" id="ClienteID" placeholder="Ej: 1"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="EmpleadoID" class="block text-gray-700 font-bold mb-2">Empleado ID</label>
                <input type="number" name="EmpleadoID" id="EmpleadoID" placeholder="Ej: 2"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="FechaPedido" class="block text-gray-700 font-bold mb-2">Fecha Pedido</label>
                <input type="date" name="FechaPedido" id="FechaPedido"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="FechaEntrega" class="block text-gray-700 font-bold mb-2">Fecha Entrega</label>
                <input type="date" name="FechaEntrega" id="FechaEntrega"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="Estado" class="block text-gray-700 font-bold mb-2">Estado</label>
                <select id="Estado" name="Estado" class="w-full border rounded px-3 py-2" required>
                    @php
                        $estados = ['Pendiente', 'Enviado', 'Entregado', 'Cancelado'];
                    @endphp
                    @foreach($estados as $estado)
                        <option value="{{ $estado }}">{{ $estado }}</option>
                    @endforeach
                </select>
            </div>

            <h3 class="text-lg font-bold mt-6">Detalles del Pedido</h3>

            <div class="mb-4">
                <label for="ProductoID" class="block text-gray-700 font-bold mb-2">Producto ID</label>
                <input type="number" name="ProductoID" id="ProductoID" placeholder="Ej: 5"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="Cantidad" class="block text-gray-700 font-bold mb-2">Cantidad</label>
                <input type="number" name="Cantidad" id="Cantidad" placeholder="Ej: 10" min="1"
                    class="w-full border rounded px-3 py-2" required oninput="calcularSubtotal()">
            </div>

            <div class="mb-4">
                <label for="PrecioUnitario" class="block text-gray-700 font-bold mb-2">Precio Unitario</label>
                <input type="number" step="0.01" min="0" name="PrecioUnitario" id="PrecioUnitario" placeholder="Ej: 15.50"
                    class="w-full border rounded px-3 py-2" required oninput="calcularSubtotal()">
            </div>

            <div class="mb-4">
                <label for="Subtotal" class="block text-gray-700 font-bold mb-2">Subtotal</label>
                <input type="number" step="0.01" name="Subtotal" id="Subtotal" placeholder="Ej: 155.00"
                    class="w-full border rounded px-3 py-2" readonly>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('pedidos.index') }}"
                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    ❌ Cancelar
                </a>
                 <button type="submit"
                        style="background-color: #2563eb; color: white; font-weight: bold; padding: 10px 20px; border-radius: 8px; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); border: none;">
                    💾 Guardar Pedido
                </button>
            </div>
        </form>
    </div>

    <script>
        function calcularSubtotal() {
            const cantidad = parseFloat(document.getElementById('Cantidad').value) || 0;
            const precioUnitario = parseFloat(document.getElementById('PrecioUnitario').value) || 0;
            const subtotalInput = document.getElementById('Subtotal');
            subtotalInput.value = (cantidad * precioUnitario).toFixed(2);
        }
    </script>
</x-app-layout>