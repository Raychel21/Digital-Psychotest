// Entry point builder visual asesmen (halaman admin "Builder").
// Blockly dimuat lewat dynamic import saat modal logika dibuka agar bundel tetap ringan.
import registerSortable from './builder/sortable';
import registerOptionScores from './builder/scores';
import registerLogicEditor from './builder/logic-editor';
import registerVariablesEditor from './builder/variables-editor';

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

if (window.Alpine) {
    register(window.Alpine);
} else {
    document.addEventListener('alpine:init', () => register(window.Alpine));
}
