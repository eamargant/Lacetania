<?php
/**
 * header.php
 * Capçalera comuna a totes les pàgines: <head>, Bootstrap i barra de navegació.
 */

$titol = $titol ?? 'PHP Exercicis';
$paginaActual = basename($_SERVER['PHP_SELF']);
$menu = [
    'ex1.php' => 'Capitals',
    'ex2.php' => 'Temperatures',
    'ex3.php' => 'Arrays',
    'ex4.php' => 'Acadèmia',
];
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($titol) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">PHP Exercicis</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu"
                aria-controls="menu" aria-expanded="false" aria-label="Obrir menú">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav">
                <?php foreach ($menu as $fitxer => $text): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $fitxer === $paginaActual ? 'active' : '' ?>"
                           href="<?= e($fitxer) ?>"><?= e($text) ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</nav>
<main class="container">
