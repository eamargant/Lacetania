<?php
const ESCALES = ['Fahrenheit', 'Celsius', 'Kelvin'];

/**
 * Passa una temperatura de qualsevol escala a graus Celsius.
 *
 * @param float  $valor  Temperatura
 * @param string $escala Escala de la temperatura
 * @return float         Temperatura en Celsius
 */
function aCelsius(float $valor, string $escala): float
{
    switch ($escala) {
        case 'Fahrenheit':
            return ($valor - 32) * 5 / 9;
        case 'Kelvin':
            return $valor - 273.15;
        default:
            return $valor;
    }
}

/**
 * Passa una temperatura en graus Celsius a l'escala indicada.
 *
 * @param float  $celsius Temperatura en Celsius
 * @param string $escala  Escala de destinació
 * @return float          Temperatura en l'escala de destinació
 */
function desDeCelsius(float $celsius, string $escala): float
{
    switch ($escala) {
        case 'Fahrenheit':
            return $celsius * 9 / 5 + 32;
        case 'Kelvin':
            return $celsius + 273.15;
        default: // Celsius
            return $celsius;
    }
}

/**
 * Converteix una temperatura d'una escala a una altra.
 * Primer la passa a Celsius i després a l'escala de destinació.
 *
 * @param float  $valor  Temperatura a convertir
 * @param string $origen Escala de la temperatura
 * @param string $desti  Escala a la qual es vol convertir
 * @return float         Temperatura convertida
 */
function convertirTemperatura(float $valor, string $origen, string $desti): float
{
    return desDeCelsius(aCelsius($valor, $origen), $desti);
}

// Recollim per GET
$valor = $_GET['valor'] ?? null;
$origen = $_GET['origen'] ?? '';
$desti = $_GET['desti'] ?? '';

$error = null;
$resultat = null;

// Validem
if (!is_numeric($valor)) {
    $error = 'Cal indicar una temperatura numèrica.';
} elseif (!in_array($origen, ESCALES, true) || !in_array($desti, ESCALES, true)) {
    $error = 'Cal triar una escala vàlida d\'origen i de destinació.';
} else {
    $resultat = convertirTemperatura((float) $valor, $origen, $desti);
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Exercici 3 - Resultat</title>
</head>
<body>
    <h1>Conversió de temperatura</h1>

    <?php if ($error !== null): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php else: ?>
        <p>
            <?= htmlspecialchars($valor) ?> <?= $origen ?> =
            <?= $resultat ?> <?= $desti ?>
        </p>
    <?php endif; ?>

    <p>
        <a href="ex3.php">Tornar al formulari</a> |
        <a href="index.php">Tornar a l'índex</a>
    </p>
</body>
</html>
