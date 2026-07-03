import { loadBlockly, injectWorkspace } from './blockly/loader';
import { setBlockContext } from './blockly/blocks';
import { workspaceToJsonLogic } from './blockly/generator';

// Modal "Logika tampil" per soal: blok Blockly -> JsonLogic di questions.logic.
// Simpanan: { visible_if: <rule>, workspace: <state blockly> } — null bila kanvas kosong.
export default function registerLogicEditor(Alpine) {
    Alpine.data('logicEditor', () => ({
        questionId: null,
        loading: false,
        error: null,
        blockly: null,
        workspace: null,

        async handleOpen(event) {
            if (event.detail?.id !== 'builder-logic' || event.detail?.questionId == null) {
                return;
            }

            this.questionId = event.detail.questionId;
            this.error = null;
            this.loading = true;

            try {
                const [logic, context, Blockly] = await Promise.all([
                    this.$wire.getQuestionLogic(this.questionId),
                    this.$wire.getLogicContext(),
                    loadBlockly(),
                ]);

                setBlockContext(context);
                this.blockly = Blockly;

                // Beri waktu transisi modal selesai agar ukuran kanvas terhitung benar.
                setTimeout(() => this.inject(logic?.workspace ?? null), 200);
            } catch (error) {
                console.error(error);
                this.error = 'Editor blok gagal dimuat. Muat ulang halaman lalu coba lagi.';
                this.loading = false;
            }
        },

        inject(state) {
            this.disposeWorkspace();
            this.workspace = injectWorkspace(this.blockly, this.$refs.workspace, {
                variant: 'visibility',
                state,
            });
            this.loading = false;
        },

        clearWorkspace() {
            this.workspace?.clear();
        },

        save() {
            if (!this.workspace || this.questionId == null) {
                return;
            }

            const isEmpty = this.workspace.getAllBlocks(false).length === 0;
            const rule = isEmpty ? null : workspaceToJsonLogic(this.workspace);
            const state = isEmpty ? null : this.blockly.serialization.workspaces.save(this.workspace);

            this.$wire.saveQuestionLogic(this.questionId, rule, state);
            this.$dispatch('close-modal', { id: 'builder-logic' });
        },

        disposeWorkspace() {
            this.workspace?.dispose();
            this.workspace = null;
        },

        destroy() {
            this.disposeWorkspace();
        },
    }));
}
