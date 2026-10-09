const pilota = document.getElementById("pilota");
const boto = document.getElementById("xuta");

const x0 = 0;
const y0 = 350;

const vx = 200;
const vy = 450;
const g = 300;

let t = 0;
let angle = 0;
let interval = null;

function xutar(){
    clearInterval(interval);
    t = 0;
    angle = 0;
    boto.disabled = true;
    interval = setInterval(animar, 20);
}

function animar(){
    t += 0.02;

    const x = x0 + vx * t;
    let y = y0 - vy * t + 0.5 * g * t * t;

    if (y > y0) {
        y = y0;
        clearInterval(interval);
        boto.disabled = false;
    }

    angle += 10;

    pilota.style.left = x + "px";
    pilota.style.top = y + "px";
    pilota.style.transform = "rotate(" + angle + "deg)";
}
