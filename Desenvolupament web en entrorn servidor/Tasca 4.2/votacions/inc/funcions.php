<?php
require_once __DIR__ . '/vots.php';

/** Retorna l'usuari amb aquest email, o null si no existeix */
function buscaUsuari(array $usuaris, string $email): ?array {
    foreach ($usuaris as $usuari) {
        if ($usuari['email'] === $email) {
            return $usuari;
        }
    }
    return null;
}

/** Retorna "fa menys d'un minut", "fa 5 minuts", "fa 2 hores", "fa 3 dies"... */
function tempsDesDe(int $moment): string {
    $segons = time() - $moment;

    if ($segons < 60) {
        return "fa menys d'un minut";
    }

    $minuts = intdiv($segons, 60);
    if ($minuts < 60) {
        return $minuts == 1 ? 'fa 1 minut' : "fa $minuts minuts";
    }

    $hores = intdiv($minuts, 60);
    if ($hores < 24) {
        return $hores == 1 ? 'fa 1 hora' : "fa $hores hores";
    }

    $dies = intdiv($hores, 24);
    return $dies == 1 ? 'fa 1 dia' : "fa $dies dies";
}

/** Diu si encara no s'ha arribat a la data de tancament */
function votacioOberta(string $tancament): bool {
    return time() < strtotime($tancament);
}

/** Diu si l'email ja és al fitxer de vots */
function jaHaVotat(string $email): bool {
    $vots = llegeixVots();
    return isset($vots[$email]);
}

/** Retorna ['si' => 2, 'no' => 1, 'blanc' => 0], amb totes les opcions */
function recompte(array $vots, array $opcions): array {
    $resultat = [];
    foreach ($opcions as $clau => $text) {
        $resultat[$clau] = 0;
    }
    foreach ($vots as $email => $opcio) {
        if (isset($resultat[$opcio])) {
            $resultat[$opcio]++;
        }
    }
    return $resultat;
}

/** Guarda un missatge flash a la sessió */
function afegeixMissatge(string $text): void {
    $_SESSION['missatge'] = $text;
}

/** Retorna el missatge flash i l'esborra de la sessió */
function llegeixMissatge(): ?string {
    $missatge = $_SESSION['missatge'] ?? null;
    unset($_SESSION['missatge']);
    return $missatge;
}
