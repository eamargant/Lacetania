// Donat un array multidimensional, on cada element és un array de tres elements:
// a. Preu Unitari  b. Unitats  c. IVA          Exemple: [[100,10,0.10], [200,1,0.21], … ]
// Fes una funció que genera l’array de 100 elements amb dades aleatòries
// (imports entre 1 i 1000, IVA 10% o 21%, i quantitats entre 1 i 10).
// Fes un script que:
// - Generi un array amb els imports finals ((Preu unitari + IVA) * Unitats)
// - Generi un array amb l’IVA (Preu unitari * IVA)
// - Generi un array amb el PVP unitari amb IVA (Preu Unitari + IVA)
// - Calculi l’import total
// - Calculi l’import de l’IVA total i desglossat per IVA de 10% i 21%
const aleatori = (min, max) => Math.floor(Math.random() * (max - min + 1)) + min; //el +1 es per que el maxim pugui sortir tambe i el floor es per que surtin enters

const generaDades = (quantitat) =>
  Array.from({ length: quantitat }, () => [
    aleatori(1, 1000),
    aleatori(1, 10),
    Math.random() < 0.5 ? 0.10 : 0.21,
  ]);

const ivaUnitari = ([preu, , iva]) => preu * iva;
const pvpUnitari = (linia) => linia[0] + ivaUnitari(linia);
const importFinal = (linia) => pvpUnitari(linia) * linia[1];

const suma = (arr) => arr.reduce((total, n) => total + n, 0);
const dosDecimals = (arr) => arr.map((n) => n.toFixed(2));

const dades = generaDades(100);

const imports = dades.map(importFinal);
const ivas = dades.map(ivaUnitari);
const pvps = dades.map(pvpUnitari);

const importTotal = suma(imports);

const [iva10, iva21, ivaTotal] = dades.reduce(([i10, i21, total], linia) => {
  const iva = ivaUnitari(linia) * linia[1];
  return linia[2] === 0.10 ? [i10 + iva, i21, total + iva] : [i10, i21 + iva, total + iva];
}, [0, 0, 0]);

console.log('Dades [preu, unitats, iva] =>', dades);
console.log('Imports finals =>', dosDecimals(imports));
console.log('IVA unitari =>', dosDecimals(ivas));
console.log('PVP unitari amb IVA =>', dosDecimals(pvps));
console.log('Import total =>', importTotal.toFixed(2));
console.log('IVA 10% =>', iva10.toFixed(2));
console.log('IVA 21% =>', iva21.toFixed(2));
console.log('IVA total =>', ivaTotal.toFixed(2));
