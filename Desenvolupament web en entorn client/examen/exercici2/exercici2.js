'use strict';
// Tots els paràgrafs del text
const paragrafs = Array.from(document.querySelectorAll("p"));

// Guardem el text original amb el map
const originals = paragrafs.map(p => p.innerHTML);

const canviaVocals = (text, vocal) =>
    text.split("").map(c =>
        "aeiou".includes(c) ? vocal :
        "AEIOU".includes(c) ? vocal.toUpperCase() : c
    ).join("");

const canviaVocalsHTML = (html, vocal) =>
    html.split("<").map((tros, i) => {
        if (i == 0) return canviaVocals(tros, vocal);
        const fiEtiqueta = tros.indexOf(">");
        const etiqueta = tros.slice(0, fiEtiqueta + 1);   // part de l'etiqueta
        const text = tros.slice(fiEtiqueta + 1);          // text després de l'etiqueta
        return etiqueta + canviaVocals(text, vocal);
    }).join("<");

// Un listener per a cada botó per canviar les vocals
Array.from(document.querySelectorAll(".vocal")).forEach(boto => {
    boto.addEventListener("click", () => {
        paragrafs.forEach(p => p.innerHTML = canviaVocalsHTML(p.innerHTML, boto.textContent));
    });
});

document.getElementById("reset").addEventListener("click", () => {
    paragrafs.forEach((p, i) => p.innerHTML = originals[i]);
});


const botoNegreta = document.getElementById("negreta");
const botoRessaltar = document.getElementById("ressaltar");

// Mode actiu: o negreta o ressaltar. O null si es fa reset o es el primer cop
let mode = null;

const actualitzaBotons = () => {
    botoNegreta.style.background = mode == "negreta" ? "lightgrey" : "";
    botoRessaltar.style.background = mode == "ressaltar" ? "yellow" : "";
};

// En apretar un botó s'activa aquell mode i es desactiva l'altre.
const canviaMode = nouMode => {
    mode = mode == nouMode ? null : nouMode;
    actualitzaBotons();
};

botoNegreta.addEventListener("click", () => canviaMode("negreta"));
botoRessaltar.addEventListener("click", () => canviaMode("ressaltar"));

// Quan s'acaba de seleccionar dins d'un paràgraf, la paraula seleccionada passa a negreta o ressaltada segons el mode
const marcaSeleccio = () => {
    const seleccio = window.getSelection();
    const paraula = seleccio.toString().trim();

    if (mode == null || paraula == "") return;

    //<b> o <mark>
    const element = document.createElement(mode == "negreta" ? "b" : "mark");
    if (mode == "ressaltar") element.style.background = "yellow";

    // El rang és el tros de text seleccionat.
    try {
        seleccio.getRangeAt(0).surroundContents(element);
    } catch (e) {
        // Passa si la selecció agafa mig element ja marcat i mig text normal
        alert("La selecció es nomes per linies i no pot tallar una part que ja està marcada.");
    }
    seleccio.removeAllRanges(); // traiem la selecció
};

paragrafs.forEach(p => p.addEventListener("mouseup", marcaSeleccio));
