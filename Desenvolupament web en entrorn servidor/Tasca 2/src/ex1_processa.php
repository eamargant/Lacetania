<?php
/**
 * Calcula l'àrea d'un rectangle.
 *
 * @param float $base   Mida de la base
 * @param float $altura Mida de l'altura
 * @return float        Àrea (base * altura)
 */
function areaRectangle(float $base, float $altura): float
{
    return $base * $altura;
}

// Recollim els costats que arriben per GET
$base = $_GET['base'] ?? null;
$altura = $_GET['altura'] ?? null;

$error = null;
$area = null;

// Validem que existeixin, que siguin números i que no siguin negatius
if (!is_numeric($base) || !is_numeric($altura)) {
    $error = 'Cal indicar una base i una altura numèriques.';
} elseif ($base < 0 || $altura < 0) {
    $error = 'Els costats no poden ser negatius.';
} else {
    $area = areaRectangle((float) $base, (float) $altura);
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Exercici 1 - Resultat</title>
</head>
<body>
    <h1>Àrea d'un rectangle</h1>

    <?php if ($error !== null): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php else: ?>
        <p>
            Un rectangle de base <strong><?= htmlspecialchars($base) ?></strong>
            i altura <strong><?= htmlspecialchars($altura) ?></strong>
            té una àrea de <strong><?= $area ?></strong>.
        </p>
    <?php endif; ?>

    <p>
        <a href="ex1.php">Tornar al formulari</a> |
        <a href="index.php">Tornar a l'índex</a>
    </p>
</body>
</html>
