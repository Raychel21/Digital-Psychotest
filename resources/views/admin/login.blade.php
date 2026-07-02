@extends('layouts.admin')

@section('extra-css')
<style>
    .login-container {
        max-width: 450px;
        margin: 50px auto;
    }
    .form-group { margin-bottom: 20px; }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: var(--text-muted);
    }
    .form-control {
        width: 100%;
        padding: 12px 15px;
        background: #FFFFFF;
        border: 1px solid var(--card-border);
        border-radius: 8px;
        color: var(--text-main);
        font-size: 1rem;
        font-family: 'Inter', sans-serif;
        transition: all 0.2s ease;
        box-shadow: var(--shadow-sm);
    }
    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }
    .btn-submit {
        display: block;
        width: 100%;
        padding: 14px;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        margin-top: 25px;
        box-shadow: var(--shadow-sm);
    }
    .btn-submit:hover {
        background: var(--primary-hover);
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }
    .error-msg {
        background: #FEF2F2;
        border: 1px solid #FEE2E2;
        color: #DC2626;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')
<div class="login-container">
    <div style="text-align: center; margin-bottom: 30px;">
        <h1 style="font-size: 2rem; color: var(--primary); letter-spacing: -0.025em;">Admin Login</h1>
        <p style="color: var(--text-muted); margin-top: 5px;">Silakan login untuk mengakses panel admin.</p>
    </div>

    @if($errors->any())
        <div class="error-msg">
            <ul style="margin-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="glass-card">
        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" value="{{ old('username') }}" required autofocus>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            
            <button type="submit" class="btn-submit">LOGIN</button>
        </form>
    </div>
</div>
@endsection
