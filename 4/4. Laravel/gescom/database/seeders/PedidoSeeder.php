<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PedidoSeeder extends Seeder
{
    public function run()
    {
        // Llenar datos en la tabla usuarios
        DB::table('usuarios')->insert([
            ['nombre' => 'Juan Pérez', 'correo' => 'juan@gmail.com'],
            ['nombre' => 'Ana Gómez', 'correo' => 'ana@gmail.com'],
            ['nombre' => 'Carlos López', 'correo' => 'carlos@gmail.com'],
            ['nombre' => 'María Torres', 'correo' => 'maria@gmail.com'],
            ['nombre' => 'Luis Sánchez', 'correo' => 'luis@gmail.com'],
            ['nombre' => 'Laura Méndez', 'correo' => 'laura@gmail.com'],
            ['nombre' => 'José Morales', 'correo' => 'jose@gmail.com'],
            ['nombre' => 'Andrea Vargas', 'correo' => 'andrea@gmail.com'],
            ['nombre' => 'Pablo Fernández', 'correo' => 'pablo@gmail.com'],
            ['nombre' => 'Sofía Castillo', 'correo' => 'sofia@gmail.com'],
        ]);

        // Llenar datos en la tabla categorias_producto
        DB::table('categorias')->insert([
            ['nombre' => 'Electrónica'],
            ['nombre' => 'Hogar'],
            ['nombre' => 'Deportes'],
            ['nombre' => 'Moda'],
            ['nombre' => 'Automotriz'],
            ['nombre' => 'Juguetes'],
            ['nombre' => 'Libros'],
            ['nombre' => 'Música'],
            ['nombre' => 'Computación'],
            ['nombre' => 'Accesorios'],
        ]);

        // Llenar datos en la tabla productos
        DB::table('productos')->insert([
            ['nombre' => 'Televisor', 'precio' => 500.00, 'categoria_id' => 1],
            ['nombre' => 'Refrigerador', 'precio' => 700.00, 'categoria_id' => 2],
            ['nombre' => 'Camiseta Deportiva', 'precio' => 20.00, 'categoria_id' => 3],
            ['nombre' => 'Zapatos', 'precio' => 50.00, 'categoria_id' => 4],
            ['nombre' => 'Aceite para Motor', 'precio' => 30.00, 'categoria_id' => 5],
            ['nombre' => 'Rompecabezas', 'precio' => 15.00, 'categoria_id' => 6],
            ['nombre' => 'Novela', 'precio' => 10.00, 'categoria_id' => 7],
            ['nombre' => 'Auriculares', 'precio' => 25.00, 'categoria_id' => 8],
            ['nombre' => 'Laptop', 'precio' => 800.00, 'categoria_id' => 9],
            ['nombre' => 'Reloj', 'precio' => 100.00, 'categoria_id' => 10],
        ]);

        // Llenar datos en la tabla pedidos
        DB::table('pedidos')->insert([
            ['usuario_id' => 1, 'producto_id' => 1, 'cantidad' => 2, 'total' => 1000.00],
            ['usuario_id' => 2, 'producto_id' => 2, 'cantidad' => 1, 'total' => 700.00],
            ['usuario_id' => 3, 'producto_id' => 3, 'cantidad' => 5, 'total' => 100.00],
            ['usuario_id' => 4, 'producto_id' => 4, 'cantidad' => 3, 'total' => 150.00],
            ['usuario_id' => 5, 'producto_id' => 5, 'cantidad' => 4, 'total' => 120.00],
            ['usuario_id' => 6, 'producto_id' => 6, 'cantidad' => 6, 'total' => 90.00],
            ['usuario_id' => 7, 'producto_id' => 7, 'cantidad' => 2, 'total' => 20.00],
            ['usuario_id' => 8, 'producto_id' => 8, 'cantidad' => 3, 'total' => 75.00],
            ['usuario_id' => 9, 'producto_id' => 9, 'cantidad' => 1, 'total' => 800.00],
            ['usuario_id' => 10, 'producto_id' => 10, 'cantidad' => 1, 'total' => 100.00],
        ]);
    }
}
