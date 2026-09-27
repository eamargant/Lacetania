/*
 * Exercici 4 - Conversió d'euros a altres monedes
 * Donada una quantitat d'euros, retorna el seu valor en tres monedes.

 */

// Constants per fer el canvi de moneda
const CANVI_USD = 1.17;
const CANVI_GBP = 0.86;
const CANVI_JPY = 172;

// Funcions de fletxa que converteixen euros a cada moneda, el toFixed es per que surti amb dos dcimals
const aDolars = (euros) => Number((euros * CANVI_USD).toFixed(2));
const aLliures = (euros) => Number((euros * CANVI_GBP).toFixed(2));
const aIens = (euros) => Number((euros * CANVI_JPY).toFixed(2));

// Funció principal que retorna els valors de les tres monedes
const convertirEuros = (euros) => ({
    dolars: aDolars(euros),
    lliures: aLliures(euros),
    iens: aIens(euros),
});
console.log("100 € ->", convertirEuros(100));
console.log("25.5 € ->", convertirEuros(25.5));
