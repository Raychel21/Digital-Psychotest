@extends('layouts.admin')

@section('extra-css')
<style>
    .data-table {
        width: 100%; border-collapse: collapse; margin-top: 15px;
    }
    .data-table th, .data-table td {
        padding: 15px; text-align: left; border-bottom: 1px solid var(--card-border);
    }
    .data-table th {
        background: #F1F5F9; font-weight: 600; color: var(--text-muted);
    }
    .data-table tr:hover { background: #F8FAFC; }

    .btn-detail {
        display: inline-block; padding: 6px 12px; font-size: 0.9rem; text-decoration: none;
        background: #E0E7FF; color: var(--primary);
        border: 1px solid #C7D2FE; border-radius: 6px;
        transition: all 0.2s ease;
    }
    .btn-detail:hover {
        background: var(--primary); color: white;
    }
</style>
@endsection

@section('content')
<div style="margin-bottom: 30px;">
    <h1 style="font-size: 2rem;">Hasil Peserta</h1>
    <p style="color: var(--text-muted);">Daftar peserta yang telah menyelesaikan tes DiSC.</p>
</div>

<div class="glass-card" style="overflow-x: auto;">
    <table class="data-table">
        <thead>
            <tr>
                <th>Nama Peserta</th>
                <th>Email</th>
                <th>Posisi / Jabatan</th>
                <th>Token</th>
                <th>Tgl Selesai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($participants as $p)
            <tr>
                <td style="font-weight: 500; color: var(--text-main);">{{ $p->nama }}</td>
                <td style="color: var(--text-muted);">{{ $p->email }}</td>
                <td>{{ $p->positions }}</td>
                <td style="font-family: monospace;">{{ $p->token }}</td>
                <td style="color: var(--text-muted); font-size: 0.9rem;">
                    {{ $p->completed_at ? $p->completed_at->format('d M Y H:i') : '-' }}
                </td>
                <td>
                    <a href="{{ route('admin.participants.show', $p->id) }}" class="btn-action" target="_blank">Lihat Detail</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 30px;">
                    Belum ada peserta yang menyelesaikan tes.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
