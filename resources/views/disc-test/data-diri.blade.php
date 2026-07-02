@extends('layouts.app')

@section('content')
<div class="header-title">
    <h1>Data Diri Peserta</h1>
    <p>Silakan lengkapi biodata Anda sebelum memulai tes.</p>
</div>

@if ($errors->any())
    <div class="error-msg">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('disc-test.data-diri.store') }}" method="POST">
    @csrf
    <div class="glass-card">
        <div class="form-group">
            <label for="nama">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama') }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>
        <div class="form-group">
            <label for="gender">Jenis Kelamin</label>
            <select id="gender" name="gender" class="form-control" required>
                <option value="" disabled selected>Pilih Jenis Kelamin...</option>
                <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>
        <div class="form-group">
            <label for="tanggal_lahir">Tanggal Lahir / Usia</label>
            <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}" required>
        </div>
        <div class="form-group">
            <label for="pendidikan_terakhir">Pendidikan Terakhir</label>
            <input type="text" id="pendidikan_terakhir" name="pendidikan_terakhir" class="form-control" value="{{ old('pendidikan_terakhir') }}" required>
        </div>
        <div class="form-group">
            <label for="positions">Posisi / Jabatan yang Dilamar</label>
            <input type="text" id="positions" name="positions" class="form-control" value="{{ old('positions') }}" required>
        </div>
        <div class="form-group">
            <label for="kota">Kota Domisili</label>
            <input type="text" id="kota" name="kota" class="form-control" value="{{ old('kota') }}" required>
        </div>
        <div class="form-group">
            <label for="nomor_hp">Nomor HP / WhatsApp</label>
            <input type="text" id="nomor_hp" name="nomor_hp" class="form-control" value="{{ old('nomor_hp') }}" required>
        </div>
        
        <button type="submit" class="btn-submit">BERIKUTNYA</button>
    </div>
</form>
@endsection
