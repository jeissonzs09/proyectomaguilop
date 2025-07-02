<?php

namespace App\Http\Controllers;

use App\Models\Pedido; // Verifica que este importado
use Illuminate\Http\Request;

class PedidoController extends Controller
{
  
public function index()
{
    $pedidos = Pedido::paginate(10); // ✅ Habilita ->links() en la vista
    return view('pedidos.index', compact('pedidos'));
}

    public function create()
    {
        return view('pedidos.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'ClienteID' => 'required|integer|exists:cliente,ClienteID',
        'EmpleadoID' => 'required|integer|exists:empleado,EmpleadoID',
        'FechaPedido' => 'required|date',
        'FechaEntrega' => 'required|date|after_or_equal:FechaPedido',
        'Estado' => 'required|string|max:255',
        'ProductoID' => 'required|integer|exists:producto,ProductoID',
        'Cantidad' => 'required|integer|min:1',
        'PrecioUnitario' => 'required|numeric|min:0',
    ]);

    $pedido = Pedido::create([
        'ClienteID' => $request->ClienteID,
        'EmpleadoID' => $request->EmpleadoID,
        'FechaPedido' => $request->FechaPedido,
        'FechaEntrega' => $request->FechaEntrega,
        'Estado' => $request->Estado,
    ]);

    $pedido->detalles()->create([
        'ProductoID' => $request->ProductoID,
        'Cantidad' => $request->Cantidad,
        'PrecioUnitario' => $request->PrecioUnitario,
        'Subtotal' => $request->Cantidad * $request->PrecioUnitario,
    ]);

    return redirect()->route('pedidos.index')->with('success', 'Pedido creado correctamente.');
}


    public function edit($id)
    {
        $pedido = Pedido::findOrFail($id);
        return view('pedidos.edit', compact('pedido'));
    }

public function update(Request $request, $id)
{
    $pedido = Pedido::findOrFail($id);

    // Validar pedido
    $request->validate([
        'ClienteID' => 'required|integer',
        'EmpleadoID' => 'required|integer',
        'FechaPedido' => 'required|date',
        'FechaEntrega' => 'nullable|date',
        'Estado' => 'required|in:Pendiente,Enviado,Entregado,Cancelado',
        'detalles' => 'required|array|min:1',
        'detalles.*.ProductoID' => 'required|integer',
        'detalles.*.Cantidad' => 'required|integer|min:1',
        'detalles.*.PrecioUnitario' => 'required|numeric|min:0',
    ]);

    // Actualizar datos del pedido
    $pedido->ClienteID = $request->ClienteID;
    $pedido->EmpleadoID = $request->EmpleadoID;
    $pedido->FechaPedido = $request->FechaPedido;
    $pedido->FechaEntrega = $request->FechaEntrega;
    $pedido->Estado = $request->Estado;
    $pedido->save();

    // Actualizar detalles
    // Primero eliminar todos los detalles actuales para simplificar la lógica
    $pedido->detalles()->delete();

    // Insertar detalles nuevos
    foreach ($request->detalles as $detalleData) {
        $pedido->detalles()->create([
            'ProductoID' => $detalleData['ProductoID'],
            'Cantidad' => $detalleData['Cantidad'],
            'PrecioUnitario' => $detalleData['PrecioUnitario'],
            'Subtotal' => $detalleData['Cantidad'] * $detalleData['PrecioUnitario'],
        ]);
    }

    return redirect()->route('pedidos.index')->with('success', 'Pedido actualizado correctamente.');
}


    public function destroy($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->delete();

        return redirect()->route('pedidos.index')->with('success', 'Pedido eliminado correctamente.');
    }
}