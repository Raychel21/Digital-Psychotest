@extends('layouts.admin')

@section('content')
<div>
    <h1 style="font-size: 2rem; margin-bottom: 10px;">Dashboard</h1>
    <p style="color: var(--text-muted); margin-bottom: 30px;">Selamat datang, {{ auth()->user()->name }}!</p>
</div>

<div class="glass-card" style="text-align: center; padding: 50px 20px;">
    <h2 style="font-size: 1.5rem; margin-bottom: 15px;">Admin Panel</h2>
    <p style="color: var(--text-muted); margin-bottom: 30px; font-size: 1.1rem;">
        Ini adalah halaman utama admin. Fitur manajemen tes dan daftar peserta dapat ditambahkan di sini pada pengembangan selanjutnya.
    </p>
    <a href="#" class="btn-primary">Lihat Daftar Peserta (Coming Soon)</a>
</div>
@endsection
