<?php
session_start();
$contenido = json_decode(file_get_contents("contenido.json"), true);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CENS N° 469</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <img src="img/logo.jpg" alt="Logo CENS" class="logo">
        <div class="inicio">
            <?php echo $contenido['inicio']; ?>
        </div>

        <div class="accordion-container">
            <?php
            $secciones = [
                'requisitos' => 'Requisitos',
                'orientaciones' => 'Orientaciones',
                'ubicacion' => 'Ubicación',
                'equipo' => 'Equipo Directivo',
                'preinscripcion' => 'Preinscripción',
                'redes' => 'Redes Sociales'
            ];

            foreach ($secciones as $clave => $titulo) {
                echo '<div class="accordion">';
                echo "<button class='accordion-toggle'>{$titulo}</button>";
                echo "<div class='accordion-content'>";

                if ($clave === 'redes') {
                    echo '<p>';
                    echo '<a href="' . $contenido['facebook'] . '" target="_blank"><img src="img/facebook.png" class="icono"> Facebook</a><br>';
                    echo '<a href="' . $contenido['instagram'] . '" target="_blank"><img src="img/instagram.png" class="icono"> Instagram</a><br>';
                    echo '<a href="https://wa.me/54' . $contenido['whatsapp'] . '" target="_blank"><img src="img/whatsapp.png" class="icono"> WhatsApp</a>';
                    echo '</p>';
                } else {
                    echo $contenido[$clave];
                }

                echo '</div></div>';
            }
            ?>
        </div>

        <div class="admin-link">
            <a href="login.php">🛠 Ingreso administrativo</a>
        </div>
    </div>

    <script>
        document.querySelectorAll('.accordion-toggle').forEach(button => {
            button.addEventListener('click', () => {
                const content = button.nextElementSibling;
                button.classList.toggle('active');
                content.style.display = content.style.display === 'block' ? 'none' : 'block';
            });
        });
    </script>
</body>
</html>

