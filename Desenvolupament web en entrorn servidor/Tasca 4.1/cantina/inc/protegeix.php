<?php
require_once __DIR__ . '/funcions.php';

const TEMPS_INACTIVITAT = 600; #10 min

#Si no hi ha ususari de sessio, redirigim al login
if (!isset($_SESSION['usuari'])) {
    redirigeix('login.php');
}

$ultimaActivitat = $_SESSION['ultimaActivitat'] ?? time();

#Si han pasat mes de 10 min,<destruim la sessio i anem al login
if (time() - $ultimaActivitat > TEMPS_INACTIVITAT) {
    $_SESSION = [];
    session_destroy();
    redirigeix('login.php?expirada=1');
}

$_SESSION['ultimaActivitat'] = time();
