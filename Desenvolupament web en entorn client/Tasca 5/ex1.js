const entrada = document.getElementById("entrada");
const crono = document.getElementById("crono");

let expressio = "";

function prem(caracter){
    expressio += caracter;
    entrada.value = expressio;
}

function neteja(){
    expressio = "";
    entrada.value = "";
}

function calcula(){
    if (expressio === "") return;

    try {
        const resultat = eval(expressio);
        if (!isFinite(resultat)) throw new Error();
        expressio = String(resultat);
        entrada.value = expressio;
    } catch (e) {
        expressio = "";
        entrada.value = "Error";
    }
}

function remarca(tecla){
    const boto = document.querySelector(`[data-tecla="${tecla}"]`);
    if (!boto) return;
    boto.classList.add("premut");
    setTimeout(() => boto.classList.remove("premut"), 150);
}

document.addEventListener("keydown", (e) => {
    const tecla = e.key;

    if ("0123456789+-*/".includes(tecla)) {
        prem(tecla);
        remarca(tecla);
    } else if (tecla === "Enter" || tecla === "=") {
        e.preventDefault();
        calcula();
        remarca("=");
    } else if (tecla === "Escape" || tecla === "Backspace" || tecla.toLowerCase() === "c") {
        neteja();
        remarca("C");
    }
});

const inici = Date.now();

function dosDigits(n){
    return String(n).padStart(2, "0");
}

function actualitzaCrono(){
    const segonsTotals = Math.floor((Date.now() - inici) / 1000);
    const hores = Math.floor(segonsTotals / 3600);
    const minuts = Math.floor((segonsTotals % 3600) / 60);
    const segons = segonsTotals % 60;

    crono.textContent = dosDigits(hores) + ":" + dosDigits(minuts) + ":" + dosDigits(segons);
}

setInterval(actualitzaCrono, 1000);
