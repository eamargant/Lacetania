<?php
/**
 * index.php
 * Pàgina d'inici: enllaços a cada exercici.
 */
require_once __DIR__ . '/includes/functions.php';

$titol = 'Inici - PHP Exercicis';

//fitxer => [títol, descripció]
$exercicis = [
    'ex1.php' => ['Capitals Europees', 'Ordenació, cerca i filtrat d\'un array associatiu.'],
    'ex2.php' => ['Anàlisi de Temperatures', 'Estadístiques i conversió Fahrenheit / Celsius.'],
    'ex3.php' => ['Arrays Associatius', 'Combinar arrays i afegir, modificar o eliminar parelles.'],
    'ex4.php' => ['Acadèmia d\'Idiomes', 'Matriu d\'alumnes per nivell i idioma.'],
];

require_once __DIR__ . '/includes/header.php';
?>
<h1 class="mb-4">Arrays, Funcions i Formularis en PHP</h1>

<div class="row g-3">
    <?php foreach ($exercicis as $fitxer => [$nom, $descripcio]): ?>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title"><?= e($nom) ?></h5>
                    <p class="card-text"><?= e($descripcio) ?></p>
                    <a href="<?= e($fitxer) ?>" class="btn btn-primary">Obrir</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
