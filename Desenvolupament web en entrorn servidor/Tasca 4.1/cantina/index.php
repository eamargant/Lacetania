<?php
session_start();
require_once __DIR__ . '/inc/funcions.php';

if (isset($_SESSION['usuari'])) {
    redirigeix('cataleg.php');
}

redirigeix('login.php');

//Si hi ha una sessio activa, redirigim al cataleg,<si no al login.