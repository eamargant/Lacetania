/**
 * Servidor HTTP de Node.
 * Escolta al port 3000 i respon sempre en format JSON.
 *
 * Rutes:
 *   GET  /data                                      → data i hora actuals
 *   POST /usuari                                    → crea un usuari amb validació
 *   GET  /api/info                                  → informació del sistema
 *   GET  /api/calculadora/:operacio/:num1/:num2     → operacions bàsiques
 */

const http = require("http");

const PORT = 3000;
let seguentId = 1;

/**
 * Funció per resposta en format JSON.
 * @param {http.ServerResponse} res - objecte resposta
 * @param {number} status - codi d'estat HTTP (200, 201, 400, 404...)
 * @param {object} dades - objecte que es convertirà a JSON
 */
function enviarJSON(res, status, dades) {
  res.writeHead(status, { "Content-Type": "application/json; charset=utf-8" });
  res.end(JSON.stringify(dades, null, 2));
}

// Creem el servidor: aquesta funció s'executa a CADA petició que arriba
const server = http.createServer((req, res) => {
  const url = new URL(req.url, `http://${req.headers.host}`);
  const metode = req.method;

  console.log(`${metode} ${url.pathname}`);
  //Rutes
  if (metode === "GET" && url.pathname === "/data") {
    const ara = new Date();

    const dies = [
      "diumenge",
      "dilluns",
      "dimarts",
      "dimecres",
      "dijous",
      "divendres",
      "dissabte",
    ];

    return enviarJSON(res, 200, {
      data: ara.toLocaleDateString("sv-SE"), //AAAA-MM-DD
      hora: ara.toLocaleTimeString("ca-ES", { hour12: false }), //HH:MM:SS (24 h)
      timestamp: ara.getTime(),
      dia_setmana: dies[ara.getDay()], // getDay() retorna un número: 0 = diumenge, 1 = dilluns... 6 = dissabte i l'executem dins l'array
    });
  }
  if (metode === "POST" && url.pathname === "/usuari") {
    let body = "";

    req.on("data", (chunk) => {
      body += chunk;
    });

    // Quan ha arribat el body, el processem
    req.on("end", () => {
      let dades;
      try {
        dades = JSON.parse(body);
      } catch (e) {
        return enviarJSON(res, 400, { error: "JSON invàlid" });
      }

      if (!dades || typeof dades !== "object") {
        return enviarJSON(res, 400, {
          error: "El body ha de ser un objecte JSON",
        });
      }

      const errors = [];
      const nom = typeof dades.nom === "string" ? dades.nom.trim() : "";
      const email = typeof dades.email === "string" ? dades.email.trim() : "";

      if (nom.length < 2 || nom.length > 50) {
        errors.push("El nom ha de tenir entre 2 i 50 caràcters");
      } else if (!/^[A-Za-z ]+$/.test(nom)) {
        errors.push("El nom només pot contenir lletres sense accents i espais");
      }

      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        errors.push("Format d'email invàlid");
      }

      if (errors.length > 0) {
        return enviarJSON(res, 400, { error: "Dades invàlides", data: errors });
      }

      const usuari = {
        nom,
        email,
        id: seguentId++,
        creatEl: new Date().toISOString().replace(/\.\d{3}Z$/, "Z"),
      };
      return enviarJSON(res, 201, {
        missatge: "Usuari creat correctament",
        usuari,
      });
    });

    // La resposta s'envia dins de req.on('end'), per aixo hem de posar el return, si no es seguiria executant.
    return;
  }
  if (metode === "GET" && url.pathname === "/api/info") {
    return enviarJSON(res, 200, {
      servidor: "Node.js",
      versio: process.version,
      plataforma: process.platform,
      memoria_usada: process.memoryUsage(),
      temps_funcionament: Math.round(process.uptime()) + " segons",
    });
  }
  if (metode === "GET" && url.pathname.startsWith("/api/calculadora/")) {
    const parts = url.pathname.split("/");

    if (parts.length !== 6) {
      return enviarJSON(res, 400, {
        error: "Format: /api/calculadora/:operacio/:num1/:num2",
      });
    }

    const operacio = parts[3];
    const num1 = parseFloat(parts[4]); 
    const num2 = parseFloat(parts[5]);

    if (isNaN(num1) || isNaN(num2)) {
      return enviarJSON(res, 400, {
        error: "Els paràmetres num1 i num2 han de ser números",
      });
    }

    let resultat;
    let simbol;

    switch (operacio) {
      case "suma":
        resultat = num1 + num2;
        simbol = "+";
        break;
      case "resta":
        resultat = num1 - num2;
        simbol = "-";
        break;
      case "multiplicacio":
        resultat = num1 * num2;
        simbol = "*";
        break;
      case "divisio":
        if (num2 === 0) {
          return enviarJSON(res, 400, { error: "No es pot dividir per zero" });
        }
        resultat = num1 / num2;
        simbol = "/";
        break;
      default:
        return enviarJSON(res, 400, {
          error: "Operació no suportada",
          operacions_valides: ["suma", "resta", "multiplicacio", "divisio"],
        });
    }

    return enviarJSON(res, 200, {
      operacio,
      num1,
      num2,
      resultat,
      expressio: `${num1} ${simbol} ${num2} = ${resultat}`,
    });
  }

  enviarJSON(res, 404, { error: "Ruta no trobada", ruta: url.pathname });
});

server.listen(PORT, () => {
  console.log(`Servidor escoltant a http://localhost:${PORT}`);
});
