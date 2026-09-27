<?php
const LONGITUD_MINIMA = 8;

/**
 * Valida una contrasenya sense fer servir expressions regulars.
 * Recorre la contrasenya caràcter a caràcter per saber si té
 * majúscules, números i caràcters especials.
 *
 * @param string $contrasenya Contrasenya a validar
 * @return array              Motius pels quals no és vàlida (buit si és vàlida)
 */
function validarContrasenya(string $contrasenya): array
{
    $motius = [];

    $teMajuscula = false;
    $teNumero = false;
    $teEspecial = false;

    // Revisem cada caràcter i marquem quin tipus de caràcter hem trobat
    for ($i = 0; $i < strlen($contrasenya); $i++) {
        $caracter = $contrasenya[$i];

        if (ctype_upper($caracter)) {
            $teMajuscula = true;
        } elseif (ctype_digit($caracter)) {
            $teNumero = true;
        } elseif (!ctype_alnum($caracter)) {
            // Si no és ni lletra o un  número, ha de ser un scaràcter especial
            $teEspecial = true;
        }
    }

    if (strlen($contrasenya) < LONGITUD_MINIMA) {
        $motius[] = 'Ha de tenir almenys ' . LONGITUD_MINIMA . ' caràcters de longitud.';
    }
    if (!$teMajuscula) {
        $motius[] = 'Ha de contenir almenys una lletra majúscula.';
    }
    if (!$teNumero) {
        $motius[] = 'Ha de contenir almenys un número.';
    }
    if (!$teEspecial) {
        $motius[] = 'Ha de contenir almenys un caràcter especial (com ara @, #, $, etc.).';
    }

    return $motius;
}

// Recollim viaPOST
$contrasenya = $_POST['contrasenya'] ?? '';

$error = null;
$motius = [];

if ($contrasenya === '') {
    $error = 'Cal introduir una contrasenya.';
} else {
    $motius = validarContrasenya($contrasenya);
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Exercici 4 - Resultat</title>
</head>
<body>
    <h1>Validador de contrasenyes</h1>

    <?php if ($error !== null): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php elseif (empty($motius)): ?>
        <p style="color: green;">La contrasenya és vàlida.</p>
    <?php else: ?>
        <p style="color: red;">La contrasenya no és vàlida pels motius següents:</p>
        <ul>
            <?php foreach ($motius as $motiu): ?>
                <li><?= htmlspecialchars($motiu) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <p>
        <a href="ex4.php">Tornar al formulari</a> |
        <a href="index.php">Tornar a l'índex</a>
    </p>
</body>
</html>
