@extends('layouts.admin')

@section('extra-css')
<style>
    .data-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-top: 10px;
    }
    
    .data-table th, .data-table td {
        padding: 16px 20px;
        text-align: left;
        border-bottom: 1px solid var(--card-border);
    }
    
    .data-table th {
        background: rgba(255, 255, 255, 0.02);
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
        background: rgba(255, 255, 255, 0.02);
    }
    
    .data-table tr:last-child td {
        border-bottom: none;
    }

    .btn-detail {
        display: inline-flex;
        align-items: center;
        padding: 8px 16px;
        font-family: var(--font-display);
        font-size: 0.85rem;
        font-weight: 700;
        text-decoration: none;
        background: rgba(139, 92, 246, 0.1);
        color: #C084FC;
        border: 1px solid rgba(139, 92, 246, 0.2);
        border-radius: 8px;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    .btn-detail:hover {
        background: var(--primary);
        color: white;
        box-shadow: 0 0 12px var(--primary-glow);
        border-color: var(--primary);
        transform: translateY(-1px);
    }

    .btn-detail:active {
        transform: translateY(0);
    }

    .token-badge {
        font-family: 'Consolas', 'Courier New', monospace;
        font-weight: 700;
        color: #F472B6;
        background: rgba(244, 114, 182, 0.08);
        padding: 4px 8px;
        border-radius: 6px;
        border: 1px solid rgba(244, 114, 182, 0.15);
    }
</style>
@endsection

@section('content')
<div style="margin-bottom: 32px;">
    <h1 style="font-family: var(--font-display); font-size: 2.2rem; font-weight: 800; letter-spacing: -0.03em; margin-bottom: 6px;">Hasil Peserta</h1>
    <p style="color: var(--text-muted); font-size: 1.05rem;">Daftar peserta yang telah menyelesaikan tes psikotes DiSC.</p>
</div>

<div class="glass-card" style="padding: 24px; overflow: hidden;">
    <div style="overflow-x: auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nama Peserta</th>
                    <th>Email</th>
                    <th>Posisi / Jabatan</th>
                    <th>Token</th>
                    <th>Tanggal Selesai</th>
                    <th style="width: 120px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($participants as $p)
                <tr>
                    <td style="font-weight: 600; color: var(--text-main); font-family: var(--font-display);">{{ $p->nama }}</td>
                    <td style="color: var(--text-muted);">{{ $p->email }}</td>
                    <td style="font-weight: 500; color: var(--text-main);">{{ $p->positions }}</td>
                    <td>
                        <span class="token-badge">{{ $p->token }}</span>
                    </td>
                    <td style="color: var(--text-muted); font-size: 0.9rem;">
                        {{ $p->completed_at ? $p->completed_at->format('d M Y, H:i') : '-' }}
                    </td>
                    <td style="text-align: center;">
                        <a href="{{ route('admin.participants.show', $p->id) }}" class="btn-detail" target="_blank">Detail Ujian</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 40px; font-size: 1rem;">
                        Belum ada peserta yang menyelesaikan ujian.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
