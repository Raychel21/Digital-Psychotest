// Entry point builder visual asesmen (halaman admin "Builder").
// Blockly dimuat lewat dynamic import saat modal logika dibuka agar bundel tetap ringan.
import registerSortable from './builder/sortable';
import registerOptionScores from './builder/scores';
import registerLogicEditor from './builder/logic-editor';
import registerVariablesEditor from './builder/variables-editor';

const COMPONENT_NAMES = ['builderSortable', 'optionScores', 'logicEditor', 'variablesEditor'];

function register(Alpine) {
    if (!Alpine || Alpine.__builderRegistered) {
        return;
    }

    Alpine.__builderRegistered = true;

    registerSortable(Alpine);
    registerOptionScores(Alpine);
    registerLogicEditor(Alpine);
    registerVariablesEditor(Alpine);
}

// Saat halaman dibuka lewat navigasi SPA, Alpine sudah menginisialisasi DOM
// sebelum modul ini sempat mendaftarkan komponen — komponen builder yang
// terlanjur dirender harus diinisialisasi ulang agar tidak "not defined".
function reinitialiseRenderedComponents(Alpine) {
    const rendered = Array.from(document.querySelectorAll('[x-data]')).filter((el) =>
        COMPONENT_NAMES.some((name) => (el.getAttribute('x-data') ?? '').startsWith(name)),
    );

    rendered
        .filter((el) => !rendered.some((other) => other !== el && other.contains(el)))
        .forEach((el) => {
            Alpine.destroyTree(el);
            Alpine.initTree(el);
        });
}

if (window.Alpine) {
    register(window.Alpine);
    reinitialiseRenderedComponents(window.Alpine);
} else {
    document.addEventListener('alpine:init', () => register(window.Alpine));
}
