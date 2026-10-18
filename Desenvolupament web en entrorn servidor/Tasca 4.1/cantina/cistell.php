<?php
session_start();
require_once __DIR__ . '/inc/protegeix.php';
$dades = require __DIR__ . '/inc/dades.php';
$productes = $dades['productes'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accio = $_POST['accio'] ?? '';
    #diferents casos d'us en funcio de l'acci que es vulgui fer amb el cisstell
    switch ($accio) {
        case 'treure':
            $id = filter_var($_POST['id'] ?? '', FILTER_VALIDATE_INT);
            if ($id !== false && isset($_SESSION['cistell'][$id])) {
                $nom = $productes[$id]['nom'] ?? 'Producte';
                unset($_SESSION['cistell'][$id]);
                afegeixMissatge("S'ha tret {$nom} del cistell");
            }
            break;

        case 'buidar':
            $_SESSION['cistell'] = [];
            afegeixMissatge('El cistell s\'ha buidat');
            break;

        case 'finalitzar':
            $cistell = $_SESSION['cistell'] ?? [];
            if (!empty($cistell)) {
                $linies = [];
                foreach ($cistell as $id => $quantitat) {
                    if (!isset($productes[$id])) {
                        continue;
                    }
                    $linies[] = [
                        'nom'       => $productes[$id]['nom'],
                        'preu'      => $productes[$id]['preu'],
                        'quantitat' => $quantitat,
                    ];
                }
                $total = totalCistell($cistell, $productes);

                $_SESSION['comandes'][] = [
                    'hora'   => date('H:i:s'),
                    'linies' => $linies,
                    'total'  => $total,
                ];
                $_SESSION['cistell'] = [];
                afegeixMissatge('Comanda enviada: ' . formatPreu($total));
            }
            break;
    }

    redirigeix('cistell.php');
}

$cistell = $_SESSION['cistell'] ?? [];
$comandes = $_SESSION['comandes'] ?? [];
$total = totalCistell($cistell, $productes);

$titol = 'Cistell';
require_once __DIR__ . '/inc/capcalera.php';
?>
<h1 class="h3 mb-3">Cistell</h1>

<?php if (empty($cistell)): ?>
    <div class="alert alert-info">
        El cistell és buit. <a href="cataleg.php" class="alert-link">Anar al catàleg</a>
    </div>
<?php else: ?>
    <div class="card shadow-sm mb-3">
        <table class="table align-middle mb-0">
            <thead class="table-light">
            <tr>
                <th>Producte</th>
                <th class="text-end">Preu</th>
                <th class="text-end">Quantitat</th>
                <th class="text-end">Subtotal</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($cistell as $id => $quantitat): ?>
                <?php if (!isset($productes[$id])) continue; ?>
                <?php $producte = $productes[$id]; ?>
                <tr>
                    <td><?= e($producte['nom']) ?></td>
                    <td class="text-end"><?= e(formatPreu($producte['preu'])) ?></td>
                    <td class="text-end"><?= e($quantitat) ?></td>
                    <td class="text-end"><?= e(formatPreu($producte['preu'] * $quantitat)) ?></td>
                    <td class="text-end">
                        <form action="cistell.php" method="post">
                            <input type="hidden" name="id" value="<?= e($id) ?>">
                            <button type="submit" name="accio" value="treure" class="btn btn-outline-danger btn-sm">Treure</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
            <tr class="fw-bold">
                <td colspan="3" class="text-end">Total</td>
                <td class="text-end"><?= e(formatPreu($total)) ?></td>
                <td></td>
            </tr>
            </tfoot>
        </table>
    </div>

    <form action="cistell.php" method="post" class="d-flex gap-2 justify-content-end mb-4">
        <button type="submit" name="accio" value="buidar" class="btn btn-outline-secondary">Buidar el cistell</button> 
        <button type="submit" name="accio" value="finalitzar" class="btn btn-success">Finalitzar comanda</button>
    </form>
<?php endif; ?>

<h2 class="h5 mt-4">Comandes fetes durant la sessió</h2>
<?php if (empty($comandes)): ?>
    <p class="text-muted">Encara no has fet cap comanda.</p>
<?php else: ?>
    <ul class="list-group">
        <?php foreach ($comandes as $i => $comanda): ?>
            <li class="list-group-item d-flex justify-content-between">
                <span>
                    <strong>#<?= $i + 1 ?></strong> · <?= e($comanda['hora']) ?>
                    <small class="text-muted">
                        (<?= e(implode(', ', array_map(fn($l) => $l['quantitat'] . ' × ' . $l['nom'], $comanda['linies']))) ?>)
                    </small>
                </span>
                <strong><?= e(formatPreu($comanda['total'])) ?></strong>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<?php require_once __DIR__ . '/inc/peu.php'; ?>
