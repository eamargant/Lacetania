/**
 * main.js
 * Punt d'entrada: prepara la interfície i connecta els esdeveniments amb el joc.
 */

import { NIVELLS, PARELLES } from './config.js';
import { configurarJoc, iniciarPartida, partidaEnCurs, mostrarMissatge } from './joc.js';
import { pintarTaulerBuit } from './tauler.js';

// Referències als elements del DOM
const elements = {
    tauler: document.getElementById('tauler'),
    temps: document.getElementById('temps'),
    barraTemps: document.getElementById('barra-temps'),
    parelles: document.getElementById('parelles'),
    missatge: document.getElementById('missatge'),
    nivells: document.getElementById('nivells'),
    botoInici: document.getElementById('boto-inici'),
};

inicialitzar();

/** Prepara la pàgina en carregar-se. */
function inicialitzar() {
    configurarJoc(elements);
    pintarSelectorNivells();
    pintarTaulerBuit(elements.tauler, PARELLES * 2);
    elements.botoInici.addEventListener('click', onClicInici);
    mostrarMissatge('Tria la dificultat i prem Inici per començar.');
}

/** Crea un botó d'opció per a cada nivell de dificultat. */
function pintarSelectorNivells() {
    NIVELLS.forEach((nivell, index) => {
        const etiqueta = document.createElement('label');
        etiqueta.classList.add('nivell');

        const opcio = document.createElement('input');
        opcio.type = 'radio';
        opcio.name = 'nivell';
        opcio.value = nivell.id;
        opcio.checked = index === 0;

        // Nom del nivell i, a sota, el temps que dona
        const text = document.createElement('span');
        const temps = document.createElement('small');
        temps.textContent = `${nivell.segons / 60} min`;
        text.append(nivell.nom, temps);

        etiqueta.append(opcio, text);
        elements.nivells.appendChild(etiqueta);
    });
}

/** Retorna el nivell actualment seleccionat. */
function obtenirNivellSeleccionat() {
    const id = Number(document.querySelector('input[name="nivell"]:checked').value);
    return NIVELLS.find(nivell => nivell.id === id);
}

/**
 * Gestiona el botó Inici. Si hi ha una partida en curs, demana confirmació:
 * si l'usuari cancel·la, la partida continua tal com estava.
 */
async function onClicInici() {
    if (partidaEnCurs() && !confirm('Hi ha una partida en curs. Vols tornar a començar?')) {
        return;
    }

    elements.botoInici.disabled = true;
    try {
        await iniciarPartida(obtenirNivellSeleccionat());
    } catch (error) {
        console.error(error);
        mostrarMissatge(`No s'han pogut carregar les imatges: ${error.message}`, 'error');
    } finally {
        elements.botoInici.disabled = false;
    }
}
