<?php
session_start();
require_once __DIR__ . '/inc/protegeix.php';

if ($_SESSION['usuari']['rol'] !== 'admin') {
    redirigeix('cataleg.php');
}
#Mostra el contingut de la sessio si l'usuari es admin si no redirigeix al cataleg
$titol = 'Admin';
require_once __DIR__ . '/inc/capcalera.php';
?>
<h1 class="h3 mb-3">Contingut de la sessió</h1>
<pre class="bg-dark text-light p-3 rounded"><?= e(print_r($_SESSION, true)) ?></pre> 
<?php require_once __DIR__ . '/inc/peu.php'; ?>
