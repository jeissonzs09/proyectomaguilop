<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">✏️ Editar Pedido #{{ $pedido->PedidoID }}</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-6 bg-white p-6 rounded shadow">
        <form action="{{ route('pedidos.update', $pedido->PedidoID) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Cliente --}}
            <div class="mb-4">
                <label for="ClienteID" class="block font-bold mb-1">Cliente</label>
                <select name="ClienteID" id="ClienteID" class="w-full border rounded px-3 py-2" required>
                    <option value="">Seleccione un cliente</option>
                    @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->ClienteID }}" {{ $cliente->ClienteID == $pedido->ClienteID ? 'selected' : '' }}>
                            {{ $cliente->NombreCliente }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Empleado --}}
            <div class="mb-4">
                <label for="EmpleadoID" class="block font-bold mb-1">Empleado</label>
                <select name="EmpleadoID" id="EmpleadoID" class="w-full border rounded px-3 py-2" required>
                    <option value="">Seleccione un empleado</option>
                    @foreach ($empleados as $empleado)
                        <option value="{{ $empleado->EmpleadoID }}" {{ $empleado->EmpleadoID == $pedido->EmpleadoID ? 'selected' : '' }}>
                            {{ $empleado->persona->NombreCompleto ?? 'Empleado #' . $empleado->EmpleadoID }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Fecha Pedido --}}
            <div class="mb-4">
                <label for="FechaPedido" class="block font-bold mb-1">Fecha Pedido</label>
                <input type="datetime-local" name="FechaPedido" id="FechaPedido" class="w-full border rounded px-3 py-2"
                       value="{{ \Carbon\Carbon::parse($pedido->FechaPedido)->format('Y-m-d\TH:i') }}" required>
            </div>

            {{-- Fecha Entrega --}}
            <div class="mb-4">
                <label for="FechaEntrega" class="block font-bold mb-1">Fecha Entrega</label>
                <input type="date" name="FechaEntrega" id="FechaEntrega" class="w-full border rounded px-3 py-2"
                       value="{{ \Carbon\Carbon::parse($pedido->FechaEntrega)->format('Y-m-d') }}" required>
            </div>

            {{-- Estado --}}
            <div class="mb-4">
                <label for="Estado" class="block font-bold mb-1">Estado</label>
                <select name="Estado" id="Estado" class="w-full border rounded px-3 py-2" required>
                    @foreach(['Pendiente', 'Enviado', 'Entregado', 'Cancelado'] as $estado)
                        <option value="{{ $estado }}" {{ $pedido->Estado === $estado ? 'selected' : '' }}>{{ $estado }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Detalles del Pedido --}}
            <h3 class="font-bold mt-6 mb-2">Detalles del Pedido</h3>
            <div id="detalles">
                @foreach ($pedido->detalles as $i => $detalle)
                    <div class="flex gap-2 mb-2">
                        <select name="detalles[{{ $i }}][ProductoID]" class="border rounded px-2 py-1 w-1/3" required>
                            <option value="">Producto</option>
                            @foreach ($productos as $producto)
                                <option value="{{ $producto->ProductoID }}" {{ $producto->ProductoID == $detalle->ProductoID ? 'selected' : '' }}>
                                    {{ $producto->NombreProducto }}
                                </option>
                            @endforeach
                        </select>

                        <input type="number" name="detalles[{{ $i }}][Cantidad]" class="border rounded px-2 py-1 w-1/4"
                               placeholder="Cantidad" value="{{ $detalle->Cantidad }}" required>

                        <input type="number" step="0.01" name="detalles[{{ $i }}][PrecioUnitario]" class="border rounded px-2 py-1 w-1/4"
                               placeholder="Precio Unitario" value="{{ $detalle->PrecioUnitario }}" required>

                        <span class="px-2 py-1 w-1/4 text-right font-semibold">L. {{ number_format($detalle->Subtotal, 2) }}</span>
                    </div>
                @endforeach
            </div>

            {{-- Botones --}}
            <div class="flex justify-between mt-6">
                <a href="{{ route('pedidos.index') }}"
                   class="bg-red-600 hover:bg-red-700 text-white font-bold px-4 py-2 rounded">❌ Cancelar</a>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded">💾 Actualizar Pedido</button>
            </div>
        </form>
    </div>
</x-app-layout>

