<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$port = "3307";
$username = "root";
$password = ""; // Cambia esto si tienes contraseña para root en XAMPP
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

// Consulta SQL para verificar las credenciales
$sql = "SELECT * FROM usuarios WHERE usuario = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $usuario, $contraseña);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si hay coincidencias
if ($result->num_rows > 0) {
    header("Location: inicio.php"); // Redirigir al dashboard
} else {
    header("Location: login.php?error=1"); // Redirigir con mensaje de error
}

$stmt->close();
$conn->close();
?>
