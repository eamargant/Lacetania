// Escriviu una funció que elimini de l’array tots els elements innecessaris, 
// com ara cadenes buides, falses, indefinides, zero, nul·les
const netejaArray = (arr) => arr.filter(Boolean);

const dades = [0, 1, false, 2, undefined, '', 3, null];
console.log(dades, 'dades netejades =>', netejaArray(dades));
