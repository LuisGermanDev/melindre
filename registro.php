<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTRARSE</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #277539;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .register-container {
            background: #fff;
            padding: 80px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
        }
        .success {
            color: green;
            text-align: center;
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="register-container">
    <h1>Registrarse</h1>
    <form action="procesar_registro.php" method="POST">
        <label for="usaurio">Usuario</label>
        <input type="text" name="usuario" placeholder="Usuario" required />
        <label for="password">Contraseña</label>
        <input type="password" name="password" placeholder="Contraseña" required />
        <button type="submit">Registrarse</button>
        <?php
        if (isset($_GET['status'])) {
            if ($_GET['status'] === 'success') {
                echo '<div class="success">Registro exitoso. Puedes <a href="login.php">iniciar sesión</a>.</div>';
            } else if ($_GET['status'] === 'error') {
                echo '<div class="error">Error al registrar. Inténtalo de nuevo.</div>';
            }
        }
        ?>
    </form>
</div>

</body>
</html>
