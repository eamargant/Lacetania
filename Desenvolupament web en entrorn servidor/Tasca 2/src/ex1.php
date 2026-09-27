<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Exercici 1 - Àrea d'un rectangle</title>
</head>
<body>
    <h1>Àrea d'un rectangle</h1>
    <form action="ex1_processa.php" method="get">
        <p>
            <label for="base">Base:</label>
            <input type="number" id="base" name="base" step="any" min="0" required>
        </p>
        <p>
            <label for="altura">Altura:</label>
            <input type="number" id="altura" name="altura" step="any" min="0" required>
        </p>
        <button type="submit">Calcula</button>
    </form>

    <p><a href="index.php">Tornar a l'índex</a></p>
</body>
</html>
