function marcarParaules(){
    const p = document.querySelector("p");
    const paraules = p.textContent.split(" ");
    for(let i = 0; i < paraules.length; i++){
        if(paraules[i].length >= 8){
            paraules[i] = "<span style='background-color: yellow'>" + paraules[i] + "</span>";
        }
    }
    p.innerHTML = paraules.join(" ");
}