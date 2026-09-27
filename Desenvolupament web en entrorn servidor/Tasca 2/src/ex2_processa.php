<?php
// Carreguem l'array de mesos i la funció diesDelMes()
require_once 'mesos.php';

// Recollim el mes que arriba per GET
$mes = trim($_GET['mes'] ?? '');

// Busquem els dies; si el mes no existeix, la funció retorna null
$dies = $mes !== '' ? diesDelMes($mesos, $mes) : null;
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Exercici 2 - Resultat</title>
</head>
<body>
    <h1>Quants dies té un mes?</h1>

    <?php if ($dies === null): ?>
        <p style="color: red;">El mes "<?= htmlspecialchars($mes) ?>" no és vàlid.</p>
    <?php else: ?>
        <p>El mes <strong><?= htmlspecialchars($mes) ?></strong> té <strong><?= $dies ?></strong> dies.</p>
    <?php endif; ?>

    <p>
        <a href="ex2.php">Tornar al formulari</a> |
        <a href="index.php">Tornar a l'índex</a>
    </p>
</body>
</html>
