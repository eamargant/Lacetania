<?php
session_start();
require_once __DIR__ . '/inc/protegeix.php';
require_once __DIR__ . '/inc/funcions.php';
$dades = require __DIR__ . '/inc/dades.php';

$usuari = $_SESSION['usuari'];
$consulta = $dades['consulta'];

if ($usuari['rol'] !== 'votant') {
    afegeixMissatge('Només els votants poden votar.');
    header('Location: benvinguda.php');
    exit;
}
if (!votacioOberta($consulta['tancament'])) {
    afegeixMissatge('La votació està tancada.');
    header('Location: resultats.php');
    exit;
}
if (jaHaVotat($usuari['email'])) {
    afegeixMissatge('Ja has votat. Gràcies!');
    header('Location: resultats.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $opcio = $_POST['opcio'] ?? '';

    if (array_key_exists($opcio, $consulta['opcions'])) {
        guardaVot($usuari['email'], $opcio);
        afegeixMissatge('Vot registrat. Gràcies per participar!');
        header('Location: resultats.php');
        exit;
    }
    $error = 'Tria una de les opcions.';
}

$titol = 'Votar';
require_once __DIR__ . '/inc/capcalera.php';
?>
<h1>Votació</h1>

<?php if ($error !== ''): ?>
    <p class="missatge"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="post" action="votacio.php">
    <p><strong><?= htmlspecialchars($consulta['pregunta']) ?></strong></p>

    <?php foreach ($consulta['opcions'] as $clau => $text): ?>
        <p>
            <label>
                <input type="radio" name="opcio" value="<?= htmlspecialchars($clau) ?>">
                <?= htmlspecialchars($text) ?>
            </label>
        </p>
    <?php endforeach; ?>

    <button type="submit">Votar</button>
</form>

<?php require_once __DIR__ . '/inc/peu.php'; ?>
