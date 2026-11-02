<?php
session_start();
require_once __DIR__ . '/inc/funcions.php';
$dades = require __DIR__ . '/inc/dades.php';

if (isset($_SESSION['usuari'])) {
    header('Location: benvinguda.php');
    exit;
}

$trentaDies = time() + 30 * 24 * 60 * 60;
$opcionsCookie = [
    'expires'  => $trentaDies,
    'httponly' => true,
    'samesite' => 'Lax',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $contrasenya = $_POST['contrasenya'] ?? '';
    $recorda = isset($_POST['recorda']);

    $usuari = buscaUsuari($dades['usuaris'], $email);

    if ($usuari === null || !password_verify($contrasenya, $usuari['contrasenya'])) {
        header('Location: index.php?error=credencials');
        exit;
    }

    if ($recorda) {
        setcookie('email_recordat', $email, $opcionsCookie);
    } else {
        setcookie('email_recordat', '', ['expires' => time() - 3600, 'httponly' => true, 'samesite' => 'Lax']);
    }

    session_regenerate_id(true);
    unset($usuari['contrasenya']);
    $_SESSION['usuari'] = $usuari;
    $_SESSION['hora_login'] = time();
    $_SESSION['ultima_activitat'] = time();

    header('Location: benvinguda.php');
    exit;
}

$darreraVisita = $_COOKIE['darrera_visita'] ?? '';
if (ctype_digit($darreraVisita) && (int)$darreraVisita > 0 && (int)$darreraVisita <= time()) {
    $textVisita = 'La teva darrera visita va ser ' . tempsDesDe((int)$darreraVisita) . '.';
} else {
    $textVisita = 'Benvingut! És la teva primera visita.';
}
setcookie('darrera_visita', (string)time(), $opcionsCookie);

$emailRecordat = '';
if (filter_var($_COOKIE['email_recordat'] ?? '', FILTER_VALIDATE_EMAIL)) {
    $emailRecordat = $_COOKIE['email_recordat'];
}

$errors = [
    'credencials' => 'Credencials no vàlides.',
    'acces'       => "Primer has d'iniciar sessió.",
    'caducada'    => 'La sessió ha caducat per inactivitat.',
];
$error = $_GET['error'] ?? '';
$textError = $errors[$error] ?? null;
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Login · Votacions</title>
    <style>
        body { font-family: sans-serif; max-width: 700px; margin: 20px auto; padding: 0 10px; }
        .error { color: #b00; }
    </style>
</head>
<body>
<h1>Votacions de l'institut</h1>

<p><?= htmlspecialchars($textVisita) ?></p>

<?php if ($textError !== null): ?>
    <p class="error"><?= htmlspecialchars($textError) ?></p>
<?php endif; ?>

<form method="post" action="index.php">
    <p>
        <label>Email<br>
            <input type="email" name="email" value="<?= htmlspecialchars($emailRecordat) ?>" required>
        </label>
    </p>
    <p>
        <label>Contrasenya<br>
            <input type="password" name="contrasenya" required>
        </label>
    </p>
    <p>
        <label>
            <input type="checkbox" name="recorda" <?= $emailRecordat !== '' ? 'checked' : '' ?>>
            Recorda el meu email
        </label>
    </p>
    <button type="submit">Entrar</button>
</form>
</body>
</html>
