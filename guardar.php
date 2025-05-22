<?php
// Guarda el contenido enviado desde admin.php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nuevoContenido = $_POST['contenido'];

    // Guardar en contenido.json localmente
    file_put_contents("contenido.json", $nuevoContenido);

    // 🔐 Token de GitHub (PEGA TU TOKEN ENTRE LAS COMILLAS)
    $token = getenv("GITHUB_TOKEN");


    // Datos del repositorio
    $owner = "cens469";
    $repo = "cens469lamatanza";
    $path = "contenido.json";
    $api_url = "https://api.github.com/repos/$owner/$repo/contents/$path";

    // Leer el contenido actual del archivo
    $contenidoCodificado = base64_encode($nuevoContenido);
    $sha = json_decode(file_get_contents($api_url), true)['sha'];

    // Datos para el commit
    $data = [
        "message" => "Actualización desde el panel de administración",
        "content" => $contenidoCodificado,
        "sha" => $sha
    ];

    $headers = [
        "Authorization: token $token",
        "User-Agent: PHP"
    ];

    // Inicializar cURL
    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($status === 200 || $status === 201) {
        echo "Contenido actualizado y subido a GitHub correctamente.";
    } else {
        echo "Error al subir a GitHub. Código HTTP: $status<br>";
        echo "<pre>$response</pre>";
    }
}
?>
