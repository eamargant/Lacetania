/**
 * imatges.js
 * Obtenció d'imatges úniques des de Picsum (https://picsum.photos).
 */

import { MIDA_IMATGE } from './config.js';
import { barrejar } from './tauler.js';

// Picsum té ~1000 imatges; amb 10 pàgines de 100 en cobrim la majoria
const PAGINES_PICSUM = 10;
const IMATGES_PER_PAGINA = 100;

/**
 * Retorna una llista d'URLs d'imatges de Picsum, totes diferents entre si.
 * Es fa servir l'API de llistat per treballar amb ids que existeixen de veritat
 * i, en barrejar-los i agafar-ne els primers, es garanteix que no es repeteixen.
 * @param {number} quantitat Nombre d'imatges diferents que es volen
 * @returns {Promise<string[]>} URLs de les imatges, ja precarregades
 */
export async function obtenirImatges(quantitat) {
    const ids = await obtenirIdsAleatoris(quantitat);
    const urls = ids.map(id => `https://picsum.photos/id/${id}/${MIDA_IMATGE}/${MIDA_IMATGE}`);
    await precarregarImatges(urls);
    return urls;
}

/**
 * Demana una pàgina aleatòria del llistat de Picsum i en tria ids sense repetir.
 * @param {number} quantitat Nombre d'ids que es volen
 * @returns {Promise<string[]>}
 */
async function obtenirIdsAleatoris(quantitat) {
    const pagina = Math.floor(Math.random() * PAGINES_PICSUM) + 1;
    const resposta = await fetch(`https://picsum.photos/v2/list?page=${pagina}&limit=${IMATGES_PER_PAGINA}`);

    if (!resposta.ok) {
        throw new Error(`Error en contactar amb Picsum (${resposta.status})`);
    }

    const llista = await resposta.json();
    if (llista.length < quantitat) {
        throw new Error('Picsum no ha retornat prou imatges');
    }

    return barrejar(llista.map(imatge => imatge.id)).slice(0, quantitat);
}

/**
 * Carrega totes les imatges al navegador abans de començar la partida,
 * perquè en destapar una casella la imatge aparegui a l'instant.
 * @param {string[]} urls
 * @returns {Promise<void[]>}
 */
function precarregarImatges(urls) {
    return Promise.all(urls.map(url => new Promise((resolve, reject) => {
        const img = new Image();
        img.onload = () => resolve();
        img.onerror = () => reject(new Error(`No s'ha pogut carregar ${url}`));
        img.src = url;
    })));
}
