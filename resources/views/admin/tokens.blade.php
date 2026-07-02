@extends('layouts.admin')

@section('extra-css')
<style>
    .admin-grid {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 32px;
    }

    @media (max-width: 992px) {
        .admin-grid { grid-template-columns: 1fr; }
    }

    .form-group {
        margin-bottom: 24px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-family: var(--font-display);
        font-weight: 600;
        font-size: 0.85rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .form-control {
        width: 100%;
        padding: 12px 16px;
        background: var(--input-bg);
        border: 1px solid var(--card-border);
        border-radius: 10px;
        color: var(--text-main);
        font-size: 1rem;
        font-family: var(--font-body);
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--card-border-focus);
        background: var(--input-bg-focus);
        box-shadow: 0 0 16px var(--primary-glow);
    }
    
    select.form-control {
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml;utf8,<svg fill='none' stroke='%2394a3b8' stroke-width='2' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><path stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'></path></svg>");
        background-repeat: no-repeat;
        background-position: right 16px center;
        background-size: 16px;
        padding-right: 40px;
    }
    
    select.form-control option {
        background-color: #0b0f19;
        color: var(--text-main);
    }
    
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

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.02em;
    }
    
    .badge::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }

    .badge-available {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.2);
        color: #34D399;
    }
    .badge-available::before {
        background: #10B981;
        box-shadow: 0 0 6px #10B981;
    }

    .badge-used {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.2);
        color: #F87171;
    }
    .badge-used::before {
        background: #EF4444;
        box-shadow: 0 0 6px #EF4444;
    }

    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.25);
        color: #A7F3D0;
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 32px;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .token-code {
        font-family: 'Consolas', 'Courier New', monospace;
        font-size: 1.15rem;
        font-weight: 700;
        color: #C084FC;
        letter-spacing: 0.05em;
        background: rgba(192, 132, 252, 0.08);
        padding: 4px 10px;
        border-radius: 6px;
        border: 1px solid rgba(192, 132, 252, 0.15);
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
</style>
@endsection

@section('content')
<div style="margin-bottom: 32px;">
    <h1 style="font-family: var(--font-display); font-size: 2.2rem; font-weight: 800; letter-spacing: -0.03em; margin-bottom: 6px;">Kelola Token</h1>
    <p style="color: var(--text-muted); font-size: 1.05rem;">Generate dan monitor token akses pendaftaran peserta tes.</p>
</div>

@if(session('success'))
    <div class="alert-success">
        <svg style="width: 20px; height: 20px; flex-shrink: 0;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0110 21a3.745 3.745 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.746 3.746 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0114 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"></path>
        </svg>
        <span>{{ session('success') }}</span>
    </div>
@endif

<div class="admin-grid">
    <!-- Form Generate -->
    <div>
        <div class="glass-card">
            <h3 class="card-title">Generate Token Baru</h3>
            <form action="{{ route('admin.tokens.generate') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="test_type">Jenis Tes</label>
                    <select id="test_type" name="test_type" class="form-control" required>
                        <option value="DiSC">DiSC Profile</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="amount">Jumlah Token</label>
                    <input type="number" id="amount" name="amount" class="form-control" min="1" max="100" value="10" required>
                </div>
                <button type="submit" class="btn-primary" style="width: 100%; margin-top: 10px;">Generate</button>
            </form>
        </div>
    </div>

    <!-- Table Tokens -->
    <div>
        <div class="glass-card" style="padding: 24px; overflow: hidden;">
            <h3 class="card-title" style="margin-left: 16px; margin-right: 16px;">Daftar Token</h3>
            <div style="overflow-x: auto; max-height: 500px;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Kode Token</th>
                            <th>Tipe Tes</th>
                            <th>Status</th>
                            <th>Dibuat Pada</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tokens as $token)
                        <tr>
                            <td>
                                <span class="token-code">{{ $token->code }}</span>
                            </td>
                            <td style="text-transform: uppercase; font-family: var(--font-display); font-weight: 700; font-size: 0.9rem;">
                                {{ $token->test_type }}
                            </td>
                            <td>
                                <span class="badge {{ $token->status == 'available' ? 'badge-available' : 'badge-used' }}">
                                    {{ $token->status == 'available' ? 'Tersedia' : 'Terpakai' }}
                                </span>
                            </td>
                            <td style="color: var(--text-muted); font-size: 0.9rem;">
                                {{ $token->created_at->format('d M Y, H:i') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 40px; font-size: 1rem;">
                                Belum ada token yang dibuat.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
