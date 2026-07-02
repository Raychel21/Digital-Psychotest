<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Assessment DiSC</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #4F46E5; /* Indigo 600 */
            --primary-hover: #4338CA; /* Indigo 700 */
            --bg-gradient: #F1F5F9; /* Slate 100 */
            --card-bg: #FFFFFF;
            --card-border: #E2E8F0; /* Slate 200 */
            --text-main: #0F172A; /* Slate 900 */
            --text-muted: #64748B; /* Slate 500 */
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-gradient);
            color: var(--text-main);
            min-height: 100vh;
            padding: 40px 20px;
            line-height: 1.6;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .header-title {
            text-align: center;
            margin-bottom: 40px;
            animation: fadeInDown 0.8s ease;
        }

        .header-title h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary);
            letter-spacing: -0.025em;
            margin-bottom: 10px;
        }

        .header-title p {
            color: var(--text-muted);
            font-size: 1.1rem;
        }

        .glass-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: var(--shadow-md);
            animation: fadeInUp 0.6s ease both;
        }

        .charts-container {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        .chart-container {
            background: #F8FAFC;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid var(--card-border);
            width: 100%;
            max-width: 600px;
        }

        .chart-title {
            text-align: center;
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 1.1rem;
            color: var(--text-main);
        }

        .personality-summary {
            text-align: center;
            padding: 25px;
            background: #FDF2F8; /* Pink 50 */
            border: 1px solid #FCE7F3; /* Pink 100 */
            border-radius: 12px;
        }

        .personality-summary h2 {
            font-size: 1.4rem;
            color: #DB2777; /* Pink 600 */
            margin-bottom: 10px;
        }

        .personality-summary .personality-label {
            font-size: 1.1rem;
            color: var(--text-main);
            font-weight: 600;
            margin-bottom: 15px;
        }

        .personality-summary .personality-desc {
            font-size: 0.95rem;
            color: var(--text-muted);
            max-width: 600px;
            margin: 0 auto;
        }

        .btn-back {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 25px;
            background: #F1F5F9;
            color: var(--text-main);
            text-decoration: none;
            border-radius: 8px;
            border: 1px solid var(--card-border);
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-back:hover {
            background: #E2E8F0;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

    </style>
</head>
<body>

    <div class="container">
        <div class="header-title">
            <h1>Laporan Hasil DiSC</h1>
            <p>Terima kasih, <strong>{{ $participant->nama }}</strong>. Berikut adalah profil kepribadian Anda berdasarkan tes yang telah diselesaikan.</p>
        </div>

        <div class="glass-card">
            <div class="charts-container">
                <!-- Graph 1 -->
                <div class="chart-container">
                    <div class="chart-title">Graph I (Most / Mask)</div>
                    <canvas id="chartMost"></canvas>
                </div>
            </div>

            <div class="personality-summary">
                <h2>Profil Kepribadian Publik (Berdasarkan Graph I)</h2>
                <div class="personality-label">{{ $graph1Personality }}</div>
                <div class="personality-desc">
                    <strong>Ciri-ciri dan Karakteristik:</strong><br>
                    {{ $graph1Interpretation }}
                </div>
            </div>

            <div style="text-align: center;">
                <a href="{{ url('/') }}" class="btn-back">← Kembali ke Halaman Utama</a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data dari Controller
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
                            ticks: {
                                stepSize: 2,
                                color: '#64748B'
                            },
                            grid: {
                                color: function(context) {
                                    if (context.tick.value === 0) {
                                        return 'rgba(0, 0, 0, 0.2)';
                                    }
                                    return 'rgba(0, 0, 0, 0.05)';
                                },
                                lineWidth: function(context) {
                                    if (context.tick.value === 0) {
                                        return 2;
                                    }
                                    return 1;
                                },
                                borderDash: function(context) {
                                    if (context.tick.value === 0) {
                                        return [];
                                    }
                                    return [5, 5];
                                }
                            }
                        },
                        x: {
                            ticks: {
                                color: '#0F172A',
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.9)',
                            titleColor: '#0F172A',
                            bodyColor: '#0F172A',
                            borderColor: '#E2E8F0',
                            borderWidth: 1,
                            titleFont: { size: 14 },
                            bodyFont: { size: 14 },
                            padding: 10
                        }
                    },
                    elements: {
                        line: {
                            tension: 0.3, // smooth curves
                            borderWidth: 3
                        },
                        point: {
                            radius: 5,
                            hoverRadius: 8
                        }
                    }
                }
            };

            // Setup Graph I (Most)
            const ctxMost = document.getElementById('chartMost').getContext('2d');
            new Chart(ctxMost, {
                type: chartConfig.type,
                data: {
                    labels: ['D', 'I', 'S', 'C'],
                    datasets: [{
                        label: 'Graph I',
                        data: [
                            normScores.graph_1.D,
                            normScores.graph_1.I,
                            normScores.graph_1.S,
                            normScores.graph_1.C
                        ],
                        borderColor: '#DB2777', // Pink 600 for Most
                        backgroundColor: '#DB2777',
                    }]
                },
                options: chartConfig.options
            });
        });
    </script>
</body>
</html>
