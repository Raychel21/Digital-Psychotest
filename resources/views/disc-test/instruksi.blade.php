@extends('layouts.app')

@section('content')
<div class="header-title">
    <h1>Instruksi Pengerjaan</h1>
    <p>Mohon baca petunjuk berikut dengan saksama sebelum mulai.</p>
</div>

<div class="glass-card" style="font-size: 1.1rem;">
    <p style="margin-bottom: 15px;">Anda akan diberikan 24 kelompok pernyataan. Setiap kelompok terdiri dari 4 pernyataan.</p>
    <p style="margin-bottom: 15px;">Tugas Anda adalah memilih:</p>
    <ul style="margin-left: 20px; margin-bottom: 20px; color: var(--text-muted);">
        <li style="margin-bottom: 10px;">Satu pernyataan yang <strong>PALING (M)</strong> menggambarkan diri Anda di lingkungan kerja.</li>
        <li style="margin-bottom: 10px;">Satu pernyataan yang <strong>KURANG (L)</strong> menggambarkan diri Anda di lingkungan kerja.</li>
    </ul>
    <p style="margin-bottom: 20px; padding: 15px; background: rgba(99, 102, 241, 0.1); border-left: 4px solid var(--primary); border-radius: 4px;">
        <strong>Perhatian:</strong> Kerjakanlah secara spontan dan jujur. Pilihan pertama Anda biasanya adalah yang paling akurat. Tidak ada jawaban benar atau salah dalam tes ini.
    </p>

    <a href="{{ route('disc-test.soal') }}" class="btn-submit" style="text-align: center; text-decoration: none;">KERJAKAN TES</a>
</div>
@endsection
