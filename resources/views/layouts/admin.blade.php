<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Premium</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4F46E5; /* Indigo 600 */
            --primary-hover: #4338CA; /* Indigo 700 */
            --bg-gradient: #F1F5F9; /* Slate 100 */
            --card-bg: #FFFFFF;
            --card-border: #E2E8F0; /* Slate 200 */
            --text-main: #0F172A; /* Slate 900 */
            --text-muted: #64748B; /* Slate 500 */
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-gradient);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar */
        .admin-navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background: #FFFFFF;
            border-bottom: 1px solid var(--card-border);
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .admin-navbar .logo {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
            letter-spacing: -0.025em;
        }

        .admin-navbar .nav-links a {
            color: var(--text-muted);
            text-decoration: none;
            margin-left: 24px;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .admin-navbar .nav-links a:hover {
            color: var(--primary);
        }

        .btn-logout {
            background: #FEF2F2; /* Red 50 */
            color: #EF4444; /* Red 500 */
            border: 1px solid #FEE2E2; /* Red 100 */
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-logout:hover {
            background: #FEE2E2;
            color: #DC2626; /* Red 600 */
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
            flex: 1;
            width: 100%;
        }

        .glass-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 32px;
            box-shadow: var(--shadow-md);
        }

        /* Shared elements */
        .btn-primary {
            display: inline-block;
            padding: 10px 20px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: var(--shadow-sm);
            text-decoration: none;
            text-align: center;
        }
        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        @yield('extra-css')
    </style>
</head>
<body>
    @auth
    <nav class="admin-navbar">
        <div class="logo">Admin Panel</div>
        <div class="nav-links">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.tokens') }}">Kelola Token</a>
            <a href="{{ route('admin.participants') }}">Hasil Peserta</a>
            <form action="{{ route('admin.logout') }}" method="POST" style="display:inline; margin-left: 20px;">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </nav>
    @endauth

    <div class="container">
        @yield('content')
    </div>

    @yield('extra-js')
</body>
</html>
