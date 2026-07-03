import { defineBuilderBlocks } from './blocks';

// Loader Blockly via dynamic import agar bundel halaman lain tetap ringan.
let cachedBlockly = null;

export async function loadBlockly() {
    if (cachedBlockly) {
        return cachedBlockly;
    }

    const [coreModule, localeModule] = await Promise.all([
        import('blockly/core'),
        import('blockly/msg/id'),
    ]);

    const Blockly = coreModule.default ?? coreModule;

    Blockly.setLocale(localeModule.default ?? localeModule);
    defineBuilderBlocks(Blockly);

    cachedBlockly = Blockly;

    return Blockly;
}

// Blok untuk aturan "logika tampil" (berbasis jawaban peserta).
const VISIBILITY_BLOCKS = ['pt_jawaban', 'pt_banding', 'pt_logika', 'pt_tidak', 'pt_memuat', 'pt_angka', 'pt_teks'];

// Blok untuk rumus variabel (berbasis skor hasil).
const VARIABLE_BLOCKS = ['pt_skor', 'pt_variabel', 'pt_aritmetika', 'pt_banding', 'pt_logika', 'pt_tidak', 'pt_angka'];

const toolboxFor = (types) => ({
    kind: 'flyoutToolbox',
    contents: types.map((type) => ({ kind: 'block', type })),
});

export function injectWorkspace(Blockly, container, { variant, state }) {
    container.innerHTML = '';

    const workspace = Blockly.inject(container, {
        toolbox: toolboxFor(variant === 'variables' ? VARIABLE_BLOCKS : VISIBILITY_BLOCKS),
        renderer: 'zelos',
        trashcan: true,
        scrollbars: true,
        zoom: { controls: true, wheel: true, startScale: 0.8 },
    });

    if (state && typeof state === 'object' && Object.keys(state).length > 0) {
        try {
            Blockly.serialization.workspaces.load(state, workspace);
        } catch (error) {
            console.error('Gagal memuat blok tersimpan:', error);
        }
    }

    Blockly.svgResize(workspace);

    return workspace;
}
