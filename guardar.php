<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$data = json_decode(file_get_contents('contenido.json'), true);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrador - CENS 469</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="img/logo.jpg" alt="Logo" class="logo">
            <h1>CENS N°469 LA MATANZA</h1>
        </div>
        <div style="text-align: right; margin: 10px 20px;">
            <a href="logout.php">Cerrar sesión</a>
        </div>
    </header>

    <main>
        <h2>Editar contenidos</h2>

        <?php if (isset($_GET['guardado']) && $_GET['guardado'] === 'ok'): ?>
            <p style="color: green; font-weight: bold;">✅ Cambios guardados correctamente.</p>
        <?php endif; ?>

        <form method="POST" action="guardar.php">
            <?php foreach ($data as $clave => $valor): ?>
                <label for="<?= $clave ?>"><?= ucfirst($clave) ?>:</label><br>
                <?php if (in_array($clave, ['Facebook', 'Instagram', 'WhatsApp'])): ?>
                    <input type="text" name="<?= $clave ?>" value="<?= htmlspecialchars($valor) ?>" size="60"><br><br>
                <?php else: ?>
                    <textarea name="<?= $clave ?>" id="<?= $clave ?>" rows="6"><?= htmlspecialchars($valor) ?></textarea><br><br>
                    <script>
                        CKEDITOR.replace('<?= $clave ?>');
                    </script>
                <?php endif; ?>
            <?php endforeach; ?>
            <button type="submit">Guardar cambios</button>
        </form>
    </main>
</body>
</html>

