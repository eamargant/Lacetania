<?php
/**
 * ex4.php - Gestió d'Acadèmia d'Idiomes
 * Matriu nivells x idiomes amb els noms dels alumnes.
 */
require_once __DIR__ . '/includes/functions.php';

$titol = 'Acadèmia d\'Idiomes';

$nivells = ['Bàsic', 'Mitjà', 'Perfeccionament'];
$idiomes = ['Anglès', 'Francès', 'Alemany', 'Rus'];

$academiaInicial = [
    'Bàsic' => [
        'Anglès' => ['Anna', 'Marc', 'Laia', 'Pau', 'Júlia'],
        'Francès' => ['Jordi', 'Marta'],
        'Alemany' => ['Núria', 'Oriol', 'Clara'],
        'Rus' => ['Pol'],
    ],
    'Mitjà' => [
        'Anglès' => ['Arnau', 'Berta', 'Carla', 'David'],
        'Francès' => ['Elena', 'Ferran', 'Gemma'],
        'Alemany' => ['Hug'],
        'Rus' => ['Irene', 'Joan'],
    ],
    'Perfeccionament' => [
        'Anglès' => ['Kilian', 'Lucía', 'Mireia'],
        'Francès' => ['Nil'],
        'Alemany' => ['Olga', 'Pere'],
        'Rus' => ['Queralt', 'Roger', 'Sílvia'],
    ],
];

$errors = [];
$exit = '';

// D'on llegim l'estat: POST (accions) o GET (cerca).
$peticio = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_GET;

if (isset($peticio['estat'])) {
    $descartats = 0;
    $academia = reconstruirAcademia($peticio['alumnes'] ?? [], $nivells, $idiomes, $descartats);
    if ($descartats > 0) {
        $errors[] = "S'han descartat $descartats valors desats que no eren vàlids.";
    }
} else {
    $academia = $academiaInicial;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accio = $_POST['accio'] ?? '';
    $nom = trim($_POST['nom'] ?? '');
    $nivell = $_POST['nivell'] ?? '';
    $idioma = $_POST['idioma'] ?? '';

    try {
        switch ($accio) {
            case 'afegir':
                $academia = afegirAlumne($academia, $nivell, $idioma, $nom);
                $exit = "S'ha afegit $nom a $nivell - $idioma.";
                break;

            case 'eliminar':
                $academia = eliminarAlumne($academia, $nom);
                $exit = "S'ha eliminat $nom.";
                break;

            case 'moure':
                $academia = moureAlumne($academia, $nom, $nivell, $idioma);
                $exit = "S'ha mogut $nom a $nivell - $idioma.";
                break;

            default:
                throw new InvalidArgumentException('Acció desconeguda.');
        }
    } catch (InvalidArgumentException $ex) {
        $errors[] = $ex->getMessage();
    }
}

$cerca = trim($_GET['cerca'] ?? '');
$resultatsCerca = [];
if ($cerca !== '') {
    if (mb_strlen($cerca) > 40) {
        $errors[] = 'El text de cerca no pot superar els 40 caràcters.';
        $cerca = '';
    } else {
        $resultatsCerca = cercarAlumne($academia, $cerca);
    }
}

$totalAlumnes = comptarTotalAlumnes($academia);
$totalPerIdioma = comptarTotalPerIdioma($academia);
$totalPerNivell = comptarTotalPerNivell($academia);
$grupMes = buscarGrupMesNombros($academia);
$grupMenys = buscarGrupMenysNombros($academia);
$mitjanaNivell = calcularMitjanaPerNivell($academia);
$mitjanaIdioma = calcularMitjanaPerIdioma($academia);
$llistaAlumnes = llistarAlumnes($academia);

$nomsTrobats = array_column($resultatsCerca, 'nom');

$estat = '<input type="hidden" name="estat" value="1">' . "\n" . campsOcults('alumnes', $academia);

require_once __DIR__ . '/includes/header.php';
?>
<h1 class="mb-4">Gestió d'Acadèmia d'Idiomes</h1>

<?php mostrarErrors($errors); ?>
<?php mostrarExit($exit); ?>

<div class="card mb-4">
    <div class="card-header fw-semibold d-flex justify-content-between align-items-center">
        Alumnes per nivell i idioma
        <a href="ex4.php" class="btn btn-sm btn-outline-secondary">Restaurar</a>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered mb-0">
            <thead class="table-light">
            <tr>
                <th>Nivell</th>
                <?php foreach ($idiomes as $idioma): ?>
                    <th><?= e($idioma) ?></th>
                <?php endforeach; ?>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($academia as $nivell => $perIdioma): ?>
                <tr>
                    <th><?= e($nivell) ?></th>
                    <?php foreach ($perIdioma as $alumnes): ?>
                        <td>
                            <span class="fw-semibold"><?= count($alumnes) ?></span>
                            <div class="small">
                                <?php foreach ($alumnes as $alumne): ?>
                                    <span class="badge <?= in_array($alumne, $nomsTrobats, true) ? 'text-bg-warning' : 'text-bg-light border' ?>"><?= e($alumne) ?></span>
                                <?php endforeach; ?>
                            </div>
                        </td>
                    <?php endforeach; ?>
                    <th><?= $totalPerNivell[$nivell] ?></th>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot class="table-light">
            <tr>
                <th>Total</th>
                <?php foreach ($idiomes as $idioma): ?>
                    <th><?= $totalPerIdioma[$idioma] ?></th>
                <?php endforeach; ?>
                <th><?= $totalAlumnes ?></th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header fw-semibold">Estadístiques generals</div>
            <div class="card-body">
                <table class="table mb-0">
                    <tr><td>Total d'alumnes:</td><th class="text-end"><?= $totalAlumnes ?></th></tr>
                    <tr>
                        <td>Grup més nombrós:</td>
                        <th class="text-end"><?= e($grupMes['nivell'] . ' - ' . $grupMes['idioma']) ?> (<?= $grupMes['total'] ?>)</th>
                    </tr>
                    <tr>
                        <td>Grup menys nombrós:</td>
                        <th class="text-end"><?= e($grupMenys['nivell'] . ' - ' . $grupMenys['idioma']) ?> (<?= $grupMenys['total'] ?>)</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header fw-semibold">Per idioma</div>
            <div class="card-body">
                <table class="table mb-0">
                    <thead><tr><th>Idioma</th><th class="text-end">Total</th><th class="text-end">Mitjana/grup</th></tr></thead>
                    <?php foreach ($idiomes as $idioma): ?>
                        <tr>
                            <td><?= e($idioma) ?></td>
                            <td class="text-end"><?= $totalPerIdioma[$idioma] ?></td>
                            <td class="text-end"><?= number_format($mitjanaIdioma[$idioma], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header fw-semibold">Per nivell</div>
            <div class="card-body">
                <table class="table mb-0">
                    <thead><tr><th>Nivell</th><th class="text-end">Total</th><th class="text-end">Mitjana/grup</th></tr></thead>
                    <?php foreach ($nivells as $nivell): ?>
                        <tr>
                            <td><?= e($nivell) ?></td>
                            <td class="text-end"><?= $totalPerNivell[$nivell] ?></td>
                            <td class="text-end"><?= number_format($mitjanaNivell[$nivell], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header fw-semibold">Afegir alumne</div>
            <div class="card-body">
                <form action="" method="post">
                    <?= $estat ?>
                    <label for="nom-afegir" class="form-label">Nom:</label>
                    <input type="text" id="nom-afegir" name="nom" class="form-control mb-2" maxlength="40" required>
                    <label for="nivell-afegir" class="form-label">Nivell:</label>
                    <select id="nivell-afegir" name="nivell" class="form-select mb-2">
                        <?php foreach ($nivells as $n): ?>
                            <option value="<?= e($n) ?>"><?= e($n) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="idioma-afegir" class="form-label">Idioma:</label>
                    <select id="idioma-afegir" name="idioma" class="form-select mb-3">
                        <?php foreach ($idiomes as $i): ?>
                            <option value="<?= e($i) ?>"><?= e($i) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" name="accio" value="afegir" class="btn btn-primary">Afegir</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header fw-semibold">Moure alumne</div>
            <div class="card-body">
                <form action="" method="post">
                    <?= $estat ?>
                    <label for="nom-moure" class="form-label">Alumne:</label>
                    <select id="nom-moure" name="nom" class="form-select mb-2" required>
                        <?php foreach ($llistaAlumnes as $alumne): ?>
                            <option value="<?= e($alumne) ?>"><?= e($alumne) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="nivell-moure" class="form-label">Nivell destí:</label>
                    <select id="nivell-moure" name="nivell" class="form-select mb-2">
                        <?php foreach ($nivells as $n): ?>
                            <option value="<?= e($n) ?>"><?= e($n) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="idioma-moure" class="form-label">Idioma destí:</label>
                    <select id="idioma-moure" name="idioma" class="form-select mb-3">
                        <?php foreach ($idiomes as $i): ?>
                            <option value="<?= e($i) ?>"><?= e($i) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" name="accio" value="moure" class="btn btn-warning">Moure</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header fw-semibold">Eliminar alumne</div>
            <div class="card-body">
                <form action="" method="post">
                    <?= $estat ?>
                    <label for="nom-eliminar" class="form-label">Alumne:</label>
                    <select id="nom-eliminar" name="nom" class="form-select mb-3" required>
                        <?php foreach ($llistaAlumnes as $alumne): ?>
                            <option value="<?= e($alumne) ?>"><?= e($alumne) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" name="accio" value="eliminar" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header fw-semibold">Cercar alumne</div>
    <div class="card-body">
        <form action="" method="get" class="row g-2 mb-3">
            <?= $estat ?>
            <div class="col-md-10">
                <input type="text" name="cerca" class="form-control" maxlength="40"
                       placeholder="Nom de l'alumne" value="<?= e($cerca) ?>">
            </div>
            <div class="col-md-2 d-grid">
                <button type="submit" class="btn btn-primary">Cercar</button>
            </div>
        </form>

        <?php if ($cerca !== ''): ?>
            <?php if (empty($resultatsCerca)): ?>
                <p class="text-muted mb-0">No s'ha trobat cap alumne amb "<?= e($cerca) ?>".</p>
            <?php else: ?>
                <table class="table table-striped mb-0">
                    <thead><tr><th>Alumne</th><th>Nivell</th><th>Idioma</th></tr></thead>
                    <tbody>
                    <?php foreach ($resultatsCerca as $r): ?>
                        <tr>
                            <td><?= e($r['nom']) ?></td>
                            <td><?= e($r['nivell']) ?></td>
                            <td><?= e($r['idioma']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
