function afegirFila(){
    var taula = document.getElementById("unaTaula");
    var fila = taula.insertRow();
    for (let i = 0; i < 3; i++) {
        var cela = fila.insertCell();
        cela.innerHTML = "F" + (i+1);
    }
}