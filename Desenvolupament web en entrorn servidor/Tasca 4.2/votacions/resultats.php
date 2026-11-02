<?php
session_start();
require_once __DIR__ . '/inc/protegeix.php';
require_once __DIR__ . '/inc/funcions.php';
$dades = require __DIR__ . '/inc/dades.php';

$usuari = $_SESSION['usuari'];
$consulta = $dades['consulta'];

$esAdmin = $usuari['rol'] === 'admin';
$haVotat = jaHaVotat($usuari['email']);
$tancada = !votacioOberta($consulta['tancament']);

if (!$esAdmin && !$haVotat && !$tancada) {
    afegeixMissatge('Podràs veure els resultats quan hagis votat.');
    header('Location: votacio.php');
    exit;
}

$vots = llegeixVots();
$resultats = recompte($vots, $consulta['opcions']);
$total = count($vots);

$totalVotants = 0;
foreach ($dades['usuaris'] as $u) {
    if ($u['rol'] === 'votant') {
        $totalVotants++;
    }
}

$titol = 'Resultats';
require_once __DIR__ . '/inc/capcalera.php';
?>
<h1>Resultats</h1>

<p><strong><?= htmlspecialchars($consulta['pregunta']) ?></strong></p>

<table>
    <tr>
        <th>Opció</th>
        <th>Vots</th>
        <th>Percentatge</th>
        <th></th>
    </tr>
    <?php foreach ($resultats as $clau => $nombre): ?>
        <?php $percentatge = $total > 0 ? round($nombre * 100 / $total) : 0; ?>
        <tr>
            <td><?= htmlspecialchars($consulta['opcions'][$clau]) ?></td>
            <td><?= $nombre ?></td>
            <td><?= $percentatge ?>%</td>
            <td style="width: 200px;">
                <div class="barra" style="width: <?= $percentatge ?>%;"></div>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<p>Participació: <?= $total ?> de <?= $totalVotants ?> votants</p>

<?php require_once __DIR__ . '/inc/peu.php'; ?>
