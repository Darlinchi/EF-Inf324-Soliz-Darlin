<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Usuario;
use App\Models\Producto;

class PedidoController extends Controller
{

    public function index()
    {
        // Obtener los pedidos con los usuarios y productos relacionados
        $pedidos = Pedido::with(['usuario', 'producto'])->get();

        // Cambiar 'pedidos.index' por 'pedidos' ya que el archivo de vista es 'pedidos.blade.php'
        return view('pedidos', compact('pedidos'));
    }

    public function create()
    {
        $usuarios = Usuario::all(); // Obtener todos los usuarios
        $productos = Producto::all(); // Obtener todos los productos
        return view('crearPedido', compact('usuarios', 'productos')); // Cambiar 'pedidos.create' a 'crearPedido'
    }

    public function store(Request $request)
    {
        // Validar los datos
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id', // Validar que el usuario exista
            'producto_id' => 'required|exists:productos,id', // Validar que el producto exista
            'cantidad' => 'required|numeric|min:1', // Validar que la cantidad sea un número positivo
        ]);

        // Obtener el producto seleccionado
        $producto = Producto::find($request->producto_id);

        // Calcular el total (precio del producto * cantidad)
        $total = $producto->precio * $request->cantidad;

        // Crear el pedido
        Pedido::create([
            'usuario_id' => $request->usuario_id,
            'producto_id' => $request->producto_id,
            'cantidad' => $request->cantidad,
            'total' => $total, // Asignar el total calculado
        ]);

        // Redirigir o mostrar un mensaje de éxito
        return redirect()->route('pedidos.index')->with('success', 'Pedido creado exitosamente');
    }

    public function edit($id)
    {
        $pedido = Pedido::findOrFail($id);
        $usuarios = Usuario::all();
        $productos = Producto::all();
    
        return view('editarPedido', compact('pedido', 'usuarios', 'productos'));
    }
    
    public function update(Request $request, $id)
    {
        // Validar los datos
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|numeric|min:1',
        ]);
    
        // Obtener el producto seleccionado
        $producto = Producto::find($request->producto_id);
    
        // Calcular el total (precio del producto * cantidad)
        $total = $producto->precio * $request->cantidad;
    
        // Actualizar el pedido
        $pedido = Pedido::findOrFail($id);
        $pedido->update([
            'usuario_id' => $request->usuario_id,
            'producto_id' => $request->producto_id,
            'cantidad' => $request->cantidad,
            'total' => $total, // Actualizar el total
        ]);
    
        // Redirigir o mostrar un mensaje de éxito
        return redirect()->route('pedidos.index')->with('success', 'Pedido actualizado exitosamente');
    }    

    public function destroy($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->delete(); // Eliminar el pedido
        return redirect()->route('pedidos.index')->with('success', 'Pedido eliminado correctamente');
    }
}
