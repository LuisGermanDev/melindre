<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Farmacia Melindre</title>
  <!-- <link rel="stylesheet" href="estilo.css"> -->
  <style>
    body {
    font-family: Arial, sans-serif;
    padding: 0;
    margin: 0;
    box-sizing: border-box;
  }
  header {
    display: flex;
    background-color: #218838;
    color: white;
    padding: 20px;
    text-align: center;
}
  .logo img {
    max-height: 300px;
text-align: center;
max-width: 100%;
height: auto;

  }
  nav a:hover {
    background-color: #618369;
  }
  .content-area {
    padding: 40px;
    text-align: center;

  }
  .content-area h2 {
    margin-bottom: 30px;
   
  }
  .btn {
    display: inline-block;
    background-color: #0fad34;
    color: white;
    text-decoration: none;
    padding: 12px 24px;
    border-radius: 5px;
    margin: 10px;
    transition: background-color 0.3s;
  }
  .btn:hover {
    background-color: #4b6651;
  }
  footer {
    background-color: #277539;
    color: white;
    text-align: center;
    padding: 10px 0;
  }
  .logo{
  background-image: url("./inicio.jpg");
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
height:500px
;

}
svg{
  display: flex;
  justify-content:center;
  align-items: center;
  flex-direction: column;
  width: 50px;
}

img{
  width: 100px;
  
}
h2{
  margin-left: 25%;
}
 

  </style>
</head>
<body>
  <header>
    <img src="078085ba-3f6c-48f8-9d0f-f2e824ab824e.jfif" alt="Farmacia Melindre">
    <h2>BIENVENIDO A FARMACIA MELINDRE</h2>
  </header>

  <div class="btn-group">
    <div class="logo">
      <div class="content-area">
        <a href="productos.php" class="btn"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
</svg>
Productos</a>
        <a href="compras.php" class="btn"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
</svg>
Compras</a>
        <a href="proveedores.php" class="btn"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
</svg>
Proveedores</a>
        <a href="index.php" class="btn"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
</svg>
Cerrar Sesión</a>
      </div>
    
    </div>
    
  </div>

  <footer>
    <p>&copy; 2024 Farmacia Melindre. Todos los derechos reservados.</p>
  </footer>
</body>
</html>
