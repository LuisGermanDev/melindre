<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INICIAR SESIÓN</title>
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
        .login-container {
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
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h1>Iniciar Sesión</h1>
    <form action="procesar_login.php" method="POST">
        <input type="text" name="usuario" placeholder="Usuario" required />
        <input type="password" name="password" placeholder="Contraseña" required />
        <button type="submit">Iniciar</button>
        <?php
        if (isset($_GET['error'])) {
            echo '<div class="error">Usuario o contraseña incorrectos.</div>';
        }
        ?>
        <a href="registro.php">registrar</a>
    </form>
</div>

</body>
</html>
