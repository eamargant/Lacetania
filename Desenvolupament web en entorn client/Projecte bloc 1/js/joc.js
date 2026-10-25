/**
 * joc.js
 * Estat i lògica d'una partida de Memory.
 */

import { PARELLES, TEMPS_GIR, DURADA_EFECTE_ERROR } from './config.js';
import { obtenirImatges } from './imatges.js';
import {
    crearParelles, pintarTauler, destapar, tapar, marcarEncertada, marcarError,
    estaDestapada, revelarTot, bloquejarTauler,
} from './tauler.js';
import {
    iniciarTemporitzador, aturarTemporitzador, obtenirSegonsRestants, formatarTemps,
} from './temporitzador.js';

// Estat de la partida
const estat = {
    enCurs: false,        // hi ha una partida activa
    seleccionades: [],    // caselles destapades al torn actual (màx. 2)
    parellesTrobades: 0,
    bloquejat: false,     // true mentre s'esperen a tapar dues caselles fallades
    idTimeoutGir: null,   // timeout pendent per tapar caselles
    segonsTotals: 0,      // durada de la partida segons el nivell
};

// Elements de la interfície que el joc necessita actualitzar
let ui = null;

/**
 * Guarda les referències als elements de la interfície.
 * @param {{tauler: HTMLElement, temps: HTMLElement, barraTemps: HTMLElement, parelles: HTMLElement, missatge: HTMLElement}} elements
 */
export function configurarJoc(elements) {
    ui = elements;
}

/** Indica si hi ha una partida en curs. */
export function partidaEnCurs() {
    return estat.enCurs;
}

/**
 * Comença una partida nova: obté imatges, reparteix el tauler i engega el temporitzador.
 * @param {{nom: string, segons: number}} nivell Nivell de dificultat escollit
 */
export async function iniciarPartida(nivell) {
    reiniciarEstat();
    mostrarMissatge('Carregant imatges...');

    const imatges = await obtenirImatges(PARELLES);
    const cartes = crearParelles(imatges);

    pintarTauler(ui.tauler, cartes, onClicCasella);
    actualitzarParelles();
    mostrarMissatge(`Nivell ${nivell.nom.toLowerCase()}: tens ${nivell.segons / 60} min.`);

    estat.enCurs = true;
    estat.segonsTotals = nivell.segons;
    iniciarTemporitzador(nivell.segons, actualitzarTemps, () => finalitzarPartida(false));
}

/** Deixa l'estat net i atura qualsevol temporitzador de la partida anterior. */
function reiniciarEstat() {
    aturarTemporitzador();
    clearTimeout(estat.idTimeoutGir);
    estat.enCurs = false;
    estat.seleccionades = [];
    estat.parellesTrobades = 0;
    estat.bloquejat = false;
    estat.idTimeoutGir = null;
}

/**
 * Gestiona el clic sobre una casella.
 * @param {HTMLElement} casella
 */
function onClicCasella(casella) {
    // S'ignoren clics si no es pot jugar o si la casella ja està destapada
    if (!estat.enCurs || estat.bloquejat || estaDestapada(casella)) return;

    destapar(casella);
    estat.seleccionades.push(casella);

    if (estat.seleccionades.length === 2) {
        comprovarParella();
    }
}

/** Compara les dues caselles seleccionades i actua segons si coincideixen. */
function comprovarParella() {
    const [primera, segona] = estat.seleccionades;

    if (primera.dataset.imatge === segona.dataset.imatge) {
        gestionarEncert(primera, segona);
    } else {
        gestionarError(primera, segona);
    }
}

/** Les dues caselles coincideixen: queden destapades. */
function gestionarEncert(primera, segona) {
    marcarEncertada(primera);
    marcarEncertada(segona);
    estat.seleccionades = [];
    estat.parellesTrobades++;
    actualitzarParelles();

    if (estat.parellesTrobades === PARELLES) {
        finalitzarPartida(true);
    }
}

/** Les dues caselles no coincideixen: efecte d'error i es tapen al cap de TEMPS_GIR ms. */
function gestionarError(primera, segona) {
    estat.bloquejat = true;
    bloquejarTauler(ui.tauler, true);
    marcarError(primera, DURADA_EFECTE_ERROR);
    marcarError(segona, DURADA_EFECTE_ERROR);

    estat.idTimeoutGir = setTimeout(() => {
        tapar(primera);
        tapar(segona);
        estat.seleccionades = [];
        estat.bloquejat = false;
        bloquejarTauler(ui.tauler, false);
    }, TEMPS_GIR);
}

/**
 * Acaba la partida, per victòria o perquè s'ha esgotat el temps.
 * @param {boolean} guanyat
 */
function finalitzarPartida(guanyat) {
    estat.enCurs = false;
    aturarTemporitzador();
    clearTimeout(estat.idTimeoutGir);
    bloquejarTauler(ui.tauler, true);

    if (guanyat) {
        mostrarMissatge(`Totes les parelles trobades, amb ${formatarTemps(obtenirSegonsRestants())} de marge. Prem Inici per tornar a jugar.`, 'exit');
    } else {
        revelarTot(ui.tauler);
        mostrarMissatge(`S'ha acabat el temps: has trobat ${estat.parellesTrobades} de ${PARELLES} parelles. Prem Inici per tornar-ho a provar.`, 'error');
    }
}

/** Actualitza el marcador de temps i la barra que es buida. */
function actualitzarTemps(segons) {
    const pocTemps = segons <= 10;
    ui.temps.textContent = formatarTemps(segons);
    ui.temps.classList.toggle('poc-temps', pocTemps);
    ui.barraTemps.classList.toggle('poc-temps', pocTemps);
    ui.barraTemps.style.setProperty('--progres', segons / estat.segonsTotals);
}

/** Actualitza el comptador de parelles trobades. */
function actualitzarParelles() {
    ui.parelles.textContent = `${estat.parellesTrobades} / ${PARELLES}`;
}

/**
 * Mostra un missatge a l'usuari.
 * @param {string} text
 * @param {'info'|'exit'|'error'} tipus Classe CSS del missatge
 */
export function mostrarMissatge(text, tipus = 'info') {
    ui.missatge.textContent = text;
    ui.missatge.className = `missatge ${tipus}`;
}
