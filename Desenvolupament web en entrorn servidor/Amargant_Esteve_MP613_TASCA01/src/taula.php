<?php
require_once 'dades.php';
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Vista en taula</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <p><a href="index.php">Índex</a></p>
        <h1>Taula de llibres</h1>

        <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Títol</th>
                <th>Autor</th>
                <th>Any</th>
                <th>Gènere</th>
                <th>Llegit</th>
                <th>Valoració</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($biblioteca as $llibre): ?>
                <tr>
                    <td><?= $llibre['id'] ?></td>
                    <td><?= $llibre['titol'] ?></td>
                    <td><?= $llibre['autor'] ?></td>
                    <td><?= $llibre['any'] ?></td>
                    <td><?= $llibre['genere'] ?></td>
                    <td><?= $llibre['llegit'] ? 'Sí' : 'No' ?></td>
                    <td><?= $llibre['llegit'] ? $llibre['valoracio'] : '-' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        </table>
    </div>
</body>
</html>
