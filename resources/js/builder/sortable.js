import Sortable from 'sortablejs';

// Daftar yang bisa diurutkan dengan drag & drop (soal di kanvas, opsi di kartu).
// Pemakaian: x-data="builderSortable({ handle: '.builder-drag-handle', onSort: (ids) => ... })"
export default function registerSortable(Alpine) {
    Alpine.data('builderSortable', ({ handle, onSort }) => ({
        sortable: null,

        init() {
            this.sortable = Sortable.create(this.$el, {
                handle,
                animation: 150,
                draggable: '[data-sortable-id]',
                ghostClass: 'opacity-50',
                onEnd: (event) => {
                    if (event.oldIndex === event.newIndex) {
                        return;
                    }

                    const ids = Array.from(
                        this.$el.querySelectorAll(':scope > [data-sortable-id]'),
                    ).map((el) => el.dataset.sortableId);

                    onSort(ids);
                },
            });
        },

        destroy() {
            this.sortable?.destroy();
            this.sortable = null;
        },
    }));
}
