<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login Administrador</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
      <div class="logo-container">
          <img src="img/logo.jpg" alt="Logo" class="logo">
          <h1>CENS N°469 LA MATANZA</h1>
      </div>
  </header>

  <main>
      <h2>Ingreso de administrador</h2>
      <form action="verificar_login.php" method="POST">
          <label>Email:</label><br>
          <input type="email" name="email" required><br><br>
          <label>Contraseña:</label><br>
          <input type="password" name="password" required><br><br>
          <button type="submit">Ingresar</button>
      </form>
      <?php if (isset($_GET['error'])): ?>
          <p style="color:red;">Datos incorrectos</p>
      <?php endif; ?>
  </main>
</body>
</html>
