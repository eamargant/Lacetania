/**
 * Endpoints:
 *   GET    /api/productes        → llista tots els productes
 *   GET    /api/productes/:id    → retorna un producte
 *   POST   /api/productes        → crea un producte
 *   PUT    /api/productes/:id    → actualitza un producte
 *   DELETE /api/productes/:id    → elimina un producte
 */

const express = require("express"); //framework Express
const app = express(); // el nostre servidor
const PORT = 3000; 

// express.json() llegeix el body de les peticions que arriben en JSON
// i les converteix en un objecte JS.
app.use(express.json());

// Array de dades inicials
let productes = [
  {
    id: 1,
    nom: "Impresora 3D",
    preu: 999.99,
    categoria: "Informàtica",
    stock: 100,
  },
  {
    id: 2,
    nom: "Ratolí inalambric",
    preu: 29.99,
    categoria: "Accessoris",
    stock: 25,
  },
];

// Comptador per generar ids.
let seguentId = 3;

/**
 * Llegeix l'id de la URL (req.params.id) i el converteix a número.
 * Retorna el número si és un enter vàlid, o null si no.
 */
function obtenirId(req) {
  const id = Number(req.params.id);
  return Number.isInteger(id) ? id : null;
}

//retorna tots els productes (200).
app.get("/api/productes", (req, res) => {
  res.status(200).json({
    estat: "success",
    data: productes,
  });
});

//retorna un producte concret.
app.get("/api/productes/:id", (req, res) => {
  const id = obtenirId(req);

  if (id === null) {
    return res.status(400).json({
      estat: "error",
      missatge: "L'id ha de ser un número enter",
    });
  }

  // find() retorna el primer producte que compleix la condició, o undefined si no en troba cap
  const producte = productes.find((p) => p.id === id);

  // 404: l'id és vàlid però no hi ha cap producte amb aquest id
  if (!producte) {
    return res.status(404).json({
      estat: "error",
      missatge: "Producte no trobat",
    });
  }

  // 200: hem trobat el producte
  res.status(200).json({
    estat: "success",
    data: producte,
  });
});

/**
 * Valida les dades d'un producte, comprova tots els camps i retorna un array amb tots els errors trobats.
 * Si l'array torna buit, totes les dades són correctes.
 */
function validarProducte(body) {
  const errors = [];

  if (typeof body !== "object" || body === null || Array.isArray(body)) {
    errors.push("El cos de la petició ha de ser un objecte JSON");
    return errors;
  }

  const { nom, preu, categoria, stock } = body; 

  if (typeof nom !== "string" || nom.trim() === "") {
    errors.push("El nom no pot estar buit");
  }

  if (typeof preu !== "number" || !Number.isFinite(preu) || preu <= 0) {
    errors.push("El preu ha de ser un número positiu");
  }

  if (typeof categoria !== "string" || categoria.trim() === "") {
    errors.push("La categoria no pot estar buida");
  }

  if (!Number.isInteger(stock) || stock < 0) {
    errors.push("L'stock ha de ser un número enter positiu o zero");
  }

  return errors;
}

//crea un producte nou o retorna 400 si les dades no són vàlides.
app.post("/api/productes", (req, res) => {
  const errors = validarProducte(req.body);
  if (errors.length > 0) {
    return res.status(400).json({
      estat: "error",
      missatge: "Dades invàlides",
      detalls: errors,
    });
  }

  const { nom, preu, categoria, stock } = req.body;

  const nouProducte = {
    id: seguentId++,
    nom: nom.trim(), 
    preu,
    categoria: categoria.trim(),
    stock,
  };

  productes.push(nouProducte); 

  res.status(201).json({
    estat: "success",
    missatge: "Producte creat correctament",
    data: nouProducte,
  });
});

//actualitza un producte sencer, o retorna 400 / 404.
app.put("/api/productes/:id", (req, res) => {
  const id = obtenirId(req);

  if (id === null) {
    return res.status(400).json({
      estat: "error",
      missatge: "L'id ha de ser un número enter",
    });
  }

  const index = productes.findIndex((p) => p.id === id);

  if (index === -1) {
    return res.status(404).json({
      estat: "error",
      missatge: "Producte no trobat",
    });
  }

  const errors = validarProducte(req.body);
  if (errors.length > 0) {
    return res.status(400).json({
      estat: "error",
      missatge: "Dades invàlides",
      detalls: errors,
    });
  }

  const { nom, preu, categoria, stock } = req.body;

  const producteActualitzat = {
    id,
    nom: nom.trim(),
    preu,
    categoria: categoria.trim(),
    stock,
  };

  productes[index] = producteActualitzat; 

  res.status(200).json({
    estat: "success",
    missatge: "Producte actualitzat correctament",
    data: producteActualitzat,
  });
});

//elimina un producte, o retorna 400 / 404.
app.delete("/api/productes/:id", (req, res) => {
  const id = obtenirId(req);

  if (id === null) {
    return res.status(400).json({
      estat: "error",
      missatge: "L'id ha de ser un número enter",
    });
  }

  const index = productes.findIndex((p) => p.id === id);

  if (index === -1) {
    return res.status(404).json({
      estat: "error",
      missatge: "Producte no trobat",
    });
  }

  const producteEliminat = productes.splice(index, 1)[0];
  res.status(200).json({
    estat: "success",
    missatge: "Producte eliminat correctament",
    data: producteEliminat,
  });
});

// Aixo va despres de les rutes anteriors per que si una petició arriba fins aquí
// vol dir que cap ruta anterior l'ha atesa, i per tant 404.
app.use((req, res) => {
  res.status(404).json({
    estat: "error",
    missatge: "Ruta no trobada",
    ruta: req.originalUrl, 
  });
});

// Express sap que és el gestor d'errors per que te 4 paràmetres.
app.use((err, req, res, next) => {
  // 400: JSON mal format 
  if (err.type === "entity.parse.failed") {
    return res.status(400).json({
      estat: "error",
      missatge: "El JSON enviat no és vàlid",
    });
  }

  // 500: qualsevol altre error.
  console.error(err);
  res.status(500).json({
    estat: "error",
    missatge: "Error intern del servidor",
  });
});

app.listen(PORT, () => {
  console.log(`Servidor escoltant a http://localhost:${PORT}`);
});
