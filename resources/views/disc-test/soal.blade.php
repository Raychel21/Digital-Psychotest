@extends('layouts.app')

@section('extra-css')
<style>
    .question-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        border-bottom: 1px solid var(--card-border);
        padding-bottom: 10px;
    }

    .question-header h3 {
        font-size: 1.3rem;
        font-weight: 600;
    }

    .status-badge {
        background: #FEE2E2;
        color: #DC2626;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .status-badge.completed {
        background: #D1FAE5;
        color: #059669;
    }

    .options-grid {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .grid-header {
        display: grid;
        grid-template-columns: 1fr 80px 80px;
        gap: 15px;
        padding-bottom: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--text-muted);
    }

    .text-center { text-align: center; }
    .text-most { color: var(--most-color); }
    .text-least { color: var(--least-color); }

    .option-row {
        display: grid;
        grid-template-columns: 1fr 80px 80px;
        gap: 15px;
        align-items: center;
        padding: 12px 15px;
        background: #F8FAFC;
        border: 1px solid transparent;
        border-radius: 10px;
        transition: all 0.2s ease;
    }

    .option-row:hover {
        background: #F1F5F9;
        border-color: #E2E8F0;
    }

    .statement-text {
        font-size: 1.05rem;
        font-weight: 500;
        color: var(--text-main);
    }

    .radio-wrapper {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .radio-wrapper input[type="radio"] {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        width: 24px;
        height: 24px;
        z-index: 2;
    }

    .custom-radio {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 2px solid #CBD5E1;
        position: relative;
        transition: all 0.2s ease;
    }

    .custom-radio::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0);
        width: 12px;
        height: 12px;
        border-radius: 50%;
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .radio-wrapper input.radio-most:checked ~ .custom-radio {
        border-color: var(--most-color);
    }
    .radio-wrapper input.radio-most:checked ~ .custom-radio::after {
        background: var(--most-color);
        transform: translate(-50%, -50%) scale(1);
    }

    .radio-wrapper input.radio-least:checked ~ .custom-radio {
        border-color: var(--least-color);
    }
    .radio-wrapper input.radio-least:checked ~ .custom-radio::after {
        background: var(--least-color);
        transform: translate(-50%, -50%) scale(1);
    }

    /* Staggered animation for cards */
    <?php for($i=1; $i<=25; $i++): ?>
    .glass-card:nth-child(<?= $i ?>) {
        animation-delay: <?= $i * 0.1 ?>s;
    }
    <?php endfor; ?>
</style>
@endsection

@section('content')
<div class="header-title">
    <h1>Assessment DiSC</h1>
    <p>Pilih satu pernyataan yang <strong>Paling (M)</strong> dan satu pernyataan yang <strong>Kurang (L)</strong> pada setiap nomor.</p>
</div>

@if ($errors->any())
    <div class="error-msg" style="display: block;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="error-msg" id="clientError" style="display: none;">
    Masih ada pernyataan yang belum diisi dengan lengkap. Mohon lengkapi seluruh 24 pernyataan.
</div>

<form action="{{ route('disc-test.soal.store') }}" method="POST" id="discForm">
    @csrf

    @foreach($questions as $index => $q)
    <div class="glass-card question-card" data-qid="{{ $q->id }}">
        <div class="question-header">
            <h3>Pernyataan {{ $index + 1 }}</h3>
            <span class="status-badge" id="badge-{{ $q->id }}">Belum Lengkap</span>
        </div>
        
        <div class="options-grid">
            <div class="grid-header">
                <div>Pilih Karakteristik</div>
                <div class="text-center text-most">Paling (M)</div>
                <div class="text-center text-least">Kurang (L)</div>
            </div>
            @foreach($q->items as $item)
            <div class="option-row">
                <div class="statement-text">{{ $item->statement }}</div>
                <div class="radio-wrapper">
                    <input type="radio" name="most[{{ $q->id }}]" value="{{ $item->id }}" class="radio-most" data-qid="{{ $q->id }}" data-itemid="{{ $item->id }}">
                    <span class="custom-radio most"></span>
                </div>
                <div class="radio-wrapper">
                    <input type="radio" name="least[{{ $q->id }}]" value="{{ $item->id }}" class="radio-least" data-qid="{{ $q->id }}" data-itemid="{{ $item->id }}">
                    <span class="custom-radio least"></span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach

    <button type="submit" class="btn-submit">BERIKUTNYA</button>
</form>
@endsection

@section('extra-js')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const mostRadios = document.querySelectorAll('.radio-most');
        const leastRadios = document.querySelectorAll('.radio-least');
        const form = document.getElementById('discForm');
        const errorMsg = document.getElementById('clientError');

        function checkStatus(qid) {
            const mostSelected = document.querySelector(`input[name="most[${qid}]"]:checked`);
            const leastSelected = document.querySelector(`input[name="least[${qid}]"]:checked`);
            const badge = document.getElementById(`badge-${qid}`);
            
            if (mostSelected && leastSelected) {
                badge.textContent = 'Selesai';
                badge.classList.add('completed');
                return true;
            } else {
                badge.textContent = 'Belum Lengkap';
                badge.classList.remove('completed');
                return false;
            }
        }

        function handleRadioChange(e) {
            const type = e.target.classList.contains('radio-most') ? 'most' : 'least';
            const otherType = type === 'most' ? 'least' : 'most';
            const qid = e.target.dataset.qid;
            const itemId = e.target.dataset.itemid;

            const otherRadio = document.querySelector(`input.radio-${otherType}[data-qid="${qid}"][data-itemid="${itemId}"]`);
            if (otherRadio && otherRadio.checked) {
                otherRadio.checked = false;
            }

            checkStatus(qid);
        }

        mostRadios.forEach(radio => radio.addEventListener('change', handleRadioChange));
        leastRadios.forEach(radio => radio.addEventListener('change', handleRadioChange));

        form.addEventListener('submit', (e) => {
            let allCompleted = true;
            const questions = document.querySelectorAll('.question-card');
            
            questions.forEach(card => {
                const qid = card.dataset.qid;
                if (!checkStatus(qid)) {
                    allCompleted = false;
                    card.style.borderColor = 'rgba(239, 68, 68, 0.5)';
                    card.style.boxShadow = '0 0 15px rgba(239, 68, 68, 0.2)';
                } else {
                    card.style.borderColor = 'var(--card-border)';
                    card.style.boxShadow = '';
                }
            });

            if (!allCompleted) {
                e.preventDefault();
                errorMsg.style.display = 'block';
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });
    });
</script>
@endsection
