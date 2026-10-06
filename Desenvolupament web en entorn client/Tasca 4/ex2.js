function for_colors(){
    var colors = ["red", "blue", "green", "silver", "orange"];
    var paragraphs = document.getElementsByTagName("p");
    for (let i = 0; i < paragraphs.length; i++) {
        paragraphs[i].style.color = colors[i];
    }
}

for_colors();