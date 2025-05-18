<?php
session_start();
if (!isset($_SESSION['admin'])) {
    die("Acceso no autorizado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        "inicio" => $_POST['inicio'],
        "requisitos" => $_POST['requisitos'],
        "orientaciones" => $_POST['orientaciones'],
        "ubicacion" => $_POST['ubicacion'],
        "equipo" => $_POST['equipo'],
        "preinscripcion" => $_POST['preinscripcion'],
        "facebook" => $_POST['facebook'],
        "instagram" => $_POST['instagram'],
        "whatsapp" => $_POST['whatsapp']
    ];
    file_put_contents('contenido.json', json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    header('Location: admin.php');
}
