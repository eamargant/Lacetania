/*
 * Exercici 5 - dividirXDos i funció genèrica aplicaATots
 */

const dividirXDos = (num) => num / 2;

// Funció genèrica que retorna un nou array amb la funció qeu es vol aplicars a cada element
function aplicaATots(array, funcio) {
    const resultat = [];
    for (const element of array) {
        resultat.push(funcio(element));
    }
    return resultat;
}

const numeros = [10, 7, 42, 3, 100];
console.log("Original:", numeros);
console.log("Dividits per 2:", aplicaATots(numeros, dividirXDos));
