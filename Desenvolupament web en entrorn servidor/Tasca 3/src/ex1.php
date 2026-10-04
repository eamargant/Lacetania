<?php
require_once __DIR__ . '/includes/functions.php';

$titol = 'Capitals Europees';

$ceu = array(
    "Italy" => "Rome",
    "Luxembourg" => "Luxembourg",
    "Belgium" => "Brussels",
    "Denmark" => "Copenhagen",
    "Finland" => "Helsinki", 
    "France" => "Paris",
    "Slovakia" => "Bratislava",
    "Slovenia" => "Ljubljana",
    "Germany" => "Berlin",
    "Greece" => "Athens",
    "Ireland" => "Dublin",
    "Netherlands" => "Amsterdam",
    "Portugal" => "Lisbon",
    "Spain" => "Madrid",
    "Sweden" => "Stockholm",
    "United Kingdom" => "London",
    "Cyprus" => "Nicosia",
    "Lithuania" => "Vilnius",
    "Czech Republic" => "Prague",
    "Estonia" => "Tallinn",
    "Hungary" => "Budapest",
    "Latvia" => "Riga",
    "Malta" => "Valletta",
    "Austria" => "Vienna",
    "Poland" => "Warsaw"
);

$lletres = lletresInicials($ceu);
$errors = [];

//parametres del formulari
$cerca = trim($_GET['cerca'] ?? '');
$lletra = $_GET['lletra'] ?? '';

// Validació
if (mb_strlen($cerca) > 50) {
    $errors[] = 'El text de cerca no pot superar els 50 caràcters.';
    $cerca = '';
}
if ($lletra !== '' && !in_array($lletra, $lletres, true)) {
    $errors[] = 'La lletra seleccionada no és vàlida.';
    $lletra = '';
}

// Ordenar -> cercar -> filtrar
$resultat = ordenarPerCapital($ceu);
$resultat = cercarPaisOCapital($resultat, $cerca);
$resultat = filtrarPerLletra($resultat, $lletra);

require_once __DIR__ . '/includes/header.php';
?>
<h1 class="mb-4">Capitals Europees</h1>

<?php mostrarErrors($errors); ?>

<div class="card mb-4">
    <div class="card-body">
        <form action="" method="get" class="row g-3 align-items-end">
            <div class="col-md-6">
                <label for="cerca" class="form-label">Cerca per país o capital:</label>
                <input type="text" id="cerca" name="cerca" class="form-control" maxlength="50"
                       value="<?= e($cerca) ?>">
            </div>
            <div class="col-md-4">
                <label for="lletra" class="form-label">Filtrar per lletra inicial:</label>
                <select id="lletra" name="lletra" class="form-select">
                    <option value="">Totes</option>
                    <?php foreach ($lletres as $l): ?>
                        <option value="<?= e($l) ?>" <?= $l === $lletra ? 'selected' : '' ?>><?= e($l) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2 d-grid">
                <button type="submit" class="btn btn-primary">Cercar</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php if (empty($resultat)): ?>
            <p class="text-muted mb-0">No s'ha trobat cap país amb aquests criteris.</p>
        <?php else: ?>
            <table class="table table-striped mb-0">
                <thead>
                <tr>
                    <th>País</th>
                    <th>Capital</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($resultat as $pais => $capital): ?>
                    <tr>
                        <td><?= e($pais) ?></td>
                        <td><?= e($capital) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <p class="text-muted small mt-2 mb-0"><?= count($resultat) ?> resultat(s)</p>
        <?php endif; ?>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
