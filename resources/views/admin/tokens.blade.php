@extends('layouts.admin')

@section('extra-css')
<style>
    .admin-grid {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 30px;
    }

    @media (max-width: 768px) {
        .admin-grid { grid-template-columns: 1fr; }
    }

    .form-group { margin-bottom: 20px; }
    .form-group label {
        display: block; margin-bottom: 8px; font-weight: 500; color: var(--text-muted);
    }
    .form-control {
        width: 100%; padding: 12px; background: #FFFFFF;
        border: 1px solid var(--card-border); border-radius: 8px;
        color: var(--text-main); font-size: 1rem;
    }
    
    .data-table {
        width: 100%; border-collapse: collapse; margin-top: 15px;
    }
    .data-table th, .data-table td {
        padding: 12px 15px; text-align: left; border-bottom: 1px solid var(--card-border);
    }
    .data-table th {
        background: #F1F5F9; font-weight: 600; color: var(--text-muted);
        text-align: left;
    }
    .data-table tr:hover { background: #F8FAFC; }

    .badge { padding: 5px 10px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; }
    .badge-available { background: #D1FAE5; color: #059669; }
    .badge-used { background: #FEE2E2; color: #DC2626; }

    .alert-success {
        background: #D1FAE5; border: 1px solid #10B981;
        color: #059669; padding: 15px; border-radius: 8px; margin-bottom: 20px;
    }
</style>
@endsection

@section('content')
<div style="margin-bottom: 30px;">
    <h1 style="font-size: 2rem;">Kelola Token</h1>
    <p style="color: var(--text-muted);">Generate dan monitor token akses peserta.</p>
</div>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

<div class="admin-grid">
    <!-- Form Generate -->
    <div>
        <div class="glass-card">
            <h3 style="margin-bottom: 20px; font-weight: 600; border-bottom: 1px solid var(--card-border); padding-bottom: 10px;">Generate Token Baru</h3>
            <form action="{{ route('admin.tokens.generate') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="test_type">Jenis Tes</label>
                    <select id="test_type" name="test_type" class="form-control" required style="background: #FFFFFF;">
                        <option value="DiSC">DiSC Profile</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="amount">Jumlah Token</label>
                    <input type="number" id="amount" name="amount" class="form-control" min="1" max="100" value="10" required>
                </div>
                <button type="submit" class="btn-primary" style="width: 100%;">Generate</button>
            </form>
        </div>
    </div>

    <!-- Table Tokens -->
    <div>
        <div class="glass-card" style="overflow-x: auto;">
            <h3 style="margin-bottom: 20px; font-weight: 600; border-bottom: 1px solid var(--card-border); padding-bottom: 10px;">Daftar Token</h3>
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
                        <td style="font-family: monospace; font-size: 1.1rem; color: var(--primary);">{{ $token->code }}</td>
                        <td style="text-transform: uppercase;">{{ $token->test_type }}</td>
                        <td>
                            <span class="badge {{ $token->status == 'available' ? 'badge-available' : 'badge-used' }}">
                                {{ ucfirst($token->status) }}
                            </span>
                        </td>
                        <td style="color: var(--text-muted); font-size: 0.9rem;">
                            {{ $token->created_at->format('d M Y H:i') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 20px;">Belum ada token.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
