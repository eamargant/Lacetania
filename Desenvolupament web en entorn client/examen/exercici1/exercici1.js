'use strict';

const esEnter = text => text !== null && text.trim() !== "" && !isNaN(text) && parseInt(text) == Number(text);

const idValid = text => text !== null && text.trim() !== "" && text.trim().length <= 4;

const descValida = text => text !== null && text.trim() !== "" && text.trim().length <= 50;

const horesValides = text => esEnter(text) && Number(text) >= 10 && Number(text) <= 40;

const notaValida = text => esEnter(text) && Number(text) >= 0 && Number(text) <= 10;

const numRAValid = text => esEnter(text) && Number(text) > 0;


const demanar = (missatge, validador, error) => {
    let valor = prompt(missatge);
    while (!validador(valor)) {
        alert(error);
        valor = prompt(missatge);
    }
    return valor.trim();
};

const numRA = Number(demanar("Quants RA's té el mòdul?", numRAValid,
    "Has d'introduir un número enter més gran que 0."));


const ras = [];

for (let i = 1; i <= numRA; i++) {
    const id = demanar(`RA ${i}/${numRA} - Identificador (màx. 4 caràcters):`, idValid,
        "L'identificador no pot estar buit ni tenir més de 4 caràcters.");
    const descripcio = demanar(`RA ${i}/${numRA} - Descripció (màx. 50 caràcters):`, descValida,
        "La descripció no pot estar buida ni tenir més de 50 caràcters.");
    const hores = Number(demanar(`RA ${i}/${numRA} - Hores assignades (de 10 a 40):`, horesValides,
        "Les hores han de ser un número enter entre 10 i 40."));
    const nota = Number(demanar(`RA ${i}/${numRA} - Nota (enter del 0 al 10):`, notaValida,
        "La nota ha de ser un número enter (sense decimals) entre 0 i 10."));

    ras.push({ id: id, descripcio: descripcio, hores: hores, nota: nota });
}

const literal = nota => nota >= 9 ? "A" : nota >= 7 ? "B" : nota >= 5 ? "C" : "D";

const mitjanaPonderada = llista =>
    llista.reduce((ac, ra) => ac + ra.nota * ra.hores, 0) /
    llista.reduce((ac, ra) => ac + ra.hores, 0);


const ordenar = (llista, descendent) =>
    [...llista].sort((a, b) => descendent ? b.nota - a.nota : a.nota - b.nota);

let descendent = true; 

const pintar = () => {
    const mitjana = mitjanaPonderada(ras);

    const files = ordenar(ras, descendent).map(ra => `
        <tr>
            <td>${ra.id}</td>
            <td>${ra.descripcio}</td>
            <td>${ra.hores} h</td>
            <td>${ra.nota}</td>
            <td class="lletra">${literal(ra.nota)}</td>
        </tr>`).join("");

    document.getElementById("resultat").innerHTML = `
        <table>
            <thead>
                <tr>
                    <th>RA</th>
                    <th>Descripció</th>
                    <th>Hores</th>
                    <th>Nota</th>
                    <th>Literal</th>
                </tr>
            </thead>
            <tbody>${files}</tbody>
            <tfoot>
                <tr>
                    <td colspan="3">Mitjana ponderada</td>
                    <td>${mitjana.toFixed(2)}</td>
                    <td class="lletra">${literal(mitjana)}</td>
                </tr>
            </tfoot>
        </table>`;
};

document.getElementById("ordre").addEventListener("click", () => {
    descendent = !descendent;
    pintar();
});

pintar();
