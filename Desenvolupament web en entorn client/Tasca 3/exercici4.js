// Fer un programa que:
// 1. demani 6 números per teclat i els posis en un array,
// 2. En una funció ha de mostrar tots els elements de l'array en el body amb una llista desordenada
//    (un a un "forEach") i en la consola (de cop),
// 3. Ordenar i mostrar l'array numèricament (reutilitzem el mostrar)
// 4. Girar l'array i mostra'l
// 5. Mostra quants elements té l'array
// 6. Fer una funció que permet cercar un valor introduït per l'usuari i retorni l'índex.
const demanaNumeros = (quantitat) =>
  Array.from({ length: quantitat }, (_, i) => Number(prompt(`Introdueix el número ${i + 1}:`)));

const mostrar = (arr, titol) => {
  const h2 = document.createElement('h2');
  h2.textContent = titol;
  document.body.appendChild(h2);

  const ul = document.createElement('ul');
  arr.forEach((n) => {
    const li = document.createElement('li');
    li.textContent = n;
    ul.appendChild(li);
  });
  document.body.appendChild(ul);

  console.log(titol, arr);
};

const mostrarText = (text) => {
  const p = document.createElement('p');
  p.textContent = text;
  document.body.appendChild(p);
  console.log(text);
};

const cercar = (arr, valor) => arr.indexOf(valor);

const numeros = demanaNumeros(6);
mostrar(numeros, 'Array introduït');

numeros.sort((a, b) => a - b);
mostrar(numeros, 'Array ordenat');

numeros.reverse();
mostrar(numeros, 'Array girat');

mostrarText(`L'array té ${numeros.length} elements.`);

const boto = document.createElement('button');
boto.textContent = 'Cercar un valor';
boto.addEventListener('click', () => {
  const valor = Number(prompt('Quin valor vols cercar?'));
  const index = cercar(numeros, valor);
  mostrarText(index !== -1 ? `El ${valor} és a l'índex ${index}.` : `El ${valor} no és a l'array.`);
});
document.body.appendChild(boto);
