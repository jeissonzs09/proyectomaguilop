<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Listado de Productos</title>
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
    <h2 style="text-align: center; margin-top: 10px;">Listado de Productos</h2>

    <div class="metadata">
        <p><strong>Generado:</strong> {{ date('d/m/Y H:i') }}</p>
        <p><strong>Total:</strong> {{ count($productos) }} registros</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Descripción</th>
                <th>Precio Compra</th>
                <th>Precio Venta</th>
                <th>Stock</th>
                <th>Proveedor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $p)
                <tr>
                    <td>{{ $p->ProductoID }}</td>
                    <td>{{ $p->NombreProducto }}</td>
                    <td>{{ $p->Descripcion }}</td>
                    <td>L {{ number_format($p->PrecioCompra, 2) }}</td>
                    <td>L {{ number_format($p->PrecioVenta, 2) }}</td>
                    <td>{{ $p->Stock }}</td>
                    <td>{{ $p->proveedor->NombreProveedor ?? '—' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
