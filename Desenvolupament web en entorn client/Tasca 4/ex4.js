function CanviColor(){
    const fila = Number(document.getElementById("fila").value);
    const columna = Number(document.getElementById("columna").value);
    const text = document.getElementById("text").value;
    const color = document.getElementById("color").value;

    canviaCela(fila, columna, text, color);
}

function canviaCela(fila, columna, text, color){
    const taula = document.getElementById("myTable");

    if (fila < 1 || fila > taula.rows.length) {
        alert("La fila ha de ser entre 1 i " + taula.rows.length);
        return;
    }

    const filaTaula = taula.rows[fila - 1];

    if (columna < 1 || columna > filaTaula.cells.length) {
        alert("La columna ha de ser entre 1 i " + filaTaula.cells.length);
        return;
    }

    const cela = filaTaula.cells[columna - 1];
    cela.textContent = text;
    cela.style.backgroundColor = color;
}
