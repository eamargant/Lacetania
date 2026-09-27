<?php declare(strict_types=1);

$alumnes = [
    ["nom" => "Anna", "nota" => 8.5],
    ["nom" => "Pau",  "nota" => 4.0],
    ["nom" => "Laia", "nota" => 6.25],
    ["nom" => "Marc", "nota" => 5.0],
];

function aprovats(array $alumnes, float $minim = 5.0): array
{
    return array_values(array_filter(
        $alumnes,
        fn(array $alumne): bool => $alumne["nota"] >= $minim
    ));
}

function noms(array $alumnes): array
{
    return array_map(fn(array $alumne): string => $alumne["nom"], $alumnes);
}

function mitjana(float ...$notes): float
{
    if (count($notes) === 0) {
        return 0.0;
    }

    return array_sum($notes) / count($notes);
}

$aprovats = aprovats($alumnes);
$noms = noms($aprovats);
$mitjana = mitjana(...array_map(fn(array $alumne): float => $alumne["nota"], $aprovats));

printf("Aprovats: %s (mitjana %.2f)\n", implode(", ", $noms), $mitjana);

