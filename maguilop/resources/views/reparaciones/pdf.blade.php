<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Listado de Reparaciones</title>
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
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border: 1px solid #444; padding: 6px; text-align: left; }
    th { background-color: #f2f2f2; }

        .logo-title {
            margin-top: 10px;
            text-align: center;
        }
        .logo-title img {
            max-width: 120px;
            margin-bottom: 5px;
        }
        .metadata {
            font-size: 11px;
            text-align: right;
            margin-bottom: 10px;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #444; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

    {{-- Encabezado anaranjado --}}
    <div class="header">
        MAGUILOP
    </div>
    {{-- Logo opcional centrado debajo --}}
    <div class="logo-title">
        <h2>Listado de Reparaciones</h2>
    </div>

    {{-- Datos de generación --}}
    <div class="metadata">
        <p><strong>Generado:</strong> {{ date('d/m/Y H:i') }}</p>
        <p><strong>Total:</strong> {{ count($reparaciones) }} registros</p>
    </div>

    {{-- Tabla de reparaciones --}}
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Producto</th>
                <th>Estado</th>
                <th>Problema</th>
                <th>Entrada</th>
                <th>Salida</th>
                <th>Costo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reparaciones as $r)
                <tr>
                    <td>{{ $r->ReparacionID }}</td>
                    <td>{{ $r->cliente->NombreCliente ?? '—' }}</td>
                    <td>{{ $r->producto->NombreProducto ?? '—' }}</td>
                    <td>{{ $r->Estado }}</td>
                    <td>{{ $r->DescripcionProblema }}</td>
                    <td>{{ $r->FechaEntrada }}</td>
                    <td>{{ $r->FechaSalida }}</td>
                    <td>L {{ number_format($r->Costo, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>





