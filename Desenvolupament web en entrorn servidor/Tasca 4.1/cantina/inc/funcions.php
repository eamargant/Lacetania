<?php

date_default_timezone_set('Europe/Madrid');

function e(string|int|float $text): string
{
    return htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
}
/**
 * Formata el preu i afegeix el € al funal
 */
function formatPreu(float $preu): string
{
    return number_format($preu, 2, ',', '.') . ' €';
}

/**
 * RFunccio per redirigir a una URL
 */
function redirigeix(string $url): never
{
    header('Location: ' . $url);
    exit;
}

/**
 * Retorna un usuari en concret o null si ni existeix
 */
function buscaUsuari(array $usuaris, string $email): ?array
{
    foreach ($usuaris as $usuari) {
        if (strcasecmp($usuari['email'], $email) === 0) {
            return $usuari;
        }
    }
    return null;
}

/**
 * Suma totes les unitats de productres que hi ha al cistell
 */
function unitatsCistell(array $cistell): int
{
    return (int) array_sum($cistell);
}

/**
 * Calcula el total del cistell. productes X quantitat.
 */
function totalCistell(array $cistell, array $productes): float
{
    $total = 0.0;
    foreach ($cistell as $id => $quantitat) {
        if (!isset($productes[$id])) {
            continue;
        }
        $total += $productes[$id]['preu'] * $quantitat;
    }
    return $total;
}

/**
 * Missatge flahs a la sessio
 */
function afegeixMissatge(string $text): void
{
    $_SESSION['missatge'] = $text;
}

/**
 * Llegeix el missatge de la sessio
 */
function llegeixMissatge(): ?string
{
    $missatge = $_SESSION['missatge'] ?? null;
    unset($_SESSION['missatge']);
    return $missatge;
}
