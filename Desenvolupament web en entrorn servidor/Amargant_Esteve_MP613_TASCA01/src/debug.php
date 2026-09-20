<?php
require_once 'dades.php';
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Depuració</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <p><a href="index.php">Índex</a></p>
        <h1>Depuració amb var_dump()</h1>

        <h2>var_dump() de tot l'array $biblioteca</h2>
        <pre><?php var_dump($biblioteca); ?></pre>
    </div>
</body>
</html>
