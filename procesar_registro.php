<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$port = "3307";  // Especifica el puerto de MySQL
$username = "root";
$password = "";  // Cambia esto si tienes contraseña para root en XAMPP
$dbname = "farmaciaMelindre";

// Crear conexión usando el puerto especificado
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$usuario = $_POST['usuario'];
$contraseña = $_POST['password'];

// Insertar el usuario y la contraseña sin encriptar
$sql = "INSERT INTO usuarios (usuario, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $usuario, $contraseña);

if ($stmt->execute()) {
    // Redirige a registro.php con éxito
    header("Location: registro.php?status=success");
} else {
    // Redirige a registro.php con error
    header("Location: registro.php?status=error");
}

// Cerrar la declaración y la conexión
$stmt->close();
$conn->close();
?>
