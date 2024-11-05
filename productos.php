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

// Mensaje de advertencia
$warningMessage = "";

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
    
    // Verificar si el producto tiene compras asociadas
    $check_sql = "SELECT COUNT(*) as count FROM compra WHERE producto_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $delete_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $row = $check_result->fetch_assoc();
    
    if ($row['count'] > 0) {
        // Si existen compras asociadas, mostrar advertencia
        $warningMessage = "No se puede eliminar el producto porque tiene compras asociadas.";
    } else {
        // Si no hay compras asociadas, eliminar el producto
        $sql = "DELETE FROM producto WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
        $stmt->close();
    }
    $check_stmt->close();
}

// Obtener productos para mostrar en la tabla
$sql = "SELECT id, nombre, codigo_barra, cantidad, descripcion FROM producto";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
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
        label, input, select, textarea, button {
            display: block;
            width: 100%;
            margin-top: 5px;
            margin-bottom: 15px;
            padding: 8px;
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
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #218838;
            color: white;
            padding: 20px 7px;
            text-align: center;
        }
        .warning {
            color: red;
            font-weight: bold;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<header>
    <h1>Gestión de Productos</h1>
</header>

<div class="container">
    <?php if ($warningMessage): ?>
        <p class="warning"><?= $warningMessage ?></p>
    <?php endif; ?>

    <a href="inicio.php"><button class="volver">Volver al inicio</button></a>

    <form action="productos.php" method="POST">
        <input type="hidden" name="id" id="productId">
        <label>Nombre del producto</label>
        <input type="text" name="nombre" id="productName" placeholder="Nombre del producto" required>
        <label>Código del producto</label>
        <input type="text" name="codigo_barra" id="productBarcode" placeholder="Código de barra" required>
        <label>Cantidad del producto</label>
        <input type="number" name="cantidad" id="productQuantity" placeholder="Cantidad" required>
        <label>Descripción</label>
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
