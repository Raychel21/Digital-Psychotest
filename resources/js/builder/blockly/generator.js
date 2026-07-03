// Generator kompak: blok Blockly -> aturan JsonLogic (kontrak LogicEvaluator).
// Pola merujuk katirasole/JSONLogic-Editor, ditulis ulang untuk blok kustom kita.
export function workspaceToJsonLogic(workspace) {
    const [top] = workspace.getTopBlocks(true);

    return top ? blockToLogic(top) : null;
}

function valueOf(block, name) {
    const target = block.getInputTargetBlock(name);

    return target ? blockToLogic(target) : null;
}

function binary(block, operator) {
    return { [operator]: [valueOf(block, 'A'), valueOf(block, 'B')] };
}

export function blockToLogic(block) {
    switch (block.type) {
        case 'pt_jawaban':
            return { var: `answers.${block.getFieldValue('QID')}.${block.getFieldValue('FIELD')}` };
        case 'pt_skor': {
            const scale = (block.getFieldValue('SKALA') || 'sum').trim();

            return { var: `${block.getFieldValue('JENIS')}.${scale}.${block.getFieldValue('KODE')}` };
        }
        case 'pt_variabel':
            return { var: `vars.${(block.getFieldValue('NAMA') || '').trim()}` };
        case 'pt_angka':
            return Number(block.getFieldValue('NUM') ?? 0);
        case 'pt_teks':
            return String(block.getFieldValue('TXT') ?? '');
        case 'pt_banding':
        case 'pt_logika':
        case 'pt_aritmetika':
            return binary(block, block.getFieldValue('OP'));
        case 'pt_tidak':
            return { '!': [valueOf(block, 'A')] };
        case 'pt_memuat':
            return { in: [valueOf(block, 'VALUE'), valueOf(block, 'LIST')] };
        default:
            return null;
    }
}
