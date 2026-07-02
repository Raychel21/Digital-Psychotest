@extends('layouts.app')

@section('content')
<div class="header-title">
    <h1>Login Assessment</h1>
    <p>Silakan masukkan token akses yang telah diberikan kepada Anda.</p>
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

<form action="{{ route('disc-test.token.verify') }}" method="POST">
    @csrf
    <div class="glass-card">
        <div class="form-group">
            <label for="token">Token Akses</label>
            <input type="text" id="token" name="token" class="form-control" placeholder="Contoh: 0001_ABC" required maxlength="8">
        </div>
        <button type="submit" class="btn-submit">SUBMIT TOKEN</button>
    </div>
</form>
@endsection
