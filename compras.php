<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Compras</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #218838;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input, select, button {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #0e521e;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #424643;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #218838;
            color: white;
        }
    </style>
</head>
<body>
    <header>
        <h1>Compras</h1>
        <a href="inicio.php">Volver al inicio</a>
    </header>

    <div class="container">
        <?php
        // Conexión a la base de datos
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "farmaciaMelindre";
        $port = 3307;

        $conn = new mysqli($servername, $username, $password, $dbname, $port);
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Obtener productos y proveedores para los select
        $productos = $conn->query("SELECT id, nombre FROM producto");
        $proveedores = $conn->query("SELECT id, nombre FROM proveedor");

        // Insertar o actualizar compra
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $producto_id = $_POST['producto'];
            $proveedor_id = $_POST['proveedor'];
            $cantidad = $_POST['cantidad'];
            $precio_unitario = $_POST['precio_unitario'];
            $id = isset($_POST['id']) ? $_POST['id'] : null;

            if ($id) {
                // Actualizar compra existente
                $sql = "UPDATE compra SET producto_id=?, proveedor_id=?, cantidad=?, precio_unitario=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iiidi", $producto_id, $proveedor_id, $cantidad, $precio_unitario, $id);
            } else {
                // Insertar nueva compra
                $sql = "INSERT INTO compra (producto_id, proveedor_id, cantidad, precio_unitario) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iiid", $producto_id, $proveedor_id, $cantidad, $precio_unitario);
            }
            $stmt->execute();
            $stmt->close();
        }

        // Eliminar compra
        if (isset($_GET['delete_id'])) {
            $delete_id = $_GET['delete_id'];
            $sql = "DELETE FROM compra WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $delete_id);
            $stmt->execute();
            $stmt->close();
        }

        // Obtener compras para mostrar en la tabla
        $sql = "SELECT compra.id, producto.nombre AS producto, proveedor.nombre AS proveedor, compra.cantidad, compra.precio_unitario, compra.total, compra.fecha_compra
                FROM compra
                JOIN producto ON compra.producto_id = producto.id
                JOIN proveedor ON compra.proveedor_id = proveedor.id";
        $result = $conn->query($sql);
        ?>

        <form action="compras.php" method="POST">
            <input type="hidden" name="id" id="compraId">

            <label for="producto">Producto:</label>
            <select name="producto" id="producto" required>
                <option value="">Selecciona un producto</option>
                <?php while ($producto = $productos->fetch_assoc()) { ?>
                    <option value="<?php echo $producto['id']; ?>"><?php echo $producto['nombre']; ?></option>
                <?php } ?>
            </select>

            <label for="proveedor">Proveedor:</label>
            <select name="proveedor" id="proveedor" required>
                <option value="">Selecciona un proveedor</option>
                <?php while ($proveedor = $proveedores->fetch_assoc()) { ?>
                    <option value="<?php echo $proveedor['id']; ?>"><?php echo $proveedor['nombre']; ?></option>
                <?php } ?>
            </select>

            <label for="cantidad">Cantidad:</label>
            <input type="number" name="cantidad" id="cantidad" required>

            <label for="precio_unitario">Precio Unitario:</label>
            <input type="number" name="precio_unitario" id="precio_unitario" step="0.01" required>

            <button type="submit">Registrar Compra</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Proveedor</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                    <th>Fecha de Compra</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['producto']}</td>
                            <td>{$row['proveedor']}</td>
                            <td>{$row['cantidad']}</td>
                            <td>{$row['precio_unitario']}</td>
                            <td>{$row['total']}</td>
                            <td>{$row['fecha_compra']}</td>
                            <td>
                                <button onclick='editCompra(".json_encode($row).")'>Editar</button>
                                <a href='compra.php?delete_id={$row['id']}' onclick='return confirm(\"¿Estás seguro de eliminar esta compra?\")'>Eliminar</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No hay compras registradas</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script>
        function editCompra(compra) {
            document.getElementById('compraId').value = compra.id;
            document.getElementById('producto').value = compra.producto;
            document.getElementById('proveedor').value = compra.proveedor;
            document.getElementById('cantidad').value = compra.cantidad;
            document.getElementById('precio_unitario').value = compra.precio_unitario;
        }
    </script>
</body>
</html>
