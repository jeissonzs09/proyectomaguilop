<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Listado de Ventas</title>
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
        .metadata {
            font-size: 11px;
            text-align: right;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #444;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="header">MAGUILOP</div>
    <h2 style="text-align: center; margin-top: 10px;">Listado de Ventas</h2>

    <div class="metadata">
        <p><strong>Generado:</strong> {{ date('d/m/Y H:i') }}</p>
        <p><strong>Total:</strong> {{ count($ventas) }} registros</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Empleado</th>
                <th>Producto</th>
                <th>Fecha Venta</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $v)
                <tr>
                    <td>{{ $v->VentaID }}</td>
                    <td>{{ $v->cliente->NombreCliente ?? '—' }}</td>
                    <td>
                        @if($v->empleado && $v->empleado->persona)
                            {{ $v->empleado->persona->Nombre }} {{ $v->empleado->persona->Apellido }}
                        @else
                            —
                        @endif
                    </td>
                    <td>{{ $v->producto->NombreProducto ?? '—' }}</td>
                    <td>{{ $v->FechaVenta }}</td>
                    <td>
                        @if(is_numeric($v->TotalVenta))
                            L {{ number_format($v->TotalVenta, 2) }}
                        @else
                            —
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

