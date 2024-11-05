<?php
// Conexión a la base de datos
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "farmaciaMelindre";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta SQL para calcular el stock restante de cada producto
$sql = "
    SELECT p.nombre AS producto, 
           p.cantidad - COALESCE(SUM(c.cantidad), 0) AS stock_restante
    FROM producto p
    LEFT JOIN compra c ON p.id = c.producto_id
    GROUP BY p.id, p.nombre
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock de Productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <h1>Stock de Productos</h1>
    
    <?php
    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>Producto</th>
                    <th>Stock Restante</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['producto']) . "</td>
                    <td>" . htmlspecialchars($row['stock_restante']) . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No se encontraron productos.</p>";
    }

    $conn->close();
    ?>
</body>
</html>
