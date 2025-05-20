
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
    <style>
        .icono-social {
            width: 80px;
            height: auto;
            vertical-align: middle;
            margin: 5px;
            transition: transform 0.2s;
        }

        .icono-social:hover {
            transform: scale(1.1);
        }

        .redes-contenedor {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .ubicacion-logo {
            text-align: center;
            margin-top: 15px;
        }

        .ubicacion-logo img {
            width: 80px;
            height: auto;
        }
    </style>
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
                    echo '<div class="redes-contenedor">';
                    echo '<a href="https://www.facebook.com/profile.php?id=61576758922489" target="_blank"><img src="img/facebook.png" class="icono-social" alt="Facebook"></a>';
                    echo '<a href="https://www.instagram.com/cens_n469_la_matanza/" target="_blank"><img src="img/instagram.png" class="icono-social" alt="Instagram"></a>';
                    echo '<a href="https://wa.me/541125203641" target="_blank"><img src="img/whatsapp.png" class="icono-social" alt="WhatsApp"></a>';
                    echo '</div>';
                } elseif ($clave === 'ubicacion') {
                    echo $contenido[$clave];
                    echo '<div class="ubicacion-logo">';
                    echo '<a href="https://www.google.com/maps/place/BPE,+Cirilo+Correa+6899-6999,+B1764+Virrey+del+Pino,+Provincia+de+Buenos+Aires" target="_blank">';
                    echo '<img src="img/ubicacion.png" alt="Ubicación">';
                    echo '</a>';
                    echo '</div>';
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

