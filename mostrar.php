<?php
$jsonFile = 'contenido.json';

if (file_exists($jsonFile)) {
    $jsonContent = file_get_contents($jsonFile);
    $data = json_decode($jsonContent, true);

    if ($data === null) {
        echo "Error al decodificar JSON.";
        exit;
    }
} else {
    echo "No se encontró el archivo contenido.json";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Contenido CENS</title>
</head>
<body>
    <h1>Contenido guardado del CENS</h1>

    <h2>Inicio</h2>
    <?= $data['inicio'] ?>

    <h2>Requisitos</h2>
    <?= $data['requisitos'] ?>

    <h2>Orientaciones</h2>
    <?= $data['orientaciones'] ?>

    <h2>Ubicación</h2>
    <?= $data['ubicacion'] ?>

    <h2>Equipo</h2>
    <?= $data['equipo'] ?>

    <h2>Preinscripción</h2>
    <?= $data['preinscripcion'] ?>

    <h2>Redes sociales</h2>
    <ul>
        <li><a href="<?= htmlspecialchars($data['facebook']) ?>" target="_blank">Facebook</a></li>
        <li><a href="<?= htmlspecialchars($data['instagram']) ?>" target="_blank">Instagram</a></li>
        <li>WhatsApp: <?= htmlspecialchars($data['whatsapp']) ?></li>
    </ul>

    <p><a href="formulario.html">Volver al formulario</a></p>
</body>
</html>
