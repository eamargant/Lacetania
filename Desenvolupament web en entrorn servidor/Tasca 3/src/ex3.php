<?php
/**
 * ex3.php - Arrays Associatius
 * Combina $keys i $values de dues maneres i permet afegir, modificar i eliminar parelles (POST).
 */
require_once __DIR__ . '/includes/functions.php';

$titol = 'Arrays Associatius';

$keys = array(
    "field1" => "first",
    "field2" => "second",
    "field3" => "third"
);
$values = array(
    "field1value" => "dinosaur",
    "field2value" => "pig",
    "field3value" => "platypus"
);

$errors = [];
$exit = '';

// Resultat de les dues funcions de combinació
try {
    $ambBucles = combinarAmbBucles($keys, $values);
    $ambCombine = combinarAmbArrayCombine($keys, $values);
} catch (InvalidArgumentException $ex) {
    $errors[] = $ex->getMessage();
    $ambBucles = $ambCombine = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperem l'estat dels camps ocults i el validem
    $parelles = [];
    foreach ((array) ($_POST['parelles'] ?? []) as $clau => $valor) {
        $clau = (string) $clau;
        if (!is_string($valor) || !validarClau($clau) || !validarValor($valor)) {
            $errors[] = 'S\'ha descartat una parella desada que no era vàlida.';
            continue;
        }
        $parelles[$clau] = $valor;
    }

    $accio = $_POST['accio'] ?? '';
    $clau = trim($_POST['clau'] ?? '');
    $valor = trim($_POST['valor'] ?? '');

    try {
        switch ($accio) {
            case 'afegir':
                if (!validarClau($clau)) {
                    throw new InvalidArgumentException('La clau ha de tenir entre 1 i 30 caràcters (lletres, números, espais, _ o -).');
                }
                if (!validarValor($valor)) {
                    throw new InvalidArgumentException('El valor no pot estar buit ni superar els 50 caràcters.');
                }
                $parelles = afegirParella($parelles, $clau, $valor);
                $exit = "S'ha afegit la parella \"$clau\".";
                break;

            case 'modificar':
                if (!validarValor($valor)) {
                    throw new InvalidArgumentException('El valor no pot estar buit ni superar els 50 caràcters.');
                }
                $parelles = modificarParella($parelles, $clau, $valor);
                $exit = "S'ha modificat la clau \"$clau\".";
                break;

            case 'eliminar':
                $parelles = eliminarParella($parelles, $clau);
                $exit = "S'ha eliminat la clau \"$clau\".";
                break;

            default:
                throw new InvalidArgumentException('Acció desconeguda.');
        }
    } catch (InvalidArgumentException $ex) {
        $errors[] = $ex->getMessage();
    }
} else {
    // Primera visita: partim de l'array combinat
    $parelles = $ambBucles;
}

require_once __DIR__ . '/includes/header.php';
?>
<h1 class="mb-4">Arrays Associatius</h1>

<?php mostrarErrors($errors); ?>
<?php mostrarExit($exit); ?>

<div class="card mb-4">
    <div class="card-header fw-semibold">Combinació de $keys i $values</div>
    <div class="card-body">
        <p class="mb-1">Amb bucles (<code>combinarAmbBucles()</code>):</p>
        <pre class="bg-light p-2 border rounded"><?= e(formatArrayAssociatiu($ambBucles)) ?></pre>

        <p class="mb-1">Amb <code>array_combine()</code> (<code>combinarAmbArrayCombine()</code>):</p>
        <pre class="bg-light p-2 border rounded"><?= e(formatArrayAssociatiu($ambCombine)) ?></pre>

        <?php if ($ambBucles === $ambCombine): ?>
            <span class="badge text-bg-success">Els dos mètodes donen el mateix resultat</span>
        <?php else: ?>
            <span class="badge text-bg-danger">Els resultats són diferents</span>
        <?php endif; ?>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header fw-semibold">Afegir nova parella</div>
    <div class="card-body">
        <form action="" method="post" class="row g-2 align-items-end">
            <?= campsOcults('parelles', $parelles) ?>
            <div class="col-md-5">
                <label for="clau" class="form-label">Clau:</label>
                <input type="text" id="clau" name="clau" class="form-control" maxlength="30" required>
            </div>
            <div class="col-md-5">
                <label for="valor" class="form-label">Valor:</label>
                <input type="text" id="valor" name="valor" class="form-control" maxlength="50" required>
            </div>
            <div class="col-md-2 d-grid">
                <button type="submit" name="accio" value="afegir" class="btn btn-primary">Afegir</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header fw-semibold d-flex justify-content-between align-items-center">
        Array actual (<?= count($parelles) ?> parelles)
        <a href="ex3.php" class="btn btn-sm btn-outline-secondary">Restaurar</a>
    </div>
    <div class="card-body">
        <?php if (empty($parelles)): ?>
            <p class="text-muted mb-0">L'array és buit.</p>
        <?php else: ?>
            <pre class="bg-light p-2 border rounded"><?= e(formatArrayAssociatiu($parelles)) ?></pre>
            <table class="table mb-0">
                <thead>
                <tr><th>Clau</th><th>Valor</th><th class="text-end">Accions</th></tr>
                </thead>
                <tbody>
                <?php foreach ($parelles as $clau => $valor): ?>
                    <tr>
                        <td><?= e($clau) ?></td>
                        <td colspan="2">
                            <!-- Cada fila és un formulari amb tot l'estat i la clau de la fila -->
                            <form action="" method="post" class="d-flex gap-2">
                                <?= campsOcults('parelles', $parelles) ?>
                                <input type="hidden" name="clau" value="<?= e($clau) ?>">
                                <input type="text" name="valor" class="form-control form-control-sm"
                                       maxlength="50" value="<?= e($valor) ?>">
                                <button type="submit" name="accio" value="modificar"
                                        class="btn btn-sm btn-warning">Modificar</button>
                                <button type="submit" name="accio" value="eliminar"
                                        class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
