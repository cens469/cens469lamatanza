<?php
session_start();

// Verifica que el usuario esté autenticado correctamente
if (!isset($_SESSION['admin'])) {
    die("Acceso no autorizado.");
}

// Solo acepta solicitudes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibe los datos desde el formulario, con verificación de existencia
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

    // Guardar localmente en contenido.json
    file_put_contents("contenido.json", json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    // 🔐 Token desde variable de entorno de Render
    $token = getenv("GITHUB_TOKEN");

    // Datos del repositorio
    $owner = "cens469";
    $repo = "cens469lamatanza";
    $path = "contenido.json";
    $api_url = "https://api.github.com/repos/$owner/$repo/contents/$path";

    // Leer el contenido actual para obtener el SHA
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

    // Crear el commit con el nuevo contenido
    $contenidoCodificado = base64_encode(json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    $payload = json_encode([
        "message" => "Actualización desde el panel de administración",
        "content" => $contenidoCodificado,
        "sha" => $sha
    ]);

    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($status === 200 || $status === 201) {
        header("Location: admin.php?guardado=ok");
        exit;
    } else {
        echo "Error al guardar en GitHub. Código: $status";
        echo "<pre>$response</pre>";
    }
}
?>


