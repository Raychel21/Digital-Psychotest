@extends('layouts.admin')

@section('extra-css')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    .admin-container { max-width: 1200px; margin: 0 auto; }
    
    .charts-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .chart-container {
        background: #F8FAFC;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid var(--card-border);
    }

    .chart-title {
        text-align: center;
        font-weight: 600;
        margin-bottom: 15px;
        font-size: 1.1rem;
        color: var(--text-main);
    }

    .data-table {
        width: 100%; border-collapse: collapse; margin-top: 15px;
    }
    .data-table th, .data-table td {
        padding: 12px 15px; text-align: left; border-bottom: 1px solid var(--card-border);
    }
    .data-table th {
        background: #F1F5F9; font-weight: 600; color: var(--text-muted);
    }
    .data-table tr:hover { background: #F8FAFC; }

    .btn-back {
        display: inline-block; margin-bottom: 20px; padding: 10px 20px;
        background: #F1F5F9; color: var(--text-main);
        text-decoration: none; border-radius: 8px; transition: all 0.3s ease;
        border: 1px solid var(--card-border);
    }
    .btn-back:hover { background: #E2E8F0; }
</style>
@endsection

@section('content')
<div class="admin-container">
    <a href="{{ route('admin.participants') }}" class="btn-back">← Kembali ke Daftar Peserta</a>

    <div style="margin-bottom: 30px;">
        <h1 style="font-size: 2rem;">Detail Hasil: {{ $participant->nama }}</h1>
        <p style="color: var(--text-muted);">Token: <strong style="color:var(--text-main);">{{ $participant->token }}</strong> | Diselesaikan pada: {{ $participant->completed_at->format('d M Y H:i') }}</p>
    </div>

    <div class="glass-card">
        <h3 style="margin-bottom: 20px; font-weight: 600; border-bottom: 1px solid var(--card-border); padding-bottom: 10px;">Visualisasi Profil</h3>
        <div class="charts-grid">
            <div class="chart-container">
                <div class="chart-title">Graph I (Most / Mask)</div>
                <canvas id="chartMost"></canvas>
            </div>
            <div class="chart-container">
                <div class="chart-title">Graph II (Least / Core)</div>
                <canvas id="chartLeast"></canvas>
            </div>
            <div class="chart-container">
                <div class="chart-title">Graph III (Change / Mirror)</div>
                <canvas id="chartChange"></canvas>
            </div>
        </div>
    </div>

    <div class="glass-card">
        <h3 style="margin-bottom: 20px; font-weight: 600; border-bottom: 1px solid var(--card-border); padding-bottom: 10px;">Rincian Pilihan Jawaban</h3>
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Pilihan Paling (Most)</th>
                        <th>Pilihan Kurang (Least)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($participant->answers as $index => $answer)
                    <tr>
                        <td style="text-align: center; color: var(--text-muted);">{{ $index + 1 }}</td>
                        <td style="color: var(--most-color);">{{ $answer->mostItem ? $answer->mostItem->statement : '-' }}</td>
                        <td style="color: var(--least-color);">{{ $answer->leastItem ? $answer->leastItem->statement : '-' }}</td>
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

        const chartConfig = {
            type: 'line',
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        min: -8,
                        max: 8,
                        ticks: { stepSize: 2, color: '#94a3b8' },
                        grid: {
                            color: function(ctx) { return ctx.tick.value === 0 ? 'rgba(255, 255, 255, 0.5)' : 'rgba(255, 255, 255, 0.1)'; },
                            lineWidth: function(ctx) { return ctx.tick.value === 0 ? 2 : 1; },
                            borderDash: function(ctx) { return ctx.tick.value === 0 ? [] : [5, 5]; }
                        }
                    },
                    x: {
                        ticks: { color: '#f8fafc', font: { size: 14, weight: 'bold' } },
                        grid: { display: false }
                    }
                },
                plugins: {
                    legend: { display: false }
                },
                elements: {
                    line: { tension: 0.3, borderWidth: 3 },
                    point: { radius: 5, hoverRadius: 8 }
                }
            }
        };

        new Chart(document.getElementById('chartMost').getContext('2d'), {
            type: chartConfig.type,
            data: {
                labels: ['D', 'I', 'S', 'C'],
                datasets: [{
                    data: [normScores.graph_1.D, normScores.graph_1.I, normScores.graph_1.S, normScores.graph_1.C],
                    borderColor: '#EC4899', backgroundColor: '#EC4899',
                }]
            },
            options: chartConfig.options
        });

        new Chart(document.getElementById('chartLeast').getContext('2d'), {
            type: chartConfig.type,
            data: {
                labels: ['D', 'I', 'S', 'C'],
                datasets: [{
                    data: [normScores.graph_2.D, normScores.graph_2.I, normScores.graph_2.S, normScores.graph_2.C],
                    borderColor: '#06B6D4', backgroundColor: '#06B6D4',
                }]
            },
            options: chartConfig.options
        });

        new Chart(document.getElementById('chartChange').getContext('2d'), {
            type: chartConfig.type,
            data: {
                labels: ['D', 'I', 'S', 'C'],
                datasets: [{
                    data: [normScores.graph_3.D, normScores.graph_3.I, normScores.graph_3.S, normScores.graph_3.C],
                    borderColor: '#8B5CF6', backgroundColor: '#8B5CF6',
                }]
            },
            options: chartConfig.options
        });
    });
</script>
@endsection
