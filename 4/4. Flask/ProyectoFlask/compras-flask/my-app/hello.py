from flask import Flask, render_template, request, redirect
from flask_mysqldb import MySQL

app = Flask(__name__)
app.config['MYSQL_HOST'] = 'localhost'
app.config['MYSQL_PORT'] = 3308  # Agregar esta línea
app.config['MYSQL_USER'] = 'root'
app.config['MYSQL_PASSWORD'] = ''  # Si no tienes contraseña, deja vacío
app.config['MYSQL_DB'] = 'comprasg'

mysql = MySQL(app)

@app.route('/')
def hello():
    return 'Hola Mundo'

@app.route('/miruta')
def ruta():
    return 'otra ruta!'

@app.route('/miejemplo')
def ejemplo():
    return render_template('ejemplo.html')

# USUARIOS
@app.route('/listadousuarios')
def listadoU():
    try:
        cursor = mysql.connection.cursor()
        cursor.execute("SELECT * FROM usuario")
        datosU = cursor.fetchall()
        cursor.close()
        return render_template('listadoUsuarios.html', usuarios=datosU)
    except Exception as e:
        return f"Error: {e}"

@app.route('/crear_usuario', methods=['GET', 'POST'])
def crear_usuario():
    if request.method == 'POST':
        nombre = request.form['nombre']
        correo = request.form['correo']
        cursor = mysql.connection.cursor()
        cursor.execute("INSERT INTO usuario (nombre, correo) VALUES (%s, %s)", (nombre, correo))
        mysql.connection.commit()
        return redirect('/listadousuarios')
    return render_template('crearUsuario.html')  # Página con formulario para crear usuario

@app.route('/editar_usuario/<int:id>', methods=['GET', 'POST'])
def editar_usuario(id):
    try:
        # Obtener los datos del usuario por su ID
        cursor = mysql.connection.cursor()
        cursor.execute("SELECT * FROM usuario WHERE id = %s", (id,))
        usuario = cursor.fetchone()
        cursor.close()

        if request.method == 'POST':
            # Obtener los nuevos datos desde el formulario
            nombre = request.form['nombre']
            correo = request.form['correo']
            
            # Actualizar los datos en la base de datos
            cursor = mysql.connection.cursor()
            cursor.execute("UPDATE usuario SET nombre = %s, correo = %s WHERE id = %s", (nombre, correo, id))
            mysql.connection.commit()
            cursor.close()

            return redirect('/listadousuarios')

        return render_template('editarUsuario.html', usuario=usuario)
    
    except Exception as e:
        return f"Error: {e}"

@app.route('/eliminar_usuario/<int:id_usuario>')
def eliminar_usuario(id_usuario):
    cursor = mysql.connection.cursor()
    cursor.execute("DELETE FROM usuario WHERE id = %s", (id_usuario,))
    mysql.connection.commit()
    return redirect('/listadousuarios')

if __name__ == '__main__':
    app.run(debug=True)

# CATEGORIAS
@app.route('/listadocategorias')
def listadoC():
    try:
        cursor = mysql.connection.cursor()
        cursor.execute("SELECT * FROM categoria")
        datosC = cursor.fetchall()
        cursor.close()
        return render_template('listadoCategorias.html', categorias=datosC)
    except Exception as e:
        return f"Error: {e}"
    
@app.route('/crear_categoria', methods=['GET', 'POST'])
def crear_categoria():
    try:
        if request.method == 'POST':
            nombre = request.form['nombre']
            cursor = mysql.connection.cursor()
            # Aquí el 'nombre' es una tupla
            cursor.execute("INSERT INTO categoria (nombre) VALUES (%s)", (nombre,))
            mysql.connection.commit()
            cursor.close()
            return redirect('/listadocategorias')
        return render_template('crearCategoria.html')
    except Exception as e:
        return f"Error en la creación de la categoría: {e}", 500

@app.route('/editar_categoria/<int:id>', methods=['GET', 'POST'])
def editar_categoria(id):
    try:
        # Obtener los datos del usuario por su ID
        cursor = mysql.connection.cursor()
        cursor.execute("SELECT * FROM categoria WHERE id = %s", (id,))
        categoria = cursor.fetchone()
        cursor.close()

        if request.method == 'POST':
            # Obtener los nuevos datos desde el formulario
            nombre = request.form['nombre']
            
            # Actualizar los datos en la base de datos
            cursor = mysql.connection.cursor()
            cursor.execute("UPDATE categoria SET nombre = %s WHERE id = %s", (nombre, id))
            mysql.connection.commit()
            cursor.close()

            return redirect('/listadocategorias')

        return render_template('editarCategoria.html', categoria=categoria)
    
    except Exception as e:
        return f"Error: {e}"

@app.route('/eliminar_categoria/<int:id_categoria>')
def eliminar_categoria(id_categoria):
    cursor = mysql.connection.cursor()
    cursor.execute("DELETE FROM categoria WHERE id = %s", (id_categoria,))
    mysql.connection.commit()
    return redirect('/listadocategorias')

if __name__ == '__main__':
    app.run(debug=True)

# PRODUCTOS  
@app.route('/listadoproductos')
def listadoPr():
    try:
        cursor = mysql.connection.cursor()
        cursor.execute("SELECT p.id, p.nombre, p.precio, c.nombre FROM producto p, categoria c WHERE p.categoria_id=c.id")
        datosPr = cursor.fetchall()
        cursor.close()
        return render_template('listadoProductos.html', productos=datosPr)
    except Exception as e:
        return f"Error: {e}"

@app.route('/crear_producto', methods=['GET', 'POST'])
def crear_producto():
    if request.method == 'POST':
        nombre = request.form['nombre']
        precio = request.form['precio']
        categoria_id = request.form['categoria_id']

        # Insertar producto en la base de datos
        cursor = mysql.connection.cursor()
        cursor.execute("INSERT INTO producto (nombre, precio, categoria_id) VALUES (%s, %s, %s)", (nombre, precio, categoria_id))
        mysql.connection.commit()
        cursor.close()
        return redirect('/listadoproductos')

    # Obtener categorías para el formulario
    cursor = mysql.connection.cursor()
    cursor.execute("SELECT * FROM categoria")
    categorias = cursor.fetchall()
    cursor.close()

    # Depuración
    print(categorias)  # Para verificar los datos

    return render_template('crearProducto.html', categorias=categorias)

@app.route('/editar_producto/<int:id>', methods=['GET', 'POST'])
def editar_producto(id):
    cursor = mysql.connection.cursor()

    # Obtener el producto por ID
    cursor.execute("SELECT * FROM producto WHERE id = %s", (id,))
    producto = cursor.fetchone()

    if request.method == 'POST':
        nombre = request.form['nombre']
        precio = request.form['precio']
        categoria_id = request.form['categoria_id']

        # Actualizar el producto
        cursor.execute("""
            UPDATE producto SET nombre = %s, precio = %s, categoria_id = %s WHERE id = %s
        """, (nombre, precio, categoria_id, id))
        mysql.connection.commit()
        cursor.close()

        return redirect('/listadoproductos')

    # Obtener las categorías
    cursor.execute("SELECT * FROM categoria")
    categorias = cursor.fetchall()
    cursor.close()

    return render_template('editarProducto.html', producto=producto, categorias=categorias)

@app.route('/eliminar_producto/<int:id_producto>')
def eliminar_producto(id_producto):
    cursor = mysql.connection.cursor()
    cursor.execute("DELETE FROM producto WHERE id = %s", (id_producto,))
    mysql.connection.commit()
    return redirect('/listadoproductos')

if __name__ == '__main__':
    app.run(debug=True)

# PEDIDOS
@app.route('/listadopedidos')
def listadoPe():
    try:
        cursor = mysql.connection.cursor()
        cursor.execute("SELECT p.id, u.nombre, pr.nombre, p.cantidad, p.total FROM pedido p, usuario u, producto pr WHERE p.usuario_id=u.id and p.producto_id=pr.id")
        datosP = cursor.fetchall()
        cursor.close()
        return render_template('listadoPedidos.html', pedidos=datosP)
    except Exception as e:
        return f"Error: {e}"

@app.route('/crear_pedido', methods=['GET', 'POST'])
def crear_pedido():
    try:
        if request.method == 'POST':
            usuario_id = request.form['usuario_id']
            producto_id = request.form['producto_id']
            cantidad = int(request.form['cantidad'])

            # Obtener precio del producto
            cursor = mysql.connection.cursor()
            cursor.execute("SELECT precio FROM producto WHERE id = %s", (producto_id,))
            producto = cursor.fetchone()

            if not producto:
                return "Producto no encontrado", 404

            precio = producto[0]
            total = precio * cantidad

            # Insertar el pedido
            cursor.execute("""
                INSERT INTO pedido (usuario_id, producto_id, cantidad, total)
                VALUES (%s, %s, %s, %s)
            """, (usuario_id, producto_id, cantidad, total))
            mysql.connection.commit()
            cursor.close()

            return redirect('listadopedidos')

        # Obtener usuarios y productos
        cursor = mysql.connection.cursor()
        cursor.execute("SELECT id, nombre FROM usuario")  # Corregido
        usuarios = cursor.fetchall()
        cursor.execute("SELECT id, nombre, precio FROM producto")
        productos = cursor.fetchall()
        cursor.close()

        return render_template('crearPedido.html', usuarios=usuarios, productos=productos)

    except Exception as e:
        return f"Error: {e}"

@app.route('/editar_pedido/<int:id>', methods=['GET', 'POST'])
def editar_pedido(id):
    try:
        if request.method == 'POST':
            # Capturar datos enviados desde el formulario
            usuario_id = request.form['usuario_id']
            producto_id = request.form['producto_id']
            cantidad = int(request.form['cantidad'])

            # Obtener el precio del producto para calcular el total
            cursor = mysql.connection.cursor()
            cursor.execute("SELECT precio FROM producto WHERE id = %s", (producto_id,))
            producto = cursor.fetchone()

            if not producto:
                return "Producto no encontrado", 404

            precio = producto[0]
            total = precio * cantidad  # Calcular total con base en el precio y cantidad

            # Actualizar el pedido en la base de datos
            cursor.execute("""
                UPDATE pedido
                SET usuario_id = %s, producto_id = %s, cantidad = %s, total = %s
                WHERE id = %s
            """, (usuario_id, producto_id, cantidad, total, id))
            mysql.connection.commit()
            cursor.close()

            return redirect('/listadopedidos')

        # Cargar datos del pedido actual
        cursor = mysql.connection.cursor()
        cursor.execute("SELECT usuario_id, producto_id, cantidad, total FROM pedido WHERE id = %s", (id,))
        pedido = cursor.fetchone()

        if not pedido:
            return "Pedido no encontrado", 404

        # Cargar lista de usuarios y productos
        cursor.execute("SELECT id, nombre FROM usuario")
        usuarios = cursor.fetchall()
        cursor.execute("SELECT id, nombre, precio FROM producto")
        productos = cursor.fetchall()
        cursor.close()

        # Pasar 'id' al renderizado para evitar errores
        return render_template('editarPedido.html', id=id, pedido=pedido, usuarios=usuarios, productos=productos)

    except Exception as e:
        return f"Error: {e}"

@app.route('/eliminar_pedido/<int:id_pedido>')
def eliminar_pedido(id_pedido):
    cursor = mysql.connection.cursor()
    cursor.execute("DELETE FROM pedido WHERE id = %s", (id_pedido,))
    mysql.connection.commit()
    return redirect('/listadopedidos')

if __name__ == '__main__':
    app.run(debug=True)

#@app.route('/milistado')
#def listado():
#    try:
#        cursor = mysql.connection.cursor()
#        cursor.execute("SELECT * FROM usuario")
#        datos = cursor.fetchall()
#        cursor.close()
#        return render_template('listado.html', usuarios=datos)
#    except Exception as e:
#        return f"Error: {e}"
