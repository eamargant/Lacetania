/**
 * temporitzador.js
 * Compte enrere de la partida.
 */

let idInterval = null;
let segonsRestants = 0;

/**
 * Inicia un compte enrere (atura'n qualsevol d'anterior).
 * @param {number} segons Durada total
 * @param {function(number):void} onTick Es crida cada segon amb els segons restants
 * @param {function():void} onFi Es crida quan el temps arriba a 0
 */
export function iniciarTemporitzador(segons, onTick, onFi) {
    aturarTemporitzador();
    segonsRestants = segons;
    onTick(segonsRestants);

    idInterval = setInterval(() => {
        segonsRestants--;
        onTick(segonsRestants);

        if (segonsRestants <= 0) {
            aturarTemporitzador();
            onFi();
        }
    }, 1000);
}

/** Atura el compte enrere en curs (si n'hi ha). */
export function aturarTemporitzador() {
    clearInterval(idInterval);
    idInterval = null;
}

/** Retorna els segons que queden de partida. */
export function obtenirSegonsRestants() {
    return segonsRestants;
}

/**
 * Formata un nombre de segons com a mm:ss.
 * @param {number} segons
 * @returns {string}
 */
export function formatarTemps(segons) {
    const minuts = Math.floor(segons / 60);
    const seg = segons % 60;
    return `${String(minuts).padStart(2, '0')}:${String(seg).padStart(2, '0')}`;
}
