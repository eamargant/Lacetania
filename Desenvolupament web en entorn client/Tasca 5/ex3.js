const FREQUENCIES = {
    'C4': 261.63,
    'C#4': 277.18,
    'D4': 293.66,
    'D#4': 311.13,
    'E4': 329.63,
    'F4': 349.23,
    'F#4': 369.99,
    'G4': 392.00,
    'G#4': 415.30,
    'A4': 440.00,
    'A#4': 466.16,
    'B4': 493.88,
    'C5': 523.25
};

let audioCtx = null;
const activeNotes = new Map();

function initAudio() {
    if (!audioCtx) {
        audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    }
    if (audioCtx.state === 'suspended') {
        audioCtx.resume();
    }
}

function playNote(note) {
    initAudio();
    if (activeNotes.has(note)) return;

    const freq = FREQUENCIES[note];
    if (!freq) return;

    const osc = audioCtx.createOscillator();
    const gain = audioCtx.createGain();

    osc.type = 'triangle';
    osc.frequency.setValueAtTime(freq, audioCtx.currentTime);

    gain.gain.setValueAtTime(0.001, audioCtx.currentTime);
    gain.gain.linearRampToValueAtTime(0.5, audioCtx.currentTime + 0.02);

    osc.connect(gain);
    gain.connect(audioCtx.destination);
    osc.start();

    activeNotes.set(note, { osc, gain });

    const keyEl = document.querySelector(`[data-note="${note}"]`);
    if (keyEl) keyEl.classList.add('active');
}

function stopNote(note) {
    if (!activeNotes.has(note)) return;

    const { osc, gain } = activeNotes.get(note);
    const now = audioCtx.currentTime;

    gain.gain.cancelScheduledValues(now);
    gain.gain.setValueAtTime(gain.gain.value, now);
    gain.gain.exponentialRampToValueAtTime(0.0001, now + 0.25);

    setTimeout(() => {
        try {
            osc.stop();
            osc.disconnect();
        } catch (e) {}
    }, 250);

    activeNotes.delete(note);

    const keyEl = document.querySelector(`[data-note="${note}"]`);
    if (keyEl) keyEl.classList.remove('active');
}

const TECLAT = {
    'a': 'C4',
    'w': 'C#4',
    's': 'D4',
    'e': 'D#4',
    'd': 'E4',
    'f': 'F4',
    't': 'F#4',
    'g': 'G4',
    'y': 'G#4',
    'h': 'A4',
    'u': 'A#4',
    'j': 'B4',
    'k': 'C5'
};

const ultima = document.getElementById("ultima");

function toca(nota){
    playNote(nota);
    ultima.textContent = "♪ " + nota + " · " + FREQUENCIES[nota] + " Hz";
}

document.addEventListener("keydown", (e) => {
    if (e.repeat) return;
    const nota = TECLAT[e.key.toLowerCase()];
    if (nota) toca(nota);
});

document.addEventListener("keyup", (e) => {
    const nota = TECLAT[e.key.toLowerCase()];
    if (nota) stopNote(nota);
});

document.querySelectorAll(".tecla").forEach((tecla) => {
    const nota = tecla.dataset.note;

    tecla.addEventListener("mousedown", () => toca(nota));
    tecla.addEventListener("mouseup", () => stopNote(nota));
    tecla.addEventListener("mouseleave", () => stopNote(nota));

    tecla.addEventListener("touchstart", (e) => {
        e.preventDefault();
        toca(nota);
    });
    tecla.addEventListener("touchend", () => stopNote(nota));
});
