/**
 * tauler.js
 * Funcions per crear, pintar i manipular les caselles del tauler.
 * Els estats de cada casella es controlen exclusivament amb classes CSS:
 *   - tapada:     la imatge no es veu
 *   - destapada:  la imatge es veu (selecció en curs)
 *   - encertada:  forma part d'una parella trobada
 *   - revelada:   es mostra en acabar la partida per temps
 */

/**
 * Barreja un array amb l'algorisme de Fisher-Yates (retorna una còpia).
 * @param {Array} array
 * @returns {Array}
 */
export function barrejar(array) {
    const copia = [...array];
    for (let i = copia.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [copia[i], copia[j]] = [copia[j], copia[i]];
    }
    return copia;
}

/**
 * Duplica cada imatge per formar les parelles i les barreja.
 * @param {string[]} urls Imatges úniques
 * @returns {string[]} Llista amb cada imatge dues vegades, en ordre aleatori
 */
export function crearParelles(urls) {
    return barrejar([...urls, ...urls]);
}

/**
 * Pinta totes les caselles al contenidor del tauler.
 * @param {HTMLElement} tauler Contenidor del tauler
 * @param {string[]} cartes URLs de les imatges en l'ordre en què s'han de col·locar
 * @param {function(HTMLElement):void} onClic Funció a cridar en clicar una casella
 */
export function pintarTauler(tauler, cartes, onClic) {
    tauler.innerHTML = '';
    tauler.classList.remove('bloquejat');

    cartes.forEach((url, index) => {
        const casella = crearCasella(url, index);
        casella.addEventListener('click', () => onClic(casella));
        casella.addEventListener('keydown', (event) => {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                onClic(casella);
            }
        });
        tauler.appendChild(casella);
    });
}

/**
 * Pinta caselles tapades sense imatge, per mostrar el tauler abans de començar.
 * @param {HTMLElement} tauler Contenidor del tauler
 * @param {number} quantitat Nombre de caselles
 */
export function pintarTaulerBuit(tauler, quantitat) {
    tauler.innerHTML = '';
    tauler.classList.add('bloquejat');

    for (let i = 0; i < quantitat; i++) {
        const casella = document.createElement('div');
        casella.classList.add('casella', 'tapada', 'buida');
        casella.innerHTML = '<div class="interior"><div class="cara dors"></div></div>';
        tauler.appendChild(casella);
    }
}

/**
 * Crea l'element HTML d'una casella (tapada per defecte).
 * Té dues cares: el dors (visible quan està tapada) i el davant (la imatge).
 * És focusable i es pot destapar amb Enter o Espai.
 * @param {string} url Imatge de la casella
 * @param {number} index Posició al tauler
 * @returns {HTMLElement}
 */
function crearCasella(url, index) {
    const casella = document.createElement('div');
    casella.classList.add('casella', 'tapada');
    casella.dataset.imatge = url;
    casella.dataset.index = index;
    casella.tabIndex = 0;
    casella.setAttribute('role', 'button');
    casella.setAttribute('aria-label', `Casella ${index + 1}`);

    const interior = document.createElement('div');
    interior.classList.add('interior');

    const dors = document.createElement('div');
    dors.classList.add('cara', 'dors');

    const davant = document.createElement('div');
    davant.classList.add('cara', 'davant');
    const img = document.createElement('img');
    img.src = url;
    img.alt = 'Imatge de la casella';
    img.draggable = false;
    davant.appendChild(img);

    interior.append(dors, davant);
    casella.appendChild(interior);
    return casella;
}

/** Mostra la imatge d'una casella. */
export function destapar(casella) {
    casella.classList.replace('tapada', 'destapada');
}

/** Amaga la imatge d'una casella (i treu la marca d'error si en tenia). */
export function tapar(casella) {
    casella.classList.replace('destapada', 'tapada');
    casella.classList.remove('error');
}

/**
 * Marca una casella com a part d'una parella fallada: el CSS hi aplica
 * un sacseig i el marc vermell durant el temps indicat.
 * @param {HTMLElement} casella
 * @param {number} durada Durada de l'efecte en ms
 */
export function marcarError(casella, durada) {
    casella.style.setProperty('--durada-error', `${durada}ms`);
    casella.classList.add('error');
}

/** Marca una casella com a part d'una parella trobada. */
export function marcarEncertada(casella) {
    casella.classList.add('encertada');
}

/** Indica si una casella ja està destapada (o encertada). */
export function estaDestapada(casella) {
    return casella.classList.contains('destapada');
}

/**
 * Destapa totes les caselles que encara estaven tapades (fi de partida per temps).
 * @param {HTMLElement} tauler
 */
export function revelarTot(tauler) {
    tauler.querySelectorAll('.casella.tapada').forEach(casella => {
        casella.classList.replace('tapada', 'destapada');
        casella.classList.add('revelada');
    });
}

/** Impedeix (o permet) interactuar amb el tauler. */
export function bloquejarTauler(tauler, bloquejat) {
    tauler.classList.toggle('bloquejat', bloquejat);
}
