<?php
session_start();
require_once __DIR__ . '/inc/protegeix.php';
require_once __DIR__ . '/inc/funcions.php';
$dades = require __DIR__ . '/inc/dades.php';

$usuari = $_SESSION['usuari'];
$consulta = $dades['consulta'];
$oberta = votacioOberta($consulta['tancament']);
$haVotat = jaHaVotat($usuari['email']);
$dataTancament = date('d/m/Y \a \l\e\s H:i', strtotime($consulta['tancament']));

$titol = 'Inici';
require_once __DIR__ . '/inc/capcalera.php';
?>
<h1>Hola, <?= htmlspecialchars($usuari['nom']) ?>!</h1>

<p>Has iniciat sessió <?= tempsDesDe($_SESSION['hora_login']) ?>.</p>

<h2><?= htmlspecialchars($consulta['pregunta']) ?></h2>

<?php if ($oberta): ?>
    <p>La votació és oberta fins al <?= $dataTancament ?>.</p>
<?php else: ?>
    <p>La votació està tancada.</p>
<?php endif; ?>

<?php if ($usuari['rol'] === 'admin'): ?>
    <p><a href="resultats.php">Veure els resultats</a></p>
<?php elseif ($haVotat): ?>
    <p>Ja has votat. <a href="resultats.php">Veure els resultats</a></p>
<?php elseif ($oberta): ?>
    <p><a href="votacio.php">Votar ara</a></p>
<?php else: ?>
    <p><a href="resultats.php">Veure els resultats</a></p>
<?php endif; ?>

<?php require_once __DIR__ . '/inc/peu.php'; ?>
