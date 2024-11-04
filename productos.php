<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <link rel="stylesheet" href="estilo2.css">
</head>
<body>
<header>
    <h1>Gestión de Productos</h1>
    <a href="inicio.php">Volver al inicio</a>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</header>

<div class="container">
    <?php
    // Configuración de la conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "farmaciaMelindre";
    $port = 3307;

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Insertar o actualizar producto
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST['nombre'];
        $codigo_barra = $_POST['codigo_barra'];
        $cantidad = $_POST['cantidad'];
        $descripcion = $_POST['descripcion'];
        $id = isset($_POST['id']) ? $_POST['id'] : null;

        if ($id) {
            // Actualizar producto existente
            $sql = "UPDATE producto SET nombre=?, codigo_barra=?, cantidad=?, descripcion=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssisi", $nombre, $codigo_barra, $cantidad, $descripcion, $id);
        } else {
            // Insertar nuevo producto
            $sql = "INSERT INTO producto (nombre, codigo_barra, cantidad, descripcion) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssis", $nombre, $codigo_barra, $cantidad, $descripcion);
        }
        $stmt->execute();
        $stmt->close();
    }

    // Eliminar producto
    if (isset($_GET['delete_id'])) {
        $delete_id = $_GET['delete_id'];
        $sql = "DELETE FROM producto WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
        $stmt->close();
    }

    // Obtener productos para mostrar en la tabla
    $sql = "SELECT id, nombre, codigo_barra, cantidad, descripcion FROM producto";
    $result = $conn->query($sql);
    ?>

    <form action="productos.php" method="POST">
        <input type="hidden" name="id" id="productId">
        <input type="text" name="nombre" id="productName" placeholder="Nombre del producto" required>
        <input type="text" name="codigo_barra" id="productBarcode" placeholder="Código de barra" required>
        <input type="number" name="cantidad" id="productQuantity" placeholder="Cantidad" required>
        <textarea name="descripcion" id="productDescription" placeholder="Descripción del producto" rows="3"></textarea>
        <button type="submit">Guardar Producto</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Código de Barra</th>
                <th>Cantidad</th>
                <th>Descripción</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['nombre']}</td>
                        <td>{$row['codigo_barra']}</td>
                        <td>{$row['cantidad']}</td>
                        <td>{$row['descripcion']}</td>
                        <td>
                            <button onclick='editProduct(".json_encode($row).")'>Editar</button>
                            <a href='productos.php?delete_id={$row['id']}' onclick='return confirm(\"¿Estás seguro de eliminar este producto?\")'>Eliminar</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No hay productos registrados</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

<script>
    function editProduct(product) {
        document.getElementById('productId').value = product.id;
        document.getElementById('productName').value = product.nombre;
        document.getElementById('productBarcode').value = product.codigo_barra;
        document.getElementById('productQuantity').value = product.cantidad;
        document.getElementById('productDescription').value = product.descripcion;
    }
</script>
</body>
</html>
