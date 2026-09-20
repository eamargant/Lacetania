<?php
require_once 'dades.php';

const NOM_BIBLIOTECA = 'La Biblioteca nocturna';

$llegits = 0;
$noLlegits = 0;
$sumaValoracions = 0;

foreach ($biblioteca as $llibre) {
    if ($llibre['llegit']) {
        $llegits++;
        $sumaValoracions += $llibre['valoracio'];
    } else {
        $noLlegits++;
    }
}

$mitjana = $llegits > 0 ? round($sumaValoracions / $llegits, 1) : 0;
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title><?= NOM_BIBLIOTECA ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1><?= NOM_BIBLIOTECA ?></h1>

        <p class="stats">
            Llibres llegits: <strong><?= $llegits ?></strong> |
            No llegits: <strong><?= $noLlegits ?></strong> |
            Valoració mitjana: <strong><?= $mitjana ?></strong>
        </p>

        <nav class="menu">
            <a href="llista.php">Vista en llista</a>
            <a href="taula.php">Vista en taula</a>
            <a href="debug.php">Depuració (var_dump)</a>
        </nav>
    </div>
</body>
</html>
