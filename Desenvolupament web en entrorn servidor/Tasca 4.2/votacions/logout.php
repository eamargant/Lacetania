<?php
session_start();

$nom = $_SESSION['usuari']['nom'] ?? '';

$_SESSION = [];
$parametres = session_get_cookie_params();
setcookie(session_name(), '', time() - 3600, $parametres['path'], $parametres['domain'], $parametres['secure'], $parametres['httponly']);
session_destroy();
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Sessió tancada · Votacions</title>
    <style>
        body { font-family: sans-serif; max-width: 700px; margin: 20px auto; padding: 0 10px; }
    </style>
</head>
<body>
<h1>Fins la propera, <?= htmlspecialchars($nom) ?>!</h1>
<p><a href="index.php">Tornar a entrar</a></p>
</body>
</html>
