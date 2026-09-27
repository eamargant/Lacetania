<?php
// Carreguem l'array de mesos per generar les opcions del desplegable
require_once 'mesos.php';
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Exercici 2 - Dies d'un mes</title>
</head>
<body>
    <h1>Quants dies té un mes?</h1>
    <form action="ex2_processa.php" method="get">
        <p>
            <label for="mes">Mes:</label>
            <select id="mes" name="mes" required>
                <?php foreach ($mesos as $m): ?>
                    <option value="<?= $m['nom'] ?>"><?= $m['nom'] ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <button type="submit">Consulta</button>
    </form>

    <p><a href="index.php">Tornar a l'índex</a></p>
</body>
</html>
