<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Exercici 3 - Conversió de temperatura</title>
</head>
<body>
    <h1>Conversió de temperatura</h1>
    <!-- Les dades s'envien via GET-->
    <form action="ex3_processa.php" method="get">
        <p>
            <input type="radio" id="origen_f" name="origen" value="Fahrenheit" checked>
            <label for="origen_f">Fahrenheit</label>
            <input type="radio" id="origen_c" name="origen" value="Celsius">
            <label for="origen_c">Celsius</label>
            <input type="radio" id="origen_k" name="origen" value="Kelvin">
            <label for="origen_k">Kelvin</label>
        </p>

        <p>
            <input type="number" id="valor" name="valor" step="any" required>
        </p>

        <p>
            <input type="radio" id="desti_f" name="desti" value="Fahrenheit">
            <label for="desti_f">Fahrenheit</label>
            <input type="radio" id="desti_c" name="desti" value="Celsius" checked>
            <label for="desti_c">Celsius</label>
            <input type="radio" id="desti_k" name="desti" value="Kelvin">
            <label for="desti_k">Kelvin</label>
        </p>

        <button type="submit">Converteix</button>
    </form>

    <p><a href="index.php">Tornar a l'índex</a></p>
</body>
</html>
