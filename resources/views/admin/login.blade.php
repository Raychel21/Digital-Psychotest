@extends('layouts.admin')

@section('extra-css')
<style>
    body {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
    }
    
    .container {
        max-width: 460px;
        margin: auto;
        padding: 20px;
    }

    .login-header {
        text-align: center;
        margin-bottom: 32px;
    }

    .login-header .logo-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, var(--primary) 0%, #EC4899 100%);
        border-radius: 14px;
        margin: 0 auto 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 24px rgba(139, 92, 246, 0.4);
    }

    .login-header .logo-icon svg {
        width: 24px;
        height: 24px;
        color: white;
    }

    .login-header h1 {
        font-family: var(--font-display);
        font-size: 2.1rem;
        font-weight: 800;
        letter-spacing: -0.04em;
        margin-bottom: 6px;
        background: var(--login-h1-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .login-header p {
        color: var(--text-muted);
        font-size: 0.95rem;
    }

    .form-group {
        margin-bottom: 24px;
        position: relative;
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

    .input-wrapper {
        position: relative;
    }

    .form-control {
        width: 100%;
        padding: 14px 16px;
        background: var(--input-bg);
        border: 1px solid var(--card-border);
        border-radius: 12px;
        color: var(--text-main);
        font-size: 1rem;
        font-family: var(--font-body);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--card-border-focus);
        background: var(--input-bg-focus);
        box-shadow: 
            inset 0 2px 4px rgba(0, 0, 0, 0.2),
            0 0 16px var(--primary-glow);
    }

    .btn-submit {
        display: block;
        width: 100%;
        padding: 15px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-family: var(--font-display);
        font-size: 1.05rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        margin-top: 32px;
        box-shadow: 0 4px 18px rgba(139, 92, 246, 0.35);
        letter-spacing: 0.05em;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(139, 92, 246, 0.5);
        background: linear-gradient(135deg, var(--primary-hover) 0%, #6D28D9 100%);
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    .error-msg {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.2);
        color: #FCA5A5;
        padding: 16px;
        border-radius: 12px;
        margin-bottom: 24px;
        font-size: 0.9rem;
    }

    .error-msg ul {
        list-style-type: none;
    }

    .glass-card {
        padding: 40px;
        box-shadow: var(--shadow-lg);
        border-color: rgba(255, 255, 255, 0.08);
    }
</style>
@endsection

@section('content')
<div class="login-wrapper">
    <div class="login-header">
        <div class="logo-icon">
            <!-- Brain / Mind Icon SVG -->
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v3m0 0h.01m-.01 0H12m0-3a2 2 0 11-4 0v-2.5a2.5 2.5 0 015 0V18z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9.75h.008v.008H8.25V9.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM15.75 9.75h.008v.008H15.75V9.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM9.75 15.75h.008v.008H9.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM14.25 15.75h.008v.008H14.25v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <h1>Digital Psychotest</h1>
        <p>Silakan login untuk mengakses panel administrator</p>
    </div>

    @if($errors->any())
        <div class="error-msg">
            <ul>
                @foreach($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="glass-card">
        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="username">Username atau Email</label>
                <div class="input-wrapper">
                    <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan username" value="{{ old('username') }}" required autofocus>
                </div>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" required>
                </div>
            </div>
            
            <button type="submit" class="btn-submit">MASUK KE PANEL</button>
        </form>
    </div>
</div>
@endsection
