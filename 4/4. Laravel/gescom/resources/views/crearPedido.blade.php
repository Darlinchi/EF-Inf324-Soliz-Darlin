<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Crear Pedido</h1>
        <form action="{{ route('pedidos.store') }}" method="POST">
            @csrf

            <!-- Campo de usuario -->
            <div class="mb-3">
                <label for="usuario_id" class="form-label">Usuario</label>
                <select class="form-control" id="usuario_id" name="usuario_id" required>
                    <option value="">Selecciona un usuario</option>
                    @foreach ($usuarios as $usuario)
                        <option value="{{ $usuario->id }}">
                            {{ $usuario->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Campo de producto -->
            <div class="mb-3">
                <label for="producto_id" class="form-label">Producto</label>
                <select class="form-control" id="producto_id" name="producto_id" required>
                    <option value="">Selecciona un producto</option>
                    @foreach ($productos as $producto)
                        <option value="{{ $producto->id }}">
                            {{ $producto->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Campo de cantidad -->
            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" required min="1">
            </div>

            <!-- Campo de total (deshabilitado para ser calculado automáticamente) -->
            <div class="mb-3">
                <label for="total" class="form-label">Total</label>
                <input type="number" class="form-control" id="total" name="total" required min="0" step="any" readonly>
            </div>

            <button type="submit" class="btn btn-primary">Crear Pedido</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Obtener los elementos del formulario
        const cantidadInput = document.getElementById('cantidad');
        const totalInput = document.getElementById('total');
        const productoSelect = document.getElementById('producto_id');

        // Escuchar cambios en el campo de cantidad o producto
        cantidadInput.addEventListener('input', calcularTotal);
        productoSelect.addEventListener('change', calcularTotal);

        // Función para calcular el total
        function calcularTotal() {
            const cantidad = parseInt(cantidadInput.value);
            const productoId = productoSelect.value;

            if (cantidad > 0 && productoId) {
                // Obtener el precio del producto
                const producto = obtenerProductoPorId(productoId);
                if (producto) {
                    // Calcular el total
                    const total = producto.precio * cantidad;
                    totalInput.value = total.toFixed(2); // Mostrar el total con 2 decimales
                }
            }
        }

        // Función para obtener los datos del producto por su ID (esto debería ser integrado con tu backend)
        function obtenerProductoPorId(productoId) {
            // Aquí puedes hacer una petición AJAX a tu servidor para obtener el precio del producto
            // o usar los datos del servidor si los pasas como un objeto en la página

            @foreach ($productos as $producto)
                if (productoId == {{ $producto->id }}) {
                    return { precio: {{ $producto->precio }} };
                }
            @endforeach

            return null;
        }
    </script>

</body>
</html>
