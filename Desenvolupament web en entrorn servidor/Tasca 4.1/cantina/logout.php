<?php
session_start();
require_once __DIR__ . '/inc/funcions.php';

$_SESSION = [];

if (ini_get('session.use_cookies')) {
    $parametres = session_get_cookie_params();
    setcookie(session_name(), '', time() - 3600,
        $parametres['path'], $parametres['domain'],
        $parametres['secure'], $parametres['httponly']); #Esborra la cookie de sessio 
}

session_destroy();

redirigeix('login.php');
