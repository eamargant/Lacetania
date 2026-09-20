<?php
require_once 'dades.php';
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Vista en llista</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <p><a href="index.php">Índex</a></p>
        <h1>Llista de llibres</h1>

        <ul class="llista-llibres">
            <?php foreach ($biblioteca as $llibre): ?>
                <li>
                    <strong><?= $llibre['titol'] ?></strong>
                    — <?= $llibre['autor'] ?>
                    (<?= $llibre['any'] ?>), <?= $llibre['genere'] ?>.
                    Llegit: <?= $llibre['llegit'] ? 'Sí' : 'No' ?>.
                    Valoració: <?= $llibre['valoracio'] ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
