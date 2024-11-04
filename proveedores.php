<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Proveedores</title>
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
        h1 {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input, select, textarea, button {
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
        .actions button {
            width: auto;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Proveedores</h1>
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

        // Insertar o actualizar proveedor
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = $_POST['nombre'];
            $razon_social = $_POST['razonSocial'];
            $ruc = $_POST['ruc'];
            $direccion = $_POST['direccion'];
            $telefono = $_POST['telefono'];
            $email = $_POST['email'];
            $productos = $_POST['productos'];
            $metodo_pago = $_POST['metodoPago'];
            $plazo_entrega = $_POST['plazoEntrega'];
            $descuentos = $_POST['descuentos'];
            $politica_devoluciones = $_POST['politicaDevoluciones'];
            $id = isset($_POST['id']) ? $_POST['id'] : null;

            if ($id) {
                // Actualizar proveedor existente
                $sql = "UPDATE proveedor SET nombre=?, razon_social=?, ruc=?, direccion=?, telefono=?, email=?, productos=?, metodo_pago=?, plazo_entrega=?, descuentos=?, politica_devoluciones=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssssssissi", $nombre, $razon_social, $ruc, $direccion, $telefono, $email, $productos, $metodo_pago, $plazo_entrega, $descuentos, $politica_devoluciones, $id);
            } else {
                // Insertar nuevo proveedor
                $sql = "INSERT INTO proveedor (nombre, razon_social, ruc, direccion, telefono, email, productos, metodo_pago, plazo_entrega, descuentos, politica_devoluciones) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssssssiss", $nombre, $razon_social, $ruc, $direccion, $telefono, $email, $productos, $metodo_pago, $plazo_entrega, $descuentos, $politica_devoluciones);
            }
            $stmt->execute();
            $stmt->close();
        }

        // Eliminar proveedor
        if (isset($_GET['delete_id'])) {
            $delete_id = $_GET['delete_id'];
            $sql = "DELETE FROM proveedor WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $delete_id);
            $stmt->execute();
            $stmt->close();
        }

        // Obtener proveedores para mostrar en la tabla
        $sql = "SELECT id, nombre, razon_social, ruc, telefono, email FROM proveedor";
        $result = $conn->query($sql);
        ?>

        <form action="proveedores.php" method="POST">
            <input type="hidden" name="id" id="proveedorId">
            <label for="nombre">Nombre del Proveedor:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="razonSocial">Razón Social:</label>
            <input type="text" id="razonSocial" name="razonSocial" required>

            <label for="ruc">RUC/NIT:</label>
            <input type="text" id="ruc" name="ruc" required>

            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion">

            <label for="telefono">Teléfono:</label>
            <input type="tel" id="telefono" name="telefono">

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="productos">Productos/Servicios Ofrecidos:</label>
            <textarea id="productos" name="productos" rows="3"></textarea>

            <label for="metodoPago">Método de Pago:</label>
            <select id="metodoPago" name="metodoPago">
                <option value="transferencia">Transferencia Bancaria</option>
                <option value="efectivo">Efectivo</option>
                <option value="tarjeta">Tarjeta de Crédito</option>
            </select>

            <label for="plazoEntrega">Plazo de Entrega (días):</label>
            <input type="number" id="plazoEntrega" name="plazoEntrega">

            <label for="descuentos">Descuentos:</label>
            <input type="text" id="descuentos" name="descuentos">

            <label for="politicaDevoluciones">Política de Devoluciones:</label>
            <textarea id="politicaDevoluciones" name="politicaDevoluciones" rows="2"></textarea>

            <button type="submit">Guardar Proveedor</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Razón Social</th>
                    <th>RUC/NIT</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['nombre']}</td>
                            <td>{$row['razon_social']}</td>
                            <td>{$row['ruc']}</td>
                            <td>{$row['telefono']}</td>
                            <td>{$row['email']}</td>
                            <td class='actions'>
                                <button onclick='editProveedor(".json_encode($row).")'>Editar</button>
                                <a href='proveedores.php?delete_id={$row['id']}' onclick='return confirm(\"¿Estás seguro de eliminar este proveedor?\")'>Eliminar</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No hay proveedores registrados</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script>
        function editProveedor(proveedor) {
            document.getElementById('proveedorId').value = proveedor.id;
            document.getElementById('nombre').value = proveedor.nombre;
            document.getElementById('razonSocial').value = proveedor.razon_social;
            document.getElementById('ruc').value = proveedor.ruc;
            document.getElementById('telefono').value = proveedor.telefono;
            document.getElementById('email').value = proveedor.email;
        }
    </script>
</body>
</html>
