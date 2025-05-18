<?php
$data = json_decode(file_get_contents('contenido.json'), true);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>CENS 469</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
      <div class="logo-container">
          <img src="img/logo.jpg" alt="Logo CENS 469" class="logo">
          <h1>CENS N°469 LA MATANZA</h1>
      </div>
  </header>

  <nav>
      <a href="index.php">Inicio</a>
      <a href="login.php">Administrador</a>
  </nav>

  <main>
      <section>
          <h2>Inicio</h2>
          <?= $data['inicio'] ?>
      </section>
      <section>
          <h2>Requisitos</h2>
          <?= $data['requisitos'] ?>
      </section>
      <section>
          <h2>Orientaciones</h2>
          <?= $data['orientaciones'] ?>
      </section>
      <section>
          <h2>Ubicación</h2>
          <?= $data['ubicacion'] ?>
          <br>
          <a href="https://www.google.com/maps/search/?api=1&query=BPE,+Cirilo+Correa+6899-6999,+B1764+Virrey+del+Pino,+Provincia+de+Buenos+Aires" target="_blank">
              <img src="img/ubicacion.png" alt="Ubicación" class="icon">
          </a>
      </section>
      <section>
          <h2>Equipo Directivo</h2>
          <?= $data['equipo'] ?>
      </section>
      <section>
          <h2>Preinscripción</h2>
          <?= $data['preinscripcion'] ?>
      </section>
      <section>
          <h2>Redes Sociales</h2>
          <a href="<?= $data['facebook'] ?>" target="_blank">
              <img src="img/facebook.png" alt="Facebook" class="icon">
          </a>
          <a href="<?= $data['instagram'] ?>" target="_blank">
              <img src="img/instagram.png" alt="Instagram" class="icon">
          </a>
          <a href="https://wa.me/549<?= $data['whatsapp'] ?>" target="_blank">
              <img src="img/whatsapp.png" alt="WhatsApp" class="icon">
          </a>
      </section>
  </main>

  <footer>
      <p>&copy; 2025 CENS 469</p>
  </footer>
</body>
</html>
