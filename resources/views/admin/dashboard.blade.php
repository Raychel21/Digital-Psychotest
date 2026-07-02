@extends('layouts.admin')

@section('extra-css')
<style>
    .welcome-banner {
        background: var(--welcome-banner-bg);
        border: 1px solid var(--welcome-banner-border);
        border-radius: 20px;
        padding: 40px;
        margin-bottom: 32px;
        position: relative;
        overflow: hidden;
    }

    .welcome-banner::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(139, 92, 246, 0.2) 0%, transparent 70%);
        pointer-events: none;
    }

    .welcome-banner h1 {
        font-family: var(--font-display);
        font-size: 2.2rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        margin-bottom: 10px;
        background: var(--welcome-h1-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .welcome-banner p {
        color: var(--text-muted);
        font-size: 1.1rem;
        max-width: 600px;
        line-height: 1.6;
        margin-bottom: 24px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }

    .stat-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 16px;
        padding: 24px;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(12px);
    }

    .stat-card:hover {
        transform: translateY(-4px);
        border-color: var(--card-border-focus);
        box-shadow: var(--shadow-md), 0 0 15px var(--primary-glow);
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        background: rgba(139, 92, 246, 0.1);
        border: 1px solid rgba(139, 92, 246, 0.2);
        color: var(--primary);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-icon svg {
        width: 28px;
        height: 28px;
    }

    .stat-info h3 {
        font-size: 0.85rem;
        font-family: var(--font-display);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--text-muted);
        margin-bottom: 6px;
    }

    .stat-info p {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--text-main);
        font-family: var(--font-display);
    }

    .quick-actions {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
    }

    .btn-secondary {
        display: inline-block;
        padding: 12px 24px;
        background: var(--btn-secondary-bg);
        color: var(--text-main);
        border: 1px solid var(--btn-secondary-border);
        border-radius: 10px;
        font-family: var(--font-display);
        font-size: 0.95rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.25s ease;
        text-decoration: none;
        text-align: center;
    }

    .btn-secondary:hover {
        background: var(--btn-secondary-bg);
        border-color: var(--card-border-focus);
        transform: translateY(-2px);
    }
</style>
@endsection

@section('content')
<div class="welcome-banner">
    <h1>Selamat Datang di Digital Psychotest</h1>
    <p>
        Kelola token pendaftaran peserta, pantau hasil ujian secara real-time, dan unduh detail laporan kepribadian DiSC peserta dengan mudah.
    </p>
    <div class="quick-actions">
        <a href="{{ route('admin.tokens') }}" class="btn-primary">Generate Token Baru</a>
        <a href="{{ route('admin.participants') }}" class="btn-secondary">Lihat Hasil Peserta</a>
    </div>
</div>

<div class="stats-grid">
    <!-- Stat 1: Total Peserta -->
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(236, 72, 153, 0.1); border-color: rgba(236, 72, 153, 0.2); color: #EC4899;">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.97 5.97 0 00-.75-2.985m-.001-3.975a3.75 3.75 0 10-7.5 0m7.5 0a3.75 3.75 0 01-7.5 0m0 0a3.75 3.75 0 10-7.5 0M3 16.062a9 9 0 0114.25-7.14M18 18.72V19a2 2 0 01-2 2H8a2 2 0 01-2-2v-.281c0-.498-.07-1.002-.207-1.488l-.203-.709A6 6 0 0111.374 9.75h1.252a6 6 0 015.786 4.316l.203.709c.137.486.207.99.207 1.488z"></path>
            </svg>
        </div>
        <div class="stat-info">
            <h3>Total Peserta Selesai</h3>
            <p>{{ $stats['total_participants'] }}</p>
        </div>
    </div>

    <!-- Stat 2: Token Tersedia -->
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.2); color: #10B981;">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z"></path>
            </svg>
        </div>
        <div class="stat-info">
            <h3>Token Tersedia</h3>
            <p>{{ $stats['available_tokens'] }}</p>
        </div>
    </div>

    <!-- Stat 3: Token Terpakai -->
    <div class="stat-card">
        <div class="stat-icon">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0110 21a3.745 3.745 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.746 3.746 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0114 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"></path>
            </svg>
        </div>
        <div class="stat-info">
            <h3>Token Terpakai</h3>
            <p>{{ $stats['used_tokens'] }}</p>
        </div>
    </div>
</div>
@endsection
