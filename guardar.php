<?php
session_start();

// Verifica que el usuario esté autenticado correctamente
if (!isset($_SESSION['admin'])) {
    die("<p style='color:red; font-weight:bold;'>❌ Acceso no autorizado.</p>");
}

// Solo acepta solicitudes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibe los datos desde el formulario, con verificación
    $datos = [
        "inicio" => $_POST['inicio'] ?? '',
        "requisitos" => $_POST['requisitos'] ?? '',
        "orientaciones" => $_POST['orientaciones'] ?? '',
        "ubicación" => $_POST['ubicación'] ?? '',
        "equipo" => $_POST['equipo'] ?? '',
        "preinscripción" => $_POST['preinscripción'] ?? '',
        "Facebook" => $_POST['Facebook'] ?? '',
        "Instagram" => $_POST['Instagram'] ?? '',
        "WhatsApp" => $_POST['WhatsApp'] ?? ''
    ];

    // Guarda localmente en contenido.json
    $localSave = file_put_contents("contenido.json", json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    if (!$localSave) {
        die("<p style='color:red;'>❌ Error al guardar localmente en contenido.json</p>");
    }

    // 🔐 Token desde variable de entorno
    $token = getenv("GITHUB_TOKEN");
    if (!$token) {
        die("<p style='color:red;'>❌ No se encontró el token GITHUB_TOKEN. Verificalo en Render.</p>");
    }

    // Datos del repo
    $owner = "cens469";
    $repo = "cens469lamatanza";
    $path = "contenido.json";
    $api_url = "https://api.github.com/repos/$owner/$repo/contents/$path";

    // Obtener el SHA actual
    $headers = [
        "Authorization: token $token",
        "User-Agent: PHP"
    ];

    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $sha = null;
    if ($status === 200) {
        $data = json_decode($response, true);
        $sha = $data['sha'];
    }

    // Preparar payload
    $contenidoCodificado = base64_encode(json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    $payload = json_encode([
        "message" => "Actualización desde el panel de administración",
        "content" => $contenidoCodificado,
        "sha" => $sha
    ]);

    // Enviar a GitHub
    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($status === 200 || $status === 201) {
        echo "<p style='color:green; font-weight:bold;'>✅ Cambios guardados y subidos a GitHub correctamente.</p>";
        echo "<p><a href='admin.php'>Volver al panel</a></p>";
    } else {
        echo "<p style='color:red;'>❌ Error al subir a GitHub. Código: $status</p>";
        echo "<pre>$response</pre>";
        echo "<p><a href='admin.php'>Volver al panel</a></p>";
    }
} else {
    echo "<p style='color:red;'>❌ Método no permitido.</p>";
}

