import { loadBlockly, injectWorkspace } from './blockly/loader';
import { setBlockContext } from './blockly/blocks';
import { workspaceToJsonLogic } from './blockly/generator';

// Modal "Variabel & Rumus" level asesmen: baris {name, formula, workspace}
// disimpan ke assessments.logic.variables lewat $wire.saveVariables.
export default function registerVariablesEditor(Alpine) {
    Alpine.data('variablesEditor', () => ({
        rows: [],
        editingIndex: null,
        loading: false,
        error: null,
        blockly: null,
        workspace: null,

        async handleOpen(event) {
            if (event.detail?.id !== 'builder-variables') {
                return;
            }

            this.error = null;
            this.editingIndex = null;
            this.disposeWorkspace();

            try {
                const rows = await this.$wire.getVariables();

                this.rows = (rows ?? []).map((row) => ({
                    name: row.name ?? '',
                    formula: row.formula ?? null,
                    workspace: row.workspace ?? null,
                }));
            } catch (error) {
                console.error(error);
                this.error = 'Daftar variabel gagal dimuat. Muat ulang halaman lalu coba lagi.';
            }
        },

        addRow() {
            this.rows.push({ name: '', formula: null, workspace: null });
        },

        removeRow(index) {
            if (this.editingIndex === index) {
                this.cancelFormula();
            } else if (this.editingIndex !== null && this.editingIndex > index) {
                this.editingIndex--;
            }

            this.rows.splice(index, 1);
        },

        async editFormula(index) {
            this.error = null;
            this.loading = true;
            this.editingIndex = index;

            try {
                const [context, Blockly] = await Promise.all([this.$wire.getLogicContext(), loadBlockly()]);

                setBlockContext(context);
                this.blockly = Blockly;

                setTimeout(() => this.inject(this.rows[index]?.workspace ?? null), 200);
            } catch (error) {
                console.error(error);
                this.error = 'Editor blok gagal dimuat. Muat ulang halaman lalu coba lagi.';
                this.loading = false;
            }
        },

        inject(state) {
            this.disposeWorkspace();
            this.workspace = injectWorkspace(this.blockly, this.$refs.workspace, {
                variant: 'variables',
                state,
            });
            this.loading = false;
        },

        applyFormula() {
            const row = this.rows[this.editingIndex];

            if (!row || !this.workspace) {
                return;
            }

            const isEmpty = this.workspace.getAllBlocks(false).length === 0;

            row.formula = isEmpty ? null : workspaceToJsonLogic(this.workspace);
            row.workspace = isEmpty ? null : this.blockly.serialization.workspaces.save(this.workspace);

            this.cancelFormula();
        },

        cancelFormula() {
            this.editingIndex = null;
            this.disposeWorkspace();
        },

        async saveAll() {
            this.cancelFormula();

            await this.$wire.saveVariables(
                this.rows.map((row) => ({ name: row.name, formula: row.formula, workspace: row.workspace })),
            );

            this.$dispatch('close-modal', { id: 'builder-variables' });
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
