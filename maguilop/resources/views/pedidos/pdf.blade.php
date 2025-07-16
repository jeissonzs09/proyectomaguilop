<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Listado de Pedidos</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; margin: 30px; }
        .header {
            background-color: #f97316;
            color: white;
            text-align: center;
            padding: 15px 0;
            font-size: 20px;
            font-weight: bold;
            border-radius: 6px;
        }
        .metadata { font-size: 11px; text-align: right; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #444; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="header">MAGUILOP</div>
    <h2 style="text-align: center; margin-top: 10px;">Listado de Pedidos</h2>

    <div class="metadata">
        <p><strong>Generado:</strong> {{ date('d/m/Y H:i') }}</p>
        <p><strong>Total:</strong> {{ count($pedidos) }} registros</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Empleado</th>
                <th>Producto</th>
                <th>Fecha Pedido</th>
                <th>Fecha Entrega</th>
                <th>Estado</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedidos as $p)
                <tr>
                    <td>{{ $p->PedidoID }}</td>
                    <td>{{ $p->cliente->NombreCliente ?? '—' }}</td>
                    <td>
                        @if($p->empleado && $p->empleado->persona)
                            {{ $p->empleado->persona->Nombre }} {{ $p->empleado->persona->Apellido }}
                        @else
                            —
                        @endif
                    </td>
                    <td>{{ $p->producto->NombreProducto ?? '—' }}</td>
                    <td>{{ $p->FechaPedido }}</td>
                    <td>{{ $p->FechaEntrega }}</td>
                    <td>{{ $p->Estado }}</td>
                    <td>{{ $p->Cantidad }}</td>
                    <td>L {{ number_format($p->PrecioUnitario, 2) }}</td>
                    <td>L {{ number_format($p->Subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
