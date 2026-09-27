<?php
// Busca totes les carpetes que tinguin src/index.php i en mostra l'enllaç.
// Així no cal actualitzar aquest fitxer cada cop que es crea una tasca nova.
$tasques = glob('*/src/index.php');
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Tasques M613</title>
</head>
<body>
    <h1>Tasques M613</h1>

    <?php if (empty($tasques)): ?>
        <p>No s'ha trobat cap tasca.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($tasques as $index): ?>
                <?php $carpeta = dirname($index, 2); // p. ex. "Tasca 2" ?>
                <li><a href="<?= rawurlencode($carpeta) ?>/src/"><?= htmlspecialchars($carpeta) ?></a></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
