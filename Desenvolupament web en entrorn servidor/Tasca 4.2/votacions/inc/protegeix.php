<?php

const TEMPS_MAXIM = 300;

if (!isset($_SESSION['usuari'])) {
    header('Location: index.php?error=acces');
    exit;
}

$ultimaActivitat = $_SESSION['ultima_activitat'] ?? 0;
if (time() - $ultimaActivitat > TEMPS_MAXIM) {
    $_SESSION = [];
    session_destroy();
    header('Location: index.php?error=caducada');
    exit;
}
$_SESSION['ultima_activitat'] = time();

$temesPermesos = ['clar', 'fosc'];
$temaNou = $_GET['tema'] ?? '';
if (in_array($temaNou, $temesPermesos, true)) {
    setcookie('tema', $temaNou, [
        'expires'  => time() + 30 * 24 * 60 * 60,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    header('Location: ' . basename($_SERVER['PHP_SELF']));
    exit;
}
