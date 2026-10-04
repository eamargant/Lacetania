<?php
require_once __DIR__ . '/includes/functions.php';

$titol = 'Anàlisi de Temperatures';

$temperaturesInicials = [78, 60, 62, 68, 71, 68, 73, 85, 66, 64, 76, 63, 75, 76, 73,
    68, 62, 73, 72, 65, 74, 62, 62, 65, 64, 68, 73, 75, 79, 73];

$errors = [];
$exit = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperem l'estat dels camps ocults i el validem
    $temperatures = [];
    foreach ((array) ($_POST['temps'] ?? []) as $valor) {
        $temp = validarTemperatura($valor);
        if ($temp === null) {
            $errors[] = 'S\'ha descartat una temperatura desada que no era vàlida.';
            continue;
        }
        $temperatures[] = $temp;
    }
    if (empty($temperatures)) {
        $errors[] = 'No hi havia temperatures vàlides: s\'han restaurat les inicials.';
        $temperatures = $temperaturesInicials;
    }

    $escala = ($_POST['escala'] ?? 'F') === 'C' ? 'C' : 'F';

    // Afegir una temperatura nova
    if (($_POST['accio'] ?? '') === 'afegir') {
        $nova = validarTemperatura(trim($_POST['nova'] ?? ''));
        if ($nova === null) {
            $errors[] = 'Introdueix una temperatura numèrica entre -100 i 200 °F.';
        } else {
            $temperatures[] = $nova;
            $exit = 'S\'ha afegit la temperatura ' . formatTemperatura($nova, 'F') . '.';
        }
    }
} else {
    $temperatures = $temperaturesInicials;
    $escala = 'F';
}

$mitjana = calcularMitjana($temperatures);
$mediana = calcularMediana($temperatures);
$maxima = temperaturaMaxima($temperatures);
$minima = temperaturaMinima($temperatures);
$mesAltes = temperaturesMesAltes($temperatures);
$mesBaixes = temperaturesMesBaixes($temperatures);

$ordenades = $temperatures;
sort($ordenades);

// Dades per al gràfic
$dadesGrafic = array_map(
    fn($f) => $escala === 'C' ? fahrenheitACelsius($f) : (float) $f,
    $temperatures
);

require_once __DIR__ . '/includes/header.php';
?>
<h1 class="mb-4">Anàlisi de Temperatures</h1>

<?php mostrarErrors($errors); ?>
<?php mostrarExit($exit); ?>

<div class="card mb-4">
    <div class="card-body row g-3">
        <form action="" method="post" class="col-md-6">
            <?php foreach ($temperatures as $t): ?>
                <input type="hidden" name="temps[]" value="<?= e($t) ?>">
            <?php endforeach; ?>
            <input type="hidden" name="escala" value="<?= e($escala) ?>">

            <label for="nova" class="form-label">Afegir nova temperatura (°F):</label>
            <input type="number" id="nova" name="nova" class="form-control mb-2"
                   step="0.01" min="-100" max="200" required>
            <button type="submit" name="accio" value="afegir" class="btn btn-primary">Afegir</button>
        </form>

        <form action="" method="post" class="col-md-6">
            <?php foreach ($temperatures as $t): ?>
                <input type="hidden" name="temps[]" value="<?= e($t) ?>">
            <?php endforeach; ?>

            <span class="me-2">Escala de temperatura:</span>
            <div class="btn-group" role="group">
                <button type="submit" name="escala" value="F"
                        class="btn btn-sm <?= $escala === 'F' ? 'btn-primary' : 'btn-outline-primary' ?>">Fahrenheit</button>
                <button type="submit" name="escala" value="C"
                        class="btn btn-sm <?= $escala === 'C' ? 'btn-primary' : 'btn-outline-primary' ?>">Celsius</button>
            </div>
        </form>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header fw-semibold">Estadístiques Bàsiques</div>
            <div class="card-body">
                <table class="table mb-0">
                    <tr><td>Mitjana:</td><th class="text-end"><?= e(formatTemperatura($mitjana, $escala)) ?></th></tr>
                    <tr><td>Mediana:</td><th class="text-end"><?= e(formatTemperatura($mediana, $escala)) ?></th></tr>
                    <tr><td>Temperatura màxima:</td><th class="text-end"><?= e(formatTemperatura($maxima, $escala)) ?></th></tr>
                    <tr><td>Temperatura mínima:</td><th class="text-end"><?= e(formatTemperatura($minima, $escala)) ?></th></tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header fw-semibold">Top 5 Temperatures</div>
            <div class="card-body">
                <p class="fw-semibold mb-1">Més altes:</p>
                <ul class="list-group mb-3">
                    <?php foreach ($mesAltes as $t): ?>
                        <li class="list-group-item"><?= e(formatTemperatura($t, $escala)) ?></li>
                    <?php endforeach; ?>
                </ul>
                <p class="fw-semibold mb-1">Més baixes:</p>
                <ul class="list-group">
                    <?php foreach ($mesBaixes as $t): ?>
                        <li class="list-group-item"><?= e(formatTemperatura($t, $escala)) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header fw-semibold">Evolució (ordre d'entrada)</div>
    <div class="card-body">
        <canvas id="grafic" height="100"></canvas>
    </div>
</div>

<div class="card">
    <div class="card-header fw-semibold">Totes les temperatures</div>
    <div class="card-body">
        <table class="table table-striped mb-0">
            <thead>
            <tr><th>#</th><th>Temperatura (°<?= e($escala) ?>)</th></tr>
            </thead>
            <tbody>
            <?php foreach ($ordenades as $i => $t): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= e(formatTemperatura($t, $escala)) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    const dades = <?= json_encode($dadesGrafic, JSON_HEX_TAG) ?>;
    new Chart(document.getElementById('grafic'), {
        type: 'line',
        data: {
            labels: dades.map((_, i) => i + 1),
            datasets: [{
                label: 'Temperatura (°<?= e($escala) ?>)',
                data: dades,
                borderColor: '#0d6efd',
                tension: 0.3
            }]
        }
    });
</script>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
