<?php
// Array de 2 dimensions: cada mes té el nom i el nombre de dies
$mesos = [
    ['nom' => 'Gener',    'dies' => 31],
    ['nom' => 'Febrer',   'dies' => 28],
    ['nom' => 'Març',     'dies' => 31],
    ['nom' => 'Abril',    'dies' => 30],
    ['nom' => 'Maig',     'dies' => 31],
    ['nom' => 'Juny',     'dies' => 30],
    ['nom' => 'Juliol',   'dies' => 31],
    ['nom' => 'Agost',    'dies' => 31],
    ['nom' => 'Setembre', 'dies' => 30],
    ['nom' => 'Octubre',  'dies' => 31],
    ['nom' => 'Novembre', 'dies' => 30],
    ['nom' => 'Desembre', 'dies' => 31],
];

/**
 * Retorna quants dies té un mes.
 *
 * @param array  $mesos Array de mesos (nom i dies)
 * @param string $mes   Nom del mes a buscar (no distingeix majúscules)
 * @return int|null     Nombre de dies, o null si el mes no existeix
 */
function diesDelMes(array $mesos, string $mes): ?int
{
    foreach ($mesos as $m) {
        if (strcasecmp($m['nom'], $mes) === 0) {
            return $m['dies'];
        }
    }
    return null;
}
