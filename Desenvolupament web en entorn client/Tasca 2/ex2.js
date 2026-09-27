/*
 * Exercici 2 - tractaAnys
 * Funció genèrica que rep un array d'anys de naixement i una funció
 * que tracta aquest array. 
 */
const anys = [1992, 1998, 2002, 2001, 2010];
const anyActual = new Date().getFullYear(); //PEr agafar l'any actual 
const MAJORIA_EDAT = 18;
const EDAT_JUBILACIO = 65;

// Funció genèrica
function tractaAnys(arrayAnys, funcioTracta) {
    return funcioTracta(arrayAnys);
}

function calculaEdats(arrayAnys) {
    const edats = [];
    for (const any of arrayAnys) {
        edats.push(anyActual - any);
    }
    return edats;
}

// Passem la funció utilitzant la genèrica
console.log("Edats:", tractaAnys(anys, calculaEdats));

// Funció anònima definida a la mateixa crida.
// Retorna true o false en funcio de si és major d'edat.
console.log("Majors d'edat:", tractaAnys(anys, function (arrayAnys) {
    const majors = [];
    for (const any of arrayAnys) {
        majors.push(anyActual - any >= MAJORIA_EDAT);
    }
    return majors;
}));

// Funció de fletxa definida a la mateixa crida.
// Retorna els anys que falten per jubilar-se, o -1 si ja ho  està.
console.log("Anys per jubilar-se:", tractaAnys(anys, (arrayAnys) => {
    const falten = [];
    for (const any of arrayAnys) {
        const edat = anyActual - any;
        falten.push(edat >= EDAT_JUBILACIO ? -1 : EDAT_JUBILACIO - edat);
    }
    return falten;
}));
