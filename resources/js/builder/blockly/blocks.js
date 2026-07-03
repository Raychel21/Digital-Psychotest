// Definisi blok kustom berbahasa Indonesia untuk editor logika.
// Konteks (daftar soal & dimensi) diperbarui tiap kali modal dibuka.
let context = { questions: [], dimensions: [] };

export function setBlockContext(next) {
    context = { ...context, ...next };
}

const ANSWER_FIELDS = [
    ['opsi terpilih', 'option_id'],
    ['daftar opsi terpilih', 'option_ids'],
    ['opsi Most', 'most_option_id'],
    ['opsi Least', 'least_option_id'],
    ['urutan opsi (ranking)', 'ordered_option_ids'],
    ['teks jawaban', 'text'],
];

const COMPARISON_OPS = [['=', '=='], ['≠', '!='], ['>', '>'], ['<', '<'], ['≥', '>='], ['≤', '<=']];
const BOOLEAN_OPS = [['DAN', 'and'], ['ATAU', 'or']];
const ARITHMETIC_OPS = [['+', '+'], ['−', '-'], ['×', '*'], ['÷', '/']];
const SCORE_KINDS = [['mentah (raw)', 'raw'], ['norma (norm)', 'norm']];

const questionOptions = () =>
    context.questions.length > 0
        ? context.questions.map((question) => [question.label, question.id])
        : [['(belum ada soal)', '']];

const dimensionOptions = () =>
    context.dimensions.length > 0
        ? context.dimensions.map((dimension) => [dimension.label, dimension.code])
        : [['(belum ada dimensi)', '']];

export function defineBuilderBlocks(Blockly) {
    if (Blockly.Blocks['pt_jawaban']) {
        return;
    }

    Blockly.Blocks['pt_jawaban'] = {
        init() {
            this.appendDummyInput()
                .appendField('jawaban soal')
                .appendField(new Blockly.FieldDropdown(questionOptions), 'QID')
                .appendField('→')
                .appendField(new Blockly.FieldDropdown(ANSWER_FIELDS), 'FIELD');
            this.setOutput(true, null);
            this.setColour(210);
            this.setTooltip('Nilai jawaban peserta pada soal tertentu.');
        },
    };

    Blockly.Blocks['pt_skor'] = {
        init() {
            this.appendDummyInput()
                .appendField('skor')
                .appendField(new Blockly.FieldDropdown(SCORE_KINDS), 'JENIS')
                .appendField('skala')
                .appendField(new Blockly.FieldTextInput('sum'), 'SKALA')
                .appendField('dimensi')
                .appendField(new Blockly.FieldDropdown(dimensionOptions), 'KODE');
            this.setOutput(true, null);
            this.setColour(290);
            this.setTooltip('Skor hasil per skala & dimensi, mis. raw.sum.D.');
        },
    };

    Blockly.Blocks['pt_variabel'] = {
        init() {
            this.appendDummyInput()
                .appendField('variabel')
                .appendField(new Blockly.FieldTextInput('nama'), 'NAMA');
            this.setOutput(true, null);
            this.setColour(290);
            this.setTooltip('Nilai variabel kustom yang didefinisikan sebelumnya.');
        },
    };

    Blockly.Blocks['pt_angka'] = {
        init() {
            this.appendDummyInput().appendField(new Blockly.FieldNumber(0), 'NUM');
            this.setOutput(true, null);
            this.setColour(160);
            this.setTooltip('Angka.');
        },
    };

    Blockly.Blocks['pt_teks'] = {
        init() {
            this.appendDummyInput()
                .appendField('teks')
                .appendField(new Blockly.FieldTextInput(''), 'TXT');
            this.setOutput(true, null);
            this.setColour(160);
            this.setTooltip('Teks.');
        },
    };

    Blockly.Blocks['pt_banding'] = {
        init() {
            this.appendValueInput('A');
            this.appendDummyInput().appendField(new Blockly.FieldDropdown(COMPARISON_OPS), 'OP');
            this.appendValueInput('B');
            this.setInputsInline(true);
            this.setOutput(true, null);
            this.setColour(120);
            this.setTooltip('Perbandingan dua nilai.');
        },
    };

    Blockly.Blocks['pt_logika'] = {
        init() {
            this.appendValueInput('A');
            this.appendDummyInput().appendField(new Blockly.FieldDropdown(BOOLEAN_OPS), 'OP');
            this.appendValueInput('B');
            this.setInputsInline(true);
            this.setOutput(true, null);
            this.setColour(45);
            this.setTooltip('Gabungan dua kondisi dengan DAN / ATAU.');
        },
    };

    Blockly.Blocks['pt_tidak'] = {
        init() {
            this.appendValueInput('A').appendField('TIDAK');
            this.setOutput(true, null);
            this.setColour(45);
            this.setTooltip('Kebalikan dari sebuah kondisi.');
        },
    };

    Blockly.Blocks['pt_memuat'] = {
        init() {
            this.appendValueInput('LIST').appendField('daftar');
            this.appendValueInput('VALUE').appendField('memuat');
            this.setInputsInline(true);
            this.setOutput(true, null);
            this.setColour(120);
            this.setTooltip('Benar bila daftar memuat nilai tertentu.');
        },
    };

    Blockly.Blocks['pt_aritmetika'] = {
        init() {
            this.appendValueInput('A');
            this.appendDummyInput().appendField(new Blockly.FieldDropdown(ARITHMETIC_OPS), 'OP');
            this.appendValueInput('B');
            this.setInputsInline(true);
            this.setOutput(true, null);
            this.setColour(230);
            this.setTooltip('Operasi aritmetika dua nilai.');
        },
    };
}
