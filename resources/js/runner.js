import Sortable from 'sortablejs';

/**
 * Direktif Alpine `x-ranking`: menjadikan daftar opsi soal ranking bisa
 * digeser (drag & drop). Setiap selesai geser, urutan penuh dikirim ke
 * Livewire (`state.ordered_option_ids`) sehingga tersimpan otomatis lewat
 * alur SaveAnswer yang sudah ada.
 */
const registerRankingDirective = (Alpine) => {
    if (Alpine.__rankingDirectiveRegistered) {
        return;
    }

    Alpine.__rankingDirectiveRegistered = true;

    Alpine.directive('ranking', (el, _directive, { evaluate, cleanup }) => {
        const sortable = Sortable.create(el, {
            animation: 150,
            draggable: '[data-option-id]',
            ghostClass: 'opacity-50',
            dragClass: 'shadow-lg',
            // Di layar sentuh: tahan sejenak untuk menggeser, agar scroll tetap lancar.
            delay: 150,
            delayOnTouchOnly: true,
            touchStartThreshold: 5,
            onEnd: () => {
                const orderedOptionIds = Array.from(el.querySelectorAll('[data-option-id]')).map((item) =>
                    Number(item.dataset.optionId),
                );

                evaluate('$wire').set('state.ordered_option_ids', orderedOptionIds);
            },
        });

        cleanup(() => sortable.destroy());
    });
};

if (window.Alpine) {
    // Alpine sudah berjalan (mis. navigasi SPA): daftarkan langsung, lalu
    // inisialisasi ulang daftar ranking yang sudah terlanjur dirender.
    registerRankingDirective(window.Alpine);

    document.querySelectorAll('[x-ranking]').forEach((el) => {
        window.Alpine.destroyTree(el);
        window.Alpine.initTree(el);
    });
} else {
    document.addEventListener('alpine:init', () => registerRankingDirective(window.Alpine));
}
