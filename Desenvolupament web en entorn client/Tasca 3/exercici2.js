// Fes una funció en javascript que donat un array numèric, i utilitzant funcions de fletxa:
//una funció que mostra quins nombres senars hi ha
//una funció que retorna la mitjana de tots els elements de l’array
//una funció que retorna el més gran (passeu una funció al sort)
//una funció que retorna el més petit (passeu una funció al sort)
const mostraSenars = (arr) => console.log('senars =>', arr.filter((n) => n % 2 !== 0)); //el modul d'un numero senar negatiu retornaria -1, si posesim 1 no l'agafaria 

const mitjana = (arr) => arr.reduce((suma, n) => suma + n, 0) / arr.length;

const mesGran = (arr) => arr.sort((a, b) => b - a)[0];

const mesPetit = (arr) => arr.sort((a, b) => a - b)[0];

const numeros = [7, 2, 15, -4, 10, 3, 8, 21];
console.log('array =>', numeros);
mostraSenars(numeros);
console.log('mitjana =>', mitjana(numeros));
console.log('més gran =>', mesGran(numeros));
console.log('més petit =>', mesPetit(numeros));
