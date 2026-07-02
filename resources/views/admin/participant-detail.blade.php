@extends('layouts.admin')

@section('extra-css')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    .admin-container {
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .charts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }

    .chart-container {
        background: var(--chart-container-bg);
        border-radius: 16px;
        padding: 24px;
        border: 1px solid var(--card-border);
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.15);
        transition: background 0.3s ease;
    }

    .chart-title {
        text-align: center;
        font-family: var(--font-display);
        font-weight: 700;
        margin-bottom: 20px;
        font-size: 1.05rem;
        color: var(--text-main);
        letter-spacing: -0.01em;
        text-transform: uppercase;
    }

    .data-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-top: 10px;
    }
    
    .data-table th, .data-table td {
        padding: 14px 20px;
        text-align: left;
        border-bottom: 1px solid var(--card-border);
    }
    
    .data-table th {
        background: var(--table-th-bg);
        font-family: var(--font-display);
        font-weight: 700;
        font-size: 0.85rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .data-table tr {
        transition: background 0.2s ease;
    }

    .data-table tbody tr:hover {
        background: var(--table-row-hover);
    }
    
    .data-table tr:last-child td {
        border-bottom: none;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 24px;
        padding: 10px 20px;
        background: var(--btn-secondary-bg);
        color: var(--text-main);
        text-decoration: none;
        border-radius: 8px;
        font-family: var(--font-display);
        font-weight: 700;
        font-size: 0.9rem;
        transition: all 0.2s ease;
        border: 1px solid var(--btn-secondary-border);
    }
    
    .btn-back:hover {
        background: var(--btn-secondary-bg);
        border-color: var(--card-border-focus);
        transform: translateX(-4px);
    }

    .badge-info-pill {
        background: var(--badge-pill-bg);
        border: 1px solid var(--badge-pill-border);
        color: #C084FC;
        font-family: var(--font-display);
        font-size: 0.85rem;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .meta-value {
        font-weight: 600;
        color: var(--text-main);
    }
    
    .card-title {
        font-family: var(--font-display);
        font-size: 1.25rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        margin-bottom: 24px;
        padding-bottom: 12px;
        border-bottom: 1px solid var(--card-border);
        color: var(--text-main);
    }

    /* Personality Highlights */
    .personality-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 32px;
    }

    @media (max-width: 768px) {
        .personality-section { grid-template-columns: 1fr; }
    }

    .personality-card {
        background: var(--personality-card-bg);
        border: 1px solid var(--personality-card-border);
        border-radius: 16px;
        padding: 24px;
        transition: background 0.3s ease, border-color 0.3s ease;
    }

    .personality-card-mirror {
        background: var(--personality-mirror-bg);
        border: 1px solid var(--personality-mirror-border);
        border-radius: 16px;
        padding: 24px;
        transition: background 0.3s ease, border-color 0.3s ease;
    }

    .personality-card h4, .personality-card-mirror h4 {
        font-family: var(--font-display);
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 12px;
    }

    .personality-type {
        font-family: var(--font-display);
        font-size: 1.4rem;
        font-weight: 800;
        color: #C084FC;
        margin-bottom: 16px;
        letter-spacing: -0.02em;
    }

    .personality-desc {
        color: var(--text-muted);
        font-size: 1rem;
        line-height: 1.6;
    }

    .participant-profile-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 32px;
        flex-wrap: wrap;
        gap: 20px;
    }
</style>
@endsection

@section('content')
<div class="admin-container">
    <a href="{{ route('admin.participants') }}" class="btn-back">
        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path>
        </svg>
        Kembali ke Daftar Peserta
    </a>

    <div class="participant-profile-header">
        <div>
            <h1 style="font-family: var(--font-display); font-size: 2.2rem; font-weight: 800; letter-spacing: -0.03em; margin-bottom: 8px;">Detail Hasil: {{ $participant->nama }}</h1>
            <p style="color: var(--text-muted); font-size: 1.05rem;">
                Posisi: <span class="meta-value">{{ $participant->positions }}</span> | 
                Email: <span class="meta-value">{{ $participant->email }}</span>
            </p>
        </div>
        <div style="text-align: right; display: flex; flex-direction: column; gap: 8px; align-items: flex-end;">
            <span class="badge-info-pill">Token: {{ $participant->token }}</span>
            <span style="color: var(--text-muted); font-size: 0.9rem;">
                Diselesaikan: {{ $participant->completed_at->format('d M Y, H:i') }}
            </span>
        </div>
    </div>

    <!-- Section: Analisis Kepribadian -->
    <div class="personality-section">
        <!-- Mask / Public Self -->
        <div class="personality-card">
            <h4>Profil Publik / Mask (Graph I)</h4>
            <div class="personality-type">{{ $graph1Personality }}</div>
            <p class="personality-desc">{{ $graph1Interpretation ?: 'Analisis detail untuk profil publik peserta.' }}</p>
        </div>

        <!-- Core / Private Self (Integrated) -->
        <div class="personality-card-mirror">
            <h4 style="color: #EC4899;">Profil Asli / Mirror (Graph III)</h4>
            <div class="personality-type" style="color: #F472B6;">{{ $primaryPersonality }}</div>
            <p class="personality-desc">
                @php
                    $integratedInterpretations = [
                        'D' => 'Memiliki kecenderungan dominan di situasi internal. Menunjukkan kemandirian, ketegasan, dan berorientasi pada pencapaian hasil secara langsung dan mandiri.',
                        'I' => 'Memiliki kecenderungan persuasif di lingkungan internal. Hangat, bersahabat, komunikatif, dan ekspresif dalam mengutarakan ide serta emosi.',
                        'S' => 'Memiliki kecenderungan stabil dan konsisten secara internal. Menjunjung loyalitas, kebersamaan, dan kenyamanan lingkungan kerja yang harmonis.',
                        'C' => 'Memiliki kecenderungan analitis dan berhati-hati secara internal. Berorientasi pada akurasi data, taat aturan, dan menyukai kejelasan prosedur.'
                    ];
                    $highestIntegrated = array_keys($normScores['graph_3'], max($normScores['graph_3']))[0] ?? '';
                    $descIntegrated = $integratedInterpretations[$highestIntegrated] ?? 'Analisis detail untuk profil asli/cermin diri peserta.';
                @endphp
                {{ $descIntegrated }}
            </p>
        </div>
    </div>

    <!-- Section: Grafik Visualisasi -->
    <div class="glass-card" style="margin-bottom: 32px;">
        <h3 class="card-title">Visualisasi Profil DiSC</h3>
        <div class="charts-grid">
            <div class="chart-container">
                <div class="chart-title" style="color: #EC4899;">Graph I (Most / Mask)</div>
                <canvas id="chartMost"></canvas>
            </div>
            <div class="chart-container">
                <div class="chart-title" style="color: #06B6D4;">Graph II (Least / Core)</div>
                <canvas id="chartLeast"></canvas>
            </div>
            <div class="chart-container">
                <div class="chart-title" style="color: #8B5CF6;">Graph III (Change / Mirror)</div>
                <canvas id="chartChange"></canvas>
            </div>
        </div>
    </div>

    <!-- Section: Rincian Pilihan Jawaban -->
    <div class="glass-card" style="margin-bottom: 32px; padding: 24px; overflow: hidden;">
        <h3 class="card-title" style="margin-left: 16px; margin-right: 16px;">Rincian Pilihan Jawaban</h3>
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 80px; text-align: center;">No</th>
                        <th>Pilihan Paling (Most)</th>
                        <th>Pilihan Kurang (Least)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($participant->answers as $index => $answer)
                    <tr>
                        <td style="text-align: center; color: var(--text-muted); font-weight: 700;">{{ $index + 1 }}</td>
                        <td style="color: #F472B6; font-weight: 500;">
                            {{ $answer->mostItem ? $answer->mostItem->statement : '-' }}
                        </td>
                        <td style="color: #22D3EE; font-weight: 500;">
                            {{ $answer->leastItem ? $answer->leastItem->statement : '-' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const normScores = @json($normScores);
        let chartMost, chartLeast, chartChange;

        function renderCharts() {
            const isLight = document.documentElement.classList.contains('light-theme');
            const gridColor = isLight ? 'rgba(15, 23, 42, 0.05)' : 'rgba(255, 255, 255, 0.05)';
            const tickColor = isLight ? '#64748b' : '#94a3b8';
            const xTickColor = isLight ? '#0F172A' : '#f8fafc';
            const pointBorderColor = isLight ? '#FFFFFF' : '#090B11';

            // Customize common Chart.js options dynamically for Dark/Light Mode
            const chartOptions = {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        min: -8,
                        max: 8,
                        ticks: { 
                            stepSize: 2, 
                            color: tickColor,
                            font: { family: 'Outfit', size: 11 }
                        },
                        grid: {
                            color: function(ctx) { 
                                if (ctx.tick.value === 0) {
                                    return isLight ? 'rgba(15, 23, 42, 0.25)' : 'rgba(255, 255, 255, 0.25)';
                                }
                                return gridColor;
                            },
                            lineWidth: function(ctx) { return ctx.tick.value === 0 ? 2 : 1; },
                            borderDash: function(ctx) { return ctx.tick.value === 0 ? [] : [5, 5]; }
                        }
                    },
                    x: {
                        ticks: { 
                            color: xTickColor, 
                            font: { family: 'Plus Jakarta Sans', size: 13, weight: 'bold' } 
                        },
                        grid: { display: false }
                    }
                },
                plugins: {
                    legend: { display: false }
                },
                elements: {
                    line: { tension: 0.25, borderWidth: 3.5 },
                    point: { 
                        radius: 6, 
                        hoverRadius: 9,
                        borderWidth: 2,
                        borderColor: pointBorderColor
                    }
                }
            };

            // Destroy previous instances if they exist
            if (chartMost) chartMost.destroy();
            if (chartLeast) chartLeast.destroy();
            if (chartChange) chartChange.destroy();

            // Graph I
            chartMost = new Chart(document.getElementById('chartMost').getContext('2d'), {
                type: 'line',
                data: {
                    labels: ['D', 'I', 'S', 'C'],
                    datasets: [{
                        data: [normScores.graph_1.D, normScores.graph_1.I, normScores.graph_1.S, normScores.graph_1.C],
                        borderColor: '#EC4899', 
                        backgroundColor: '#EC4899',
                        pointBackgroundColor: '#EC4899'
                    }]
                },
                options: chartOptions
            });

            // Graph II
            chartLeast = new Chart(document.getElementById('chartLeast').getContext('2d'), {
                type: 'line',
                data: {
                    labels: ['D', 'I', 'S', 'C'],
                    datasets: [{
                        data: [normScores.graph_2.D, normScores.graph_2.I, normScores.graph_2.S, normScores.graph_2.C],
                        borderColor: '#06B6D4', 
                        backgroundColor: '#06B6D4',
                        pointBackgroundColor: '#06B6D4'
                    }]
                },
                options: chartOptions
            });

            // Graph III
            chartChange = new Chart(document.getElementById('chartChange').getContext('2d'), {
                type: 'line',
                data: {
                    labels: ['D', 'I', 'S', 'C'],
                    datasets: [{
                        data: [normScores.graph_3.D, normScores.graph_3.I, normScores.graph_3.S, normScores.graph_3.C],
                        borderColor: '#8B5CF6', 
                        backgroundColor: '#8B5CF6',
                        pointBackgroundColor: '#8B5CF6'
                    }]
                },
                options: chartOptions
            });
        }

        // Render initially
        renderCharts();

        // Listen for theme toggle to re-render charts with correct colors
        window.addEventListener('theme-changed', renderCharts);
    });
</script>
@endsection
