/*
 * Exercici 1 - posaGuionsEntreParells
 * Funció de fletxa que rep un nombre i insereix un guió (-) entre cada parell de xifres parelles.
 */

const posaGuionsEntreParells = (num) => {
    const xifres = String(num);

    // Agafem laprimera xifra per comparar
    let resultat = xifres[0];

    // Recorrem la resta comparant cada una amb l'anterior
    for (let i = 1; i < xifres.length; i++) {
        const anterior = Number(xifres[i - 1]);
        const actual = Number(xifres[i]);

        // Posem guip si son parelles
        if (anterior % 2 === 0 && actual % 2 === 0) {
            resultat += "-";
        }

        resultat += xifres[i];
    }

    return resultat;
};

console.log(posaGuionsEntreParells(225468)); 
console.log(posaGuionsEntreParells(8675309)); 
