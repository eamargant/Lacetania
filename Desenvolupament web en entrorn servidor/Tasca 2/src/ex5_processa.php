<?php
/**
 * Retorna només els nombres que són múltiples de 3.
 * Fa servir una funció anònima dins d'array_filter.
 *
 * @param array $nombres Array de nombres enters
 * @return array         Nou array amb els múltiples de 3
 */
function multiplesDe3(array $nombres): array
{
    return array_filter($nombres, function ($n) {
        return $n % 3 == 0;
    });
}

// Recollim per POST
$text = trim($_POST['nombres'] ?? '');

$error = null;
$nombres = [];
$multiples = [];

if ($text === '') {
    $error = 'Cal introduir almenys un nombre.';
} else {
    // Separem el text per comes i traiem els espais de cada valor
    $valors = array_map('trim', explode(',', $text));

    // Comprovem que cada valor sigui un nombre enter
    $invalids = [];
    foreach ($valors as $valor) {
        if (filter_var($valor, FILTER_VALIDATE_INT) === false) {
            $invalids[] = $valor === '' ? '(buit)' : $valor;
        } else {
            $nombres[] = (int) $valor;
        }
    }

    if (!empty($invalids)) {
        $error = 'Aquests valors no són nombres enters: ' . implode(', ', $invalids);
    } else {
        $multiples = multiplesDe3($nombres);
    }
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Exercici 5 - Resultat</title>
</head>
<body>
    <h1>Filtrar els múltiples de 3</h1>

    <?php if ($error !== null): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php else: ?>
        <p>Nombres introduïts: <strong><?= implode(', ', $nombres) ?></strong></p>
        <?php if (empty($multiples)): ?>
            <p>Cap dels nombres és múltiple de 3.</p>
        <?php else: ?>
            <p>Múltiples de 3: <strong><?= implode(', ', $multiples) ?></strong></p>
        <?php endif; ?>
    <?php endif; ?>

    <p>
        <a href="ex5.php">Tornar al formulari</a> |
        <a href="index.php">Tornar a l'índex</a>
    </p>
</body>
</html>
