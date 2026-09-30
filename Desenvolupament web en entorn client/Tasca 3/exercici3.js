// Fes una funció en javascript que donat un array retorni quin és l’element que té més repeticions.
// Com a restricció sols podeu utilitzar les funcions map, filter, sort i indexOf
// Sortida a - 5 vegades.
const mesRepetit = (arr) => {
  const unics = arr.filter((el, i) => arr.indexOf(el) === i);
  const comptador = unics.map((el) => [el, arr.filter((x) => x === el).length]);
  return comptador.sort((a, b) => b[1] - a[1])[0];
};

const dades = [3, 'a', 'a', 'a', 2, 3, 'a', 3, 'a', 2, 4, 9, 3];
const [element, vegades] = mesRepetit(dades);
console.log(`${element} - ${vegades} vegades.`);
