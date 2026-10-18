<?php
require_once __DIR__ . '/funcions.php';

header('Cache-Control: no-store, no-cache, must-revalidate'); #control de cache un cop s'ha fet el logout

$titol = $titol ?? 'Cantina';
$usuariActual = $_SESSION['usuari'] ?? null;
$unitats = unitatsCistell($_SESSION['cistell'] ?? []);
$missatge = llegeixMissatge();
$paginaActual = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($titol) ?> · Cantina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">☕ Cantina</a>
        <?php if ($usuariActual !== null): ?> 
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu"
                    aria-controls="menu" aria-expanded="false" aria-label="Obrir menú">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= $paginaActual === 'cataleg.php' ? 'active' : '' ?>" href="cataleg.php">Catàleg</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $paginaActual === 'cistell.php' ? 'active' : '' ?>" href="cistell.php">
                            Cistell <span class="badge bg-warning text-dark"><?= $unitats ?></span>
                        </a>
                    </li>
                    <?php if ($usuariActual['rol'] === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $paginaActual === 'admin.php' ? 'active' : '' ?>" href="admin.php">Admin</a>
                        </li>
                    <?php endif; ?>
                </ul>
                <span class="navbar-text me-3"><?= e($usuariActual['nom']) ?></span>
                <a class="btn btn-outline-light btn-sm" href="logout.php">Tancar sessió</a>
            </div>
        <?php endif; ?>
    </div>
</nav>
<main class="container">
<?php if ($missatge !== null): ?>
    <div class="alert alert-success"><?= e($missatge) ?></div>
<?php endif; ?>

