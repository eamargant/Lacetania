<?php
// Les funbcions retornen el missatge d'error, o null si el valor és correcte.
// Lletres (també amb accent), espais, apòstrofs i guions. 
const PATRO_LLETRES = "/^[\p{L} '’-]+$/u";

function validarNom(string $nom): ?string
{
    if ($nom === '') {
        return 'El nom és obligatori.';
    }
    if (mb_strlen($nom) < 2 || mb_strlen($nom) > 50) {
        return 'El nom ha de tenir entre 2 i 50 caràcters.';
    }
    if (!preg_match(PATRO_LLETRES, $nom)) {
        return 'El nom només pot tenir lletres, espais, apòstrofs i guions.';
    }
    return null;
}

function validarEmail(string $email): ?string
{
    if ($email === '') {
        return "L'email és obligatori.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "L'email no té un format vàlid.";
    }
    return null;
}

function validarEdat(string $edat): ?string
{
    if ($edat === '') {
        return "L'edat és obligatòria.";
    }
    // Només numeros
    if (!preg_match('/^\d+$/', $edat)) {
        return "L'edat ha de ser un nombre enter.";
    }
    if ((int)$edat < 18 || (int)$edat > 120) {
        return "L'edat ha de ser entre 18 i 120.";
    }
    return null;
}

function validarTelefon(string $telefon): ?string
{
    if ($telefon === '') {
        return null;
    }
    if (!preg_match('/^\d{9}$/', $telefon)) {
        return 'El telèfon ha de tenir exactament 9 dígits.';
    }
    return null;
}

function validarPoblacio(string $poblacio): ?string
{
    if ($poblacio === '') {
        return 'La població és obligatòria.';
    }
    if (mb_strlen($poblacio) < 2 || mb_strlen($poblacio) > 50) {
        return 'La població ha de tenir entre 2 i 50 caràcters.';
    }
    if (!preg_match(PATRO_LLETRES, $poblacio)) {
        return 'La població només pot tenir lletres, espais, apòstrofs i guions.';
    }
    return null;
}

// Posa en majúscula la primera lletra de cada paraula de la població.
// L'array de particules es per si alguna poblacio els porta, que no es podin en majuscules a no ser que siguin la priemra.
function normalitzarPoblacio(string $poblacio): string
{
    $particules = ['de', 'del', 'dels', 'la', 'les', 'el', 'els', 'i'];
    $paraules = explode(' ', mb_strtolower($poblacio));

    foreach ($paraules as $i => $paraula) {
        if (preg_match("/^([dl]['’])(.+)$/u", $paraula, $parts)) {
            $paraula = $parts[1] . majusculaInicial($parts[2]);
            if ($i === 0) {
                $paraula = majusculaInicial($paraula);
            }
        } elseif ($i === 0 || !in_array($paraula, $particules)) {
            $paraula = majusculaInicial($paraula);
        }
        $paraules[$i] = $paraula;
    }

    return implode(' ', $paraules);
}

// mb_* s'ha de fer servir per els accents
function majusculaInicial(string $text): string
{
    return mb_strtoupper(mb_substr($text, 0, 1)) . mb_substr($text, 1);
}
