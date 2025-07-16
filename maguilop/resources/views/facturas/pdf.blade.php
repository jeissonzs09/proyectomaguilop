<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Listado de Facturas</title>
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
    <h2 style="text-align: center; margin-top: 10px;">Listado de Facturas</h2>

    <div class="metadata">
        <p><strong>Generado:</strong> {{ date('d/m/Y H:i') }}</p>
        <p><strong>Total:</strong> {{ count($facturas) }} registros</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Empleado</th>
                <th>Producto</th>
                <th>Fecha</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($facturas as $f)
<tr>
    <td>{{ $f->FacturaID }}</td>
    <td>{{ $f->cliente->NombreCliente ?? '—' }}</td>
    <td>
        @if($f->empleado && $f->empleado->persona)
            {{ $f->empleado->persona->Nombre }} {{ $f->empleado->persona->Apellido }}
        @else
            —
        @endif
    </td>
    <td>
        @foreach($f->detalles as $d)
            {{ $d->producto->NombreProducto ?? '—' }}<br>
        @endforeach
    </td>
    <td>{{ $f->Fecha ?? '—' }}</td>
    <td>
        @foreach($f->detalles as $d)
            {{ $d->Cantidad }}<br>
        @endforeach
    </td>
    <td>
        @foreach($f->detalles as $d)
            L {{ number_format($d->PrecioUnitario, 2) }}<br>
        @endforeach
    </td>
    <td>
        @foreach($f->detalles as $d)
            L {{ number_format($d->Subtotal, 2) }}<br>
        @endforeach
    </td>
    <td>
        @if(is_numeric($f->Total))
            L {{ number_format($f->Total, 2) }}
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
