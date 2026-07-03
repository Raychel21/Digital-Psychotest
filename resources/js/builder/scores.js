// Editor skor gaya KeyValue (kode dimensi => poin) untuk opsi soal berpoin.
// Setiap perubahan langsung dipersistenkan lewat $wire.updateOption.
export default function registerOptionScores(Alpine) {
    Alpine.data('optionScores', ({ optionId, entries }) => ({
        rows: Object.entries(entries ?? {}).map(([code, points]) => ({ code, points })),

        addRow() {
            this.rows.push({ code: '', points: 1 });
        },

        removeRow(index) {
            this.rows.splice(index, 1);
            this.save();
        },

        save() {
            const scores = {};

            for (const row of this.rows) {
                if (row.code !== '' && row.points !== '' && row.points !== null) {
                    scores[row.code] = Number(row.points) || 0;
                }
            }

            this.$wire.updateOption(optionId, { scores });
        },
    }));
}
