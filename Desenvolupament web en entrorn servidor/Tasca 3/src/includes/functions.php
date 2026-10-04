<?php
/**
 * Escapa un text per mostrar-lo de forma segura dins l'HTML.
 *
 * @param mixed $text Valor a escapar (es converteix a string)
 * @return string Text escapat
 */
function e($text): string
{
    return htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
}

/**
 * Mostra una llista d'errors dins una alerta de Bootstrap.
 *
 * @param array $errors Llista de missatges d'error
 */
function mostrarErrors(array $errors): void
{
    if (empty($errors)) {
        return;
    }
    echo '<div class="alert alert-danger"><ul class="mb-0">';
    foreach ($errors as $error) {
        echo '<li>' . e($error) . '</li>';
    }
    echo '</ul></div>';
}

/**
 * Mostra un missatge d'èxit dins una alerta de Bootstrap.
 *
 * @param string $missatge Missatge a mostrar (buit = no mostra res)
 */
function mostrarExit(string $missatge): void
{
    if ($missatge !== '') {
        echo '<div class="alert alert-success">' . e($missatge) . '</div>';
    }
}

/* =========================================================
 * EXERCICI 1 - CAPITALS EUROPEES
 * ========================================================= */

/**
 * Retorna l'array ordenat per capital (A-Z), mantenint la relació país => capital.
 * L'array es rep per valor, així que l'original no es modifica.
 *
 * @param array $paisos [país => capital]
 * @return array Array ordenat per capital
 */
function ordenarPerCapital(array $paisos): array
{
    asort($paisos, SORT_STRING | SORT_FLAG_CASE);
    return $paisos;
}

/**
 * Cerca parcial i sense distingir majúscules pel nom del país o de la capital.
 *
 * @param array  $paisos [país => capital]
 * @param string $text   Text a cercar (buit = no filtra)
 * @return array Només les parelles que coincideixen
 */
function cercarPaisOCapital(array $paisos, string $text): array
{
    $text = trim($text);
    if ($text === '') {
        return $paisos;
    }
    return array_filter(
        $paisos,
        fn($capital, $pais) => stripos($pais, $text) !== false || stripos($capital, $text) !== false,
        ARRAY_FILTER_USE_BOTH
    );
}

/**
 * Filtra els països que comencen per una lletra.
 *
 * @param array  $paisos [país => capital]
 * @param string $lletra Lletra inicial del país (buit = totes)
 * @return array Països filtrats
 */
function filtrarPerLletra(array $paisos, string $lletra): array
{
    if ($lletra === '') {
        return $paisos;
    }
    return array_filter(
        $paisos,
        fn($pais) => strtoupper($pais[0]) === strtoupper($lletra),
        ARRAY_FILTER_USE_KEY
    );
}

/**
 * Retorna les lletres inicials dels països, sense repetir i ordenades.
 * Serveix per omplir el desplegable del filtre.
 *
 * @param array $paisos [país => capital]
 * @return array Llista de lletres
 */
function lletresInicials(array $paisos): array
{
    $lletres = [];
    foreach (array_keys($paisos) as $pais) {
        $lletres[] = strtoupper($pais[0]);
    }
    $lletres = array_unique($lletres);
    sort($lletres);
    return $lletres;
}

/**
 * Converteix Fahrenheit a Celsius.
 *
 * @param float $f Temperatura en °F
 * @return float Temperatura en °C
 */
function fahrenheitACelsius(float $f): float
{
    return round(($f - 32) * 5 / 9, 2);
}

/**
 * Temperatura (guardada en °F) a l'escala escollida.
 *
 * @param float  $f      Temperatura en °F
 * @param string $escala 'F' o 'C'
 * @return string Ex: "70.42°F" o "21.34°C"
 */
function formatTemperatura(float $f, string $escala): string
{
    $valor = $escala === 'C' ? fahrenheitACelsius($f) : $f;
    return number_format($valor, 2, '.', '') . '°' . $escala;
}

/**
 * Mitjana aritmètica.
 *
 * @param array $temps Llista de temperatures
 * @return float Mitjana (0 si la llista és buida)
 */
function calcularMitjana(array $temps): float
{
    if (empty($temps)) {
        return 0.0;
    }
    return array_sum($temps) / count($temps);
}

/**
 * Mediana: el valor central de la llista ordenada.
 * Si hi ha un nombre parell d'elements, és la mitjana dels dos centrals.
 *
 * @param array $temps Llista de temperatures
 * @return float Mediana (0 si la llista és buida)
 */
function calcularMediana(array $temps): float
{
    if (empty($temps)) {
        return 0.0;
    }
    sort($temps);
    $n = count($temps);
    $meitat = intdiv($n, 2);

    if ($n % 2 === 0) {
        return ($temps[$meitat - 1] + $temps[$meitat]) / 2;
    }
    return $temps[$meitat];
}

/**
 * Les temperatures més altes, ordenades de menor a major.
 *
 * @param array $temps Llista de temperatures
 * @param int   $n     Quantes en volem
 * @return array
 */
function temperaturesMesAltes(array $temps, int $n = 5): array
{
    sort($temps);
    return array_slice($temps, -$n);
}

/**
 * Les temperatures més baixes, ordenades de menor a major.
 *
 * @param array $temps Llista de temperatures
 * @param int   $n     Quantes en volem
 * @return array
 */
function temperaturesMesBaixes(array $temps, int $n = 5): array
{
    sort($temps);
    return array_slice($temps, 0, $n);
}

/**
 * Temperatura màxima.
 *
 * @param array $temps Llista de temperatures (no buida)
 * @return float
 */
function temperaturaMaxima(array $temps): float
{
    return max($temps);
}

/**
 * Temperatura mínima.
 *
 * @param array $temps Llista de temperatures (no buida)
 * @return float
 */
function temperaturaMinima(array $temps): float
{
    return min($temps);
}

/**
 * Valida una temperatura introduïda per l'usuari.
 *
 * @param mixed $valor Valor rebut del formulari
 * @return float|null La temperatura com a float, o null si no és vàlida
 */
function validarTemperatura($valor): ?float
{
    $temp = filter_var($valor, FILTER_VALIDATE_FLOAT);
    if ($temp === false || $temp < -100 || $temp > 200) {
        return null;
    }
    return $temp;
}


/**
 * Genera camps ocults per a un array (també niat) perquè es mantingui entre peticions.
 * Ex: campsOcults('parelles', ['first' => 'dinosaur'])
 *     -> <input type="hidden" name="parelles[first]" value="dinosaur">
 *
 * @param string $nom   Nom base del camp
 * @param array  $dades Array a desar
 * @return string HTML amb els inputs ocults
 */
function campsOcults(string $nom, array $dades): string
{
    $html = '';
    foreach ($dades as $clau => $valor) {
        $nomCamp = $nom . '[' . $clau . ']';
        if (is_array($valor)) {
            $html .= campsOcults($nomCamp, $valor);
        } else {
            $html .= '<input type="hidden" name="' . e($nomCamp) . '" value="' . e($valor) . '">' . "\n";
        }
    }
    return $html;
}

/**
 * Combina dos arrays fent servir bucles: els valors del primer passen a ser les claus.
 *
 * @param array $keys   Array amb les futures claus
 * @param array $values Array amb els futurs valors
 * @return array Array combinat
 * @throws InvalidArgumentException Si no tenen la mateixa mida
 */
function combinarAmbBucles(array $keys, array $values): array
{
    if (count($keys) !== count($values)) {
        throw new InvalidArgumentException('Els dos arrays han de tenir el mateix nombre d\'elements.');
    }
    // Les claus originals (field1, field1value...) no ens serveixen: ens quedem amb els valors
    $llistaClaus = array_values($keys);
    $llistaValors = array_values($values);

    $resultat = [];
    for ($i = 0; $i < count($llistaClaus); $i++) {
        $resultat[$llistaClaus[$i]] = $llistaValors[$i];
    }
    return $resultat;
}

/**
 * Combina dos arrays amb la funció nativa array_combine().
 *
 * @param array $keys   Array amb les futures claus
 * @param array $values Array amb els futurs valors
 * @return array Array combinat
 * @throws InvalidArgumentException Si no tenen la mateixa mida
 */
function combinarAmbArrayCombine(array $keys, array $values): array
{
    if (count($keys) !== count($values)) {
        throw new InvalidArgumentException('Els dos arrays han de tenir el mateix nombre d\'elements.');
    }
    return array_combine($keys, $values);
}

/**
 * Mostra un array associatiu en format PHP: ["a" => "b", ...]
 *
 * @param array $array Array associatiu
 * @return string
 */
function formatArrayAssociatiu(array $array): string
{
    $parts = [];
    foreach ($array as $clau => $valor) {
        $parts[] = '"' . $clau . '" => "' . $valor . '"';
    }
    return '[' . implode(', ', $parts) . ']';
}

/**
 * Comprova que una clau sigui vàlida: lletres, números, espais, _ o -, entre 1 i 30 caràcters.
 *
 * @param string $clau
 * @return bool
 */
function validarClau(string $clau): bool
{
    return preg_match('/^[\p{L}\p{N}_\- ]{1,30}$/u', $clau) === 1;
}

/**
 * Comprova que un valor no sigui buit i no superi els 50 caràcters.
 *
 * @param string $valor
 * @return bool
 */
function validarValor(string $valor): bool
{
    return $valor !== '' && mb_strlen($valor) <= 50;
}

/**
 * Afegeix una parella clau-valor nova.
 *
 * @throws InvalidArgumentException Si la clau ja existeix
 */
function afegirParella(array $parelles, string $clau, string $valor): array
{
    if (array_key_exists($clau, $parelles)) {
        throw new InvalidArgumentException("La clau \"$clau\" ja existeix.");
    }
    $parelles[$clau] = $valor;
    return $parelles;
}

/**
 * Modifica el valor d'una clau existent.
 *
 * @throws InvalidArgumentException Si la clau no existeix
 */
function modificarParella(array $parelles, string $clau, string $valor): array
{
    if (!array_key_exists($clau, $parelles)) {
        throw new InvalidArgumentException("La clau \"$clau\" no existeix.");
    }
    $parelles[$clau] = $valor;
    return $parelles;
}

/**
 * Elimina una parella a partir de la clau.
 *
 * @throws InvalidArgumentException Si la clau no existeix
 */
function eliminarParella(array $parelles, string $clau): array
{
    if (!array_key_exists($clau, $parelles)) {
        throw new InvalidArgumentException("La clau \"$clau\" no existeix.");
    }
    unset($parelles[$clau]);
    return $parelles;
}


/**
 * Crea la matriu buida: cada nivell té cada idioma amb una llista d'alumnes buida.
 *
 * @param array $nivells Ex: ['Bàsic', 'Mitjà', 'Perfeccionament']
 * @param array $idiomes Ex: ['Anglès', 'Francès', 'Alemany', 'Rus']
 * @return array
 */
function crearAcademiaBuida(array $nivells, array $idiomes): array
{
    $academia = [];
    foreach ($nivells as $nivell) {
        foreach ($idiomes as $idioma) {
            $academia[$nivell][$idioma] = [];
        }
    }
    return $academia;
}

/**
 * Comprova que un nom d'alumne sigui vàlid: lletres, espais, apòstrof o guió, de 2 a 40 caràcters.
 *
 * @param string $nom
 * @return bool
 */
function validarNomAlumne(string $nom): bool
{
    return preg_match("/^\p{L}[\p{L} '\-]{1,39}$/u", $nom) === 1;
}

/**
 * Reconstrueix la matriu a partir dels camps ocults rebuts, descartant tot el que no sigui vàlid.
 * Parteix d'una matriu buida, així els grups sense alumnes (que no envien cap camp) també existeixen.
 *
 * @param mixed $dades      Valor de $_POST['alumnes'] o $_GET['alumnes']
 * @param array $nivells
 * @param array $idiomes
 * @param int   $descartats Per referència: quants valors s'han descartat
 * @return array
 */
function reconstruirAcademia($dades, array $nivells, array $idiomes, int &$descartats = 0): array
{
    $academia = crearAcademiaBuida($nivells, $idiomes);
    $descartats = 0;

    foreach ((array) $dades as $nivell => $perIdioma) {
        foreach ((array) $perIdioma as $idioma => $noms) {
            if (!in_array($nivell, $nivells, true) || !in_array($idioma, $idiomes, true)) {
                $descartats++;
                continue;
            }
            foreach ((array) $noms as $nom) {
                if (!is_string($nom) || !validarNomAlumne($nom) || buscarGrupAlumne($academia, $nom) !== null) {
                    $descartats++;
                    continue;
                }
                $academia[$nivell][$idioma][] = $nom;
            }
        }
    }
    return $academia;
}

/**
 * Nombre total d'alumnes de l'acadèmia.
 *
 * @param array $academia
 * @return int
 */
function comptarTotalAlumnes(array $academia): int
{
    $total = 0;
    foreach ($academia as $perIdioma) {
        foreach ($perIdioma as $alumnes) {
            $total += count($alumnes);
        }
    }
    return $total;
}

/**
 * Nombre d'alumnes de cada idioma (sumant tots els nivells).
 *
 * @param array $academia
 * @return array [idioma => total]
 */
function comptarTotalPerIdioma(array $academia): array
{
    $totals = [];
    foreach ($academia as $perIdioma) {
        foreach ($perIdioma as $idioma => $alumnes) {
            $totals[$idioma] = ($totals[$idioma] ?? 0) + count($alumnes);
        }
    }
    return $totals;
}

/**
 * Nombre d'alumnes de cada nivell (sumant tots els idiomes).
 *
 * @param array $academia
 * @return array [nivell => total]
 */
function comptarTotalPerNivell(array $academia): array
{
    $totals = [];
    foreach ($academia as $nivell => $perIdioma) {
        $totals[$nivell] = 0;
        foreach ($perIdioma as $alumnes) {
            $totals[$nivell] += count($alumnes);
        }
    }
    return $totals;
}

/**
 * Busca el grup (nivell + idioma) amb més alumnes. En cas d'empat retorna el primer.
 *
 * @param array $academia
 * @return array ['nivell' => ..., 'idioma' => ..., 'total' => ...]
 */
function buscarGrupMesNombros(array $academia): array
{
    $millor = null;
    foreach ($academia as $nivell => $perIdioma) {
        foreach ($perIdioma as $idioma => $alumnes) {
            if ($millor === null || count($alumnes) > $millor['total']) {
                $millor = ['nivell' => $nivell, 'idioma' => $idioma, 'total' => count($alumnes)];
            }
        }
    }
    return $millor;
}

/**
 * Busca el grup (nivell + idioma) amb menys alumnes. En cas d'empat retorna el primer.
 *
 * @param array $academia
 * @return array ['nivell' => ..., 'idioma' => ..., 'total' => ...]
 */
function buscarGrupMenysNombros(array $academia): array
{
    $pitjor = null;
    foreach ($academia as $nivell => $perIdioma) {
        foreach ($perIdioma as $idioma => $alumnes) {
            if ($pitjor === null || count($alumnes) < $pitjor['total']) {
                $pitjor = ['nivell' => $nivell, 'idioma' => $idioma, 'total' => count($alumnes)];
            }
        }
    }
    return $pitjor;
}

/**
 * Mitjana d'alumnes per grup a cada nivell (total del nivell / nombre d'idiomes).
 *
 * @param array $academia
 * @return array [nivell => mitjana]
 */
function calcularMitjanaPerNivell(array $academia): array
{
    $mitjanes = [];
    foreach (comptarTotalPerNivell($academia) as $nivell => $total) {
        $mitjanes[$nivell] = $total / count($academia[$nivell]);
    }
    return $mitjanes;
}

/**
 * Mitjana d'alumnes per grup a cada idioma (total de l'idioma / nombre de nivells).
 *
 * @param array $academia
 * @return array [idioma => mitjana]
 */
function calcularMitjanaPerIdioma(array $academia): array
{
    $mitjanes = [];
    foreach (comptarTotalPerIdioma($academia) as $idioma => $total) {
        $mitjanes[$idioma] = $total / count($academia);
    }
    return $mitjanes;
}

/**
 * Troba el grup d'un alumne pel nom exacte (sense distingir majúscules).
 *
 * @param array  $academia
 * @param string $nom
 * @return array|null ['nivell' => ..., 'idioma' => ..., 'nom' => ...] o null si no hi és
 */
function buscarGrupAlumne(array $academia, string $nom): ?array
{
    foreach ($academia as $nivell => $perIdioma) {
        foreach ($perIdioma as $idioma => $alumnes) {
            foreach ($alumnes as $alumne) {
                if (mb_strtolower($alumne) === mb_strtolower($nom)) {
                    return ['nivell' => $nivell, 'idioma' => $idioma, 'nom' => $alumne];
                }
            }
        }
    }
    return null;
}

/**
 * Cerca alumnes pel nom (cerca parcial, sense distingir majúscules) i diu a quin grup pertanyen.
 *
 * @param array  $academia
 * @param string $text
 * @return array Llista de ['nom' => ..., 'nivell' => ..., 'idioma' => ...]
 */
function cercarAlumne(array $academia, string $text): array
{
    $resultats = [];
    foreach ($academia as $nivell => $perIdioma) {
        foreach ($perIdioma as $idioma => $alumnes) {
            foreach ($alumnes as $alumne) {
                if (mb_stripos($alumne, $text) !== false) {
                    $resultats[] = ['nom' => $alumne, 'nivell' => $nivell, 'idioma' => $idioma];
                }
            }
        }
    }
    return $resultats;
}

/**
 * Llista plana de tots els alumnes ordenada pel nom (per als desplegables).
 *
 * @param array $academia
 * @return array Llista de noms
 */
function llistarAlumnes(array $academia): array
{
    $noms = [];
    foreach ($academia as $perIdioma) {
        foreach ($perIdioma as $alumnes) {
            $noms = array_merge($noms, $alumnes);
        }
    }
    sort($noms, SORT_STRING | SORT_FLAG_CASE);
    return $noms;
}

/**
 * Afegeix un alumne a un grup. Els noms són únics a tota l'acadèmia.
 *
 * @throws InvalidArgumentException Si el grup no existeix, el nom no és vàlid o ja hi és
 */
function afegirAlumne(array $academia, string $nivell, string $idioma, string $nom): array
{
    if (!isset($academia[$nivell][$idioma])) {
        throw new InvalidArgumentException('El grup seleccionat no existeix.');
    }
    if (!validarNomAlumne($nom)) {
        throw new InvalidArgumentException('El nom ha de tenir entre 2 i 40 caràcters (lletres, espais, apòstrof o guió).');
    }
    $existent = buscarGrupAlumne($academia, $nom);
    if ($existent !== null) {
        throw new InvalidArgumentException("Ja hi ha un alumne \"{$existent['nom']}\" a {$existent['nivell']} - {$existent['idioma']}.");
    }
    $academia[$nivell][$idioma][] = $nom;
    return $academia;
}

/**
 * Elimina un alumne del grup on es troba.
 *
 * @throws InvalidArgumentException Si l'alumne no existeix
 */
function eliminarAlumne(array $academia, string $nom): array
{
    $grup = buscarGrupAlumne($academia, $nom);
    if ($grup === null) {
        throw new InvalidArgumentException("No s'ha trobat l'alumne \"$nom\".");
    }
    $alumnes = $academia[$grup['nivell']][$grup['idioma']];
    $posicio = array_search($grup['nom'], $alumnes, true);
    array_splice($alumnes, $posicio, 1);
    $academia[$grup['nivell']][$grup['idioma']] = $alumnes;
    return $academia;
}

/**
 * Mou un alumne al grup indicat.
 *
 * @throws InvalidArgumentException Si l'alumne o el grup destí no existeixen, o ja hi és
 */
function moureAlumne(array $academia, string $nom, string $nivellDesti, string $idiomaDesti): array
{
    $grup = buscarGrupAlumne($academia, $nom);
    if ($grup === null) {
        throw new InvalidArgumentException("No s'ha trobat l'alumne \"$nom\".");
    }
    if (!isset($academia[$nivellDesti][$idiomaDesti])) {
        throw new InvalidArgumentException('El grup destí no existeix.');
    }
    if ($grup['nivell'] === $nivellDesti && $grup['idioma'] === $idiomaDesti) {
        throw new InvalidArgumentException("{$grup['nom']} ja és al grup $nivellDesti - $idiomaDesti.");
    }
    $academia = eliminarAlumne($academia, $grup['nom']);
    $academia[$nivellDesti][$idiomaDesti][] = $grup['nom'];
    return $academia;
}
