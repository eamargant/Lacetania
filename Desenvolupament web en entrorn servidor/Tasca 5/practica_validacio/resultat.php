<?php
// Resum de les dades validades.
session_start();

// Sense dades validades no es pot entrar aquí
if (!isset($_SESSION['resultat'])) {
    header('Location: registre.php');
    exit;
}

$resultat = $_SESSION['resultat'];

// Un cop llegides, s'esborren 
unset($_SESSION['resultat']);

$titol = 'Registre completat';
include __DIR__ . '/includes/header.php';
?>
<h1>Registre completat</h1>

<table>
    <tr>
        <th>Nom</th>
        <td><?= htmlspecialchars($resultat['nom']) ?></td>
    </tr>
    <tr>
        <th>Email</th>
        <td><?= htmlspecialchars($resultat['email']) ?></td>
    </tr>
    <tr>
        <th>Edat</th>
        <td><?= htmlspecialchars((string)$resultat['edat']) ?></td>
    </tr>
    <tr>
        <th>Telèfon</th>
        <td><?= $resultat['telefon'] === '' ? 'No indicat' : htmlspecialchars($resultat['telefon']) ?></td>
    </tr>
    <tr>
        <th>Població</th>
        <td><?= htmlspecialchars($resultat['poblacio']) ?></td>
    </tr>
</table>

<p><a class="boto" href="index.php">Tornar a l'inici</a></p>

<?php include __DIR__ . '/includes/footer.php'; ?>
