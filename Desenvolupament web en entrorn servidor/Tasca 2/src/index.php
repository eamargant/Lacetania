<?php
// Índex de la Tasca 02: enllaç a cada exercici
$exercicis = [
    'ex1.php' => 'Exercici 1 - Àrea d\'un rectangle',
    'ex2.php' => 'Exercici 2 - Dies d\'un mes',
];
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Tasca 02 - Funcions en PHP</title>
</head>
<body>
    <h1>Tasca 02 - Funcions en PHP</h1>

    <ul>
        <?php foreach ($exercicis as $fitxer => $titol): ?>
            <li><a href="<?= $fitxer ?>"><?= $titol ?></a></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
