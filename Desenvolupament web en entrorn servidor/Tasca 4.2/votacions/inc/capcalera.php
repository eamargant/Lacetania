<?php
$usuari = $_SESSION['usuari'];

$tema = $_COOKIE['tema'] ?? 'clar';
if (!in_array($tema, ['clar', 'fosc'], true)) {
    $tema = 'clar';
}

$missatge = llegeixMissatge();
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($titol) ?> · Votacions</title>
    <style>
        body { font-family: sans-serif; max-width: 700px; margin: 20px auto; padding: 0 10px; }
        body.fosc { background: #222; color: #eee; }
        body.fosc a { color: #8cf; }
        nav a { margin-right: 10px; }
        .missatge { background: #ffd; color: #333; border: 1px solid #cc9; padding: 8px; }
        table { border-collapse: collapse; }
        td, th { border: 1px solid #999; padding: 5px 10px; }
        .barra { background: #48c; height: 15px; }
    </style>
</head>
<body class="<?= $tema ?>">
<nav>
    <strong><?= htmlspecialchars($usuari['nom']) ?></strong> |
    <a href="benvinguda.php">Inici</a>
    <?php if ($usuari['rol'] === 'votant'): ?>
        <a href="votacio.php">Votar</a>
    <?php endif; ?>
    <a href="resultats.php">Resultats</a>
    <?php if ($tema === 'clar'): ?>
        <a href="?tema=fosc">Tema fosc</a>
    <?php else: ?>
        <a href="?tema=clar">Tema clar</a>
    <?php endif; ?>
    <a href="logout.php">Tancar sessió</a>
</nav>
<hr>
<?php if ($missatge !== null): ?>
    <p class="missatge"><?= htmlspecialchars($missatge) ?></p>
<?php endif; ?>
