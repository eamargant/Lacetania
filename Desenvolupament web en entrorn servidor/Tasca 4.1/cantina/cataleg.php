<?php
session_start();
require_once __DIR__ . '/inc/protegeix.php';
$dades = require __DIR__ . '/inc/dades.php';
$productes = $dades['productes'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_var($_POST['id'] ?? '', FILTER_VALIDATE_INT); 
    $quantitat = filter_var($_POST['quantitat'] ?? '', FILTER_VALIDATE_INT,
        ['options' => ['min_range' => 1, 'max_range' => 5]]); #Per que la quantitat estigui entre 1 i 5 i no e pugui modificiar via url.

    if ($id !== false && $quantitat !== false && isset($productes[$id])) {
        $_SESSION['cistell'][$id] = ($_SESSION['cistell'][$id] ?? 0) + $quantitat;
        afegeixMissatge("S'han afegit {$quantitat} × {$productes[$id]['nom']}");
    }

    redirigeix('cataleg.php');
}

$titol = 'Catàleg';
require_once __DIR__ . '/inc/capcalera.php';
?>
<h1 class="h3 mb-3">Catàleg</h1>

<div class="card shadow-sm">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
        <tr>
            <th>Producte</th>
            <th class="text-end">Preu</th>
            <th class="text-end">Quantitat</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($productes as $id => $producte): ?>
            <tr>
                <td><?= e($producte['nom']) ?></td>
                <td class="text-end"><?= e(formatPreu($producte['preu'])) ?></td>
                <td class="text-end">
                    <form action="cataleg.php" method="post" class="d-inline-flex gap-2">
                        <input type="hidden" name="id" value="<?= e($id) ?>">
                        <select name="quantitat" class="form-select form-select-sm" style="width: auto">
                            <?php for ($q = 1; $q <= 5; $q++): ?>
                                <option value="<?= $q ?>"><?= $q ?></option>
                            <?php endfor; ?>
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm">Afegir</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once __DIR__ . '/inc/peu.php'; ?>
