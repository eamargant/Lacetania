/**
 * config.js
 * Constants de configuració del joc Memory.
 */

// Dimensions del tauler (6 columnes x 4 files = 24 caselles)
export const COLUMNES = 6;
export const FILES = 4;

// Nombre de parelles necessàries per omplir el tauler
export const PARELLES = (COLUMNES * FILES) / 2;

// Temps (ms) que es mostren dues caselles que no coincideixen abans de tapar-les
export const TEMPS_GIR = 1000;

// Durada (ms) de l'efecte d'error (sacseig + marc vermell): un terç del temps
// que les caselles es mostren, perquè no duri tota l'estona que estan girades
export const DURADA_EFECTE_ERROR = TEMPS_GIR / 3;

// Mida (px) de les imatges que es demanen a Picsum
export const MIDA_IMATGE = 200;

// Nivells de dificultat: a més nivell, menys temps de joc (en segons)
export const NIVELLS = [
    { id: 1, nom: 'Molt fàcil', segons: 5 * 60 },
    { id: 2, nom: 'Fàcil', segons: 4 * 60 },
    { id: 3, nom: 'Normal', segons: 3 * 60 },
    { id: 4, nom: 'Difícil', segons: 2 * 60 },
    { id: 5, nom: 'Expert', segons: 1 * 60 },
];
