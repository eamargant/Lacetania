<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Exercici 4 - Validador de contrasenyes</title>
</head>
<body>
    <h1>Validador de contrasenyes</h1>
    <form action="ex4_processa.php" method="post">
        <p>
            <label for="contrasenya">Contrasenya:</label>
            <input type="password" id="contrasenya" name="contrasenya" required>
        </p>
        <button type="submit">Valida</button>
    </form>

    <p>La contrasenya ha de tenir:</p>
    <ul>
        <li>Almenys 8 caràcters de longitud.</li>
        <li>Almenys una lletra majúscula.</li>
        <li>Almenys un número.</li>
        <li>Almenys un caràcter especial (com ara @, #, $, etc.).</li>
    </ul>

    <p><a href="index.php">Tornar a l'índex</a></p>
</body>
</html>
