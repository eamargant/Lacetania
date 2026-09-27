/*
 * Exercici 3 - ordenaCadena
 * Funció que rep una cadena de text i la retorna ordenada alfabèticament.
 *   split('') -> converteix la cadena en un array de caràcters
 *   sort()    -> ordena els caràcters alfabèticament
 *   join('')  -> torna a unir els caràcters en una cadena
 */

const ordenaCadena = (text) => text.split('').sort().join('');

console.log(ordenaCadena("abska")); 
