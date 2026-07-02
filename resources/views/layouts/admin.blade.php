<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Psychotest - Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Dark theme variables (Default) */
            --primary: #8B5CF6; /* Violet 500 */
            --primary-hover: #7C3AED; /* Violet 600 */
            --primary-glow: rgba(139, 92, 246, 0.15);
            --bg-main: #090B11; /* Dark deep space */
            --bg-radial-1: rgba(139, 92, 246, 0.08);
            --bg-radial-2: rgba(236, 72, 153, 0.06);
            --card-bg: rgba(17, 22, 34, 0.75); /* Sleek glass card */
            --card-border: rgba(255, 255, 255, 0.06);
            --card-border-focus: rgba(139, 92, 246, 0.4);
            --text-main: #F8FAFC; /* Slate 50 */
            --text-muted: #94A3B8; /* Slate 400 */
            --success: #10B981; /* Emerald 500 */
            --error: #EF4444; /* Red 500 */
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.3);
            --shadow-md: 0 8px 24px rgba(0, 0, 0, 0.4);
            --shadow-lg: 0 16px 40px rgba(0, 0, 0, 0.6);
            --font-display: 'Plus Jakarta Sans', sans-serif;
            --font-body: 'Outfit', sans-serif;
            --nav-bg: rgba(9, 11, 17, 0.6);
            --scrollbar-thumb: rgba(255, 255, 255, 0.1);
            --input-bg: rgba(10, 15, 30, 0.6);
            --input-bg-focus: rgba(10, 15, 30, 0.8);
            --chart-container-bg: rgba(10, 15, 30, 0.4);
            --table-th-bg: rgba(255, 255, 255, 0.02);
            --table-row-hover: rgba(255, 255, 255, 0.02);
            --logo-text-gradient: linear-gradient(135deg, #FFF 30%, var(--primary) 100%);
            --btn-secondary-bg: rgba(255, 255, 255, 0.05);
            --btn-secondary-border: rgba(255, 255, 255, 0.08);
            --badge-pill-bg: rgba(139, 92, 246, 0.1);
            --badge-pill-border: rgba(139, 92, 246, 0.2);
            --personality-card-bg: rgba(139, 92, 246, 0.04);
            --personality-card-border: rgba(139, 92, 246, 0.15);
            --personality-mirror-bg: rgba(236, 72, 153, 0.03);
            --personality-mirror-border: rgba(236, 72, 153, 0.15);
            --welcome-banner-border: rgba(139, 92, 246, 0.25);
            --welcome-banner-bg: linear-gradient(135deg, rgba(139, 92, 246, 0.15) 0%, rgba(236, 72, 153, 0.05) 100%);
            --card-hover-border: rgba(255, 255, 255, 0.1);
            --stat-icon-bg: rgba(139, 92, 246, 0.1);
            --stat-icon-border: rgba(139, 92, 246, 0.2);
            --welcome-h1-gradient: linear-gradient(to right, #FFF, #C084FC);
            --login-h1-gradient: linear-gradient(to right, #FFF, #C084FC);
        }

        .light-theme {
            /* Light theme variables */
            --bg-main: #F8FAFC; /* Slate 50 */
            --bg-radial-1: rgba(139, 92, 246, 0.04);
            --bg-radial-2: rgba(236, 72, 153, 0.03);
            --card-bg: rgba(255, 255, 255, 0.85);
            --card-border: rgba(15, 23, 42, 0.08);
            --card-border-focus: rgba(139, 92, 246, 0.6);
            --text-main: #0F172A; /* Slate 900 */
            --text-muted: #64748B; /* Slate 500 */
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 16px rgba(15, 23, 42, 0.06);
            --shadow-lg: 0 12px 32px rgba(15, 23, 42, 0.08);
            --nav-bg: rgba(255, 255, 255, 0.8);
            --scrollbar-thumb: rgba(15, 23, 42, 0.15);
            --input-bg: rgba(255, 255, 255, 0.85);
            --input-bg-focus: #FFFFFF;
            --chart-container-bg: rgba(255, 255, 255, 0.5);
            --table-th-bg: rgba(15, 23, 42, 0.02);
            --table-row-hover: rgba(15, 23, 42, 0.015);
            --logo-text-gradient: linear-gradient(135deg, #0F172A 30%, var(--primary) 100%);
            --btn-secondary-bg: rgba(15, 23, 42, 0.03);
            --btn-secondary-border: rgba(15, 23, 42, 0.08);
            --badge-pill-bg: rgba(139, 92, 246, 0.07);
            --badge-pill-border: rgba(139, 92, 246, 0.15);
            --personality-card-bg: rgba(139, 92, 246, 0.02);
            --personality-card-border: rgba(139, 92, 246, 0.1);
            --personality-mirror-bg: rgba(236, 72, 153, 0.02);
            --personality-mirror-border: rgba(236, 72, 153, 0.1);
            --welcome-banner-border: rgba(139, 92, 246, 0.15);
            --welcome-banner-bg: linear-gradient(135deg, rgba(139, 92, 246, 0.06) 0%, rgba(236, 72, 153, 0.02) 100%);
            --card-hover-border: rgba(15, 23, 42, 0.15);
            --stat-icon-bg: rgba(139, 92, 246, 0.06);
            --stat-icon-border: rgba(139, 92, 246, 0.15);
            --welcome-h1-gradient: linear-gradient(to right, #0F172A, #6D28D9);
            --login-h1-gradient: linear-gradient(to right, #0F172A, #6D28D9);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: var(--bg-main);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--scrollbar-thumb);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: var(--font-body);
            background-color: var(--bg-main);
            background-image: 
                radial-gradient(circle at 10% 20%, var(--bg-radial-1) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, var(--bg-radial-2) 0%, transparent 45%);
            background-attachment: fixed;
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            transition: background-color 0.3s ease, color 0.3s ease, background-image 0.3s ease;
        }

        /* Navbar */
        .admin-navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 40px;
            background: var(--nav-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--card-border);
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
            transition: background 0.3s ease, border-bottom 0.3s ease;
        }

        .admin-navbar .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .admin-navbar .logo-dot {
            width: 10px;
            height: 10px;
            background: var(--primary);
            border-radius: 50%;
            box-shadow: 0 0 10px var(--primary);
        }

        .admin-navbar .logo-text {
            font-family: var(--font-display);
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.03em;
            background: var(--logo-text-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .admin-navbar .logo-badge {
            background: rgba(139, 92, 246, 0.15);
            border: 1px solid rgba(139, 92, 246, 0.3);
            color: var(--primary);
            font-size: 0.7rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Hamburger Menu Trigger Button on Navbar */
        .btn-menu-toggle {
            background: none;
            border: 1px solid var(--card-border);
            padding: 10px;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            width: 40px;
            height: 40px;
            transition: all 0.25s ease;
        }

        .btn-menu-toggle:hover {
            border-color: var(--card-border-focus);
            background: var(--btn-secondary-bg);
        }

        .hamburger-line {
            width: 100%;
            height: 2px;
            background-color: var(--text-main);
            border-radius: 2px;
            transition: all 0.25s ease;
        }

        /* Backdrop Overlay for Drawer */
        .menu-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 99;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .menu-backdrop.open {
            opacity: 1;
            pointer-events: auto;
        }

        /* Right-Side Drawer Panel */
        .menu-drawer {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            width: 320px;
            background: var(--card-bg);
            border-left: 1px solid var(--card-border);
            box-shadow: var(--shadow-lg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            z-index: 100;
            transform: translateX(100%);
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            flex-direction: column;
        }

        .menu-drawer.open {
            transform: translateX(0);
        }

        .drawer-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px;
            border-bottom: 1px solid var(--card-border);
        }

        .drawer-title {
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 1.25rem;
            letter-spacing: -0.02em;
            color: var(--text-main);
        }

        .btn-drawer-close {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 6px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .btn-drawer-close:hover {
            color: var(--text-main);
            background: var(--btn-secondary-bg);
        }

        .btn-drawer-close svg {
            width: 20px;
            height: 20px;
        }

        .drawer-content {
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            flex: 1;
        }

        .drawer-theme-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--btn-secondary-bg);
            padding: 12px 16px;
            border-radius: 12px;
            border: 1px solid var(--btn-secondary-border);
        }

        .theme-label {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        /* Toggle Theme Switcher inside Drawer */
        .btn-theme-toggle {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            color: var(--text-muted);
            padding: 8px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
        }

        .btn-theme-toggle:hover {
            color: var(--text-main);
            border-color: var(--card-border-focus);
            background: var(--btn-secondary-bg);
        }

        .theme-icon {
            width: 18px;
            height: 18px;
        }

        .hidden {
            display: none !important;
        }

        .drawer-divider {
            height: 1px;
            background: var(--card-border);
            margin: 4px 0;
        }

        .drawer-links {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .drawer-link {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text-muted);
            text-decoration: none;
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1rem;
            padding: 12px 16px;
            border-radius: 10px;
            transition: all 0.25s ease;
            border: 1px solid transparent;
        }

        .drawer-link:hover {
            color: var(--text-main);
            background: var(--btn-secondary-bg);
            border-color: var(--btn-secondary-border);
        }

        .drawer-link.active {
            color: white;
            background: var(--primary);
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
            border-color: var(--primary-hover);
        }

        .drawer-link.active .link-icon {
            color: white;
        }

        .link-icon {
            width: 18px;
            height: 18px;
            color: var(--text-muted);
            transition: color 0.25s ease;
        }

        .drawer-link:hover .link-icon {
            color: var(--text-main);
        }

        .btn-drawer-logout {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: rgba(239, 68, 68, 0.08);
            color: #EF4444;
            border: 1px solid rgba(239, 68, 68, 0.15);
            padding: 14px;
            border-radius: 10px;
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: auto; /* Push to bottom of content */
        }

        .btn-drawer-logout:hover {
            background: #EF4444;
            color: white;
            box-shadow: 0 0 15px rgba(239, 68, 68, 0.3);
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 24px;
            flex: 1;
            width: 100%;
        }

        /* Smooth visual entry for elements */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .glass-card, .welcome-banner {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 32px;
            box-shadow: var(--shadow-md);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease, border-color 0.3s ease;
            animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        .welcome-banner {
            animation-delay: 0.05s;
        }
        
        .glass-card {
            animation-delay: 0.1s;
        }
        
        .glass-card:hover {
            border-color: var(--card-hover-border);
        }

        /* Shared Buttons */
        .btn-primary {
            display: inline-block;
            padding: 12px 24px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 10px;
            font-family: var(--font-display);
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 14px rgba(139, 92, 246, 0.3);
            text-decoration: none;
            text-align: center;
        }
        
        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(139, 92, 246, 0.45);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }

        @yield('extra-css')
    </style>
    <script>
        // Check local storage or system preference to apply theme early before page render
        if (localStorage.getItem('color-theme') === 'light' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: light)').matches)) {
            document.documentElement.classList.add('light-theme');
        } else {
            document.documentElement.classList.remove('light-theme');
        }
    </script>
</head>
<body>
    @auth
    <nav class="admin-navbar">
        <a href="{{ route('admin.dashboard') }}" class="logo-container">
            <div class="logo-dot"></div>
            <div class="logo-text">Digital</div>
            <div class="logo-badge">Admin</div>
        </a>
        
        <!-- Hamburger Menu Button on the Right -->
        <button id="menu-toggle" class="btn-menu-toggle" aria-label="Open Menu">
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
        </button>
    </nav>

    <!-- Backdrop Overlay -->
    <div id="menu-backdrop" class="menu-backdrop"></div>

    <!-- Right-side Drawer Menu -->
    <div id="menu-drawer" class="menu-drawer">
        <div class="drawer-header">
            <h3 class="drawer-title">Menu Panel</h3>
            <button id="menu-close" class="btn-drawer-close" aria-label="Close Menu">
                <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="drawer-content">
            <!-- Theme Toggle at the very top of Drawer -->
            <div class="drawer-theme-section">
                <span class="theme-label">Ubah Tema</span>
                <button id="theme-toggle" class="btn-theme-toggle" aria-label="Toggle Theme">
                    <!-- Moon icon (shows in light theme to switch to dark) -->
                    <svg id="theme-toggle-dark-icon" class="theme-icon hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"></path>
                    </svg>
                    <!-- Sun icon (shows in dark theme to switch to light) -->
                    <svg id="theme-toggle-light-icon" class="theme-icon hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m0 13.5V21m8.966-8.966h-2.25m-13.5 0h-2.25m15.356-8.284l-1.592 1.592m-12.483 12.483l-1.592 1.592m15.356 0l-1.592-1.592M7.129 7.129L5.536 5.536M8.25 12a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0z"></path>
                    </svg>
                </button>
            </div>

            <div class="drawer-divider"></div>

            <!-- Navigation Links -->
            <div class="drawer-links">
                <a href="{{ route('admin.dashboard') }}" class="drawer-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg class="link-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"></path>
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.tokens') }}" class="drawer-link {{ request()->routeIs('admin.tokens') ? 'active' : '' }}">
                    <svg class="link-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z"></path>
                    </svg>
                    Kelola Token
                </a>
                <a href="{{ route('admin.participants') }}" class="drawer-link {{ request()->routeIs('admin.participants*') ? 'active' : '' }}">
                    <svg class="link-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.97 5.97 0 00-.75-2.985m-.001-3.975a3.75 3.75 0 10-7.5 0m7.5 0a3.75 3.75 0 01-7.5 0m0 0a3.75 3.75 0 10-7.5 0M3 16.062a9 9 0 0114.25-7.14M18 18.72V19a2 2 0 01-2 2H8a2 2 0 01-2-2v-.281c0-.498-.07-1.002-.207-1.488l-.203-.709A6 6 0 0111.374 9.75h1.252a6 6 0 015.786 4.316l.203.709c.137.486.207.99.207 1.488z"></path>
                    </svg>
                    Hasil Peserta
                </a>
            </div>

            <div class="drawer-divider"></div>

            <!-- Logout inside Drawer -->
            <form action="{{ route('admin.logout') }}" method="POST" style="display:block; margin-top: auto;">
                @csrf
                <button type="submit" class="btn-drawer-logout">
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"></path>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </div>
    @endauth

    <div class="container">
        @yield('content')
    </div>

    @auth
    <script>
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        // Drawer elements
        const menuToggleBtn = document.getElementById('menu-toggle');
        const menuCloseBtn = document.getElementById('menu-close');
        const menuDrawer = document.getElementById('menu-drawer');
        const menuBackdrop = document.getElementById('menu-backdrop');

        // Function to update theme icon visibility based on document state
        function updateIcons() {
            if (document.documentElement.classList.contains('light-theme')) {
                themeToggleDarkIcon.classList.remove('hidden');
                themeToggleLightIcon.classList.add('hidden');
            } else {
                themeToggleLightIcon.classList.remove('hidden');
                themeToggleDarkIcon.classList.add('hidden');
            }
        }

        // Initialize icons
        updateIcons();

        // Toggle Theme action
        themeToggleBtn.addEventListener('click', function() {
            if (document.documentElement.classList.contains('light-theme')) {
                document.documentElement.classList.remove('light-theme');
                localStorage.setItem('color-theme', 'dark');
            } else {
                document.documentElement.classList.add('light-theme');
                localStorage.setItem('color-theme', 'light');
            }
            updateIcons();
            
            // Dispatch custom theme changed event for dynamic components (like Chart.js)
            window.dispatchEvent(new Event('theme-changed'));
        });

        // Drawer open/close functions
        function openMenu() {
            menuDrawer.classList.add('open');
            menuBackdrop.classList.add('open');
            document.body.style.overflow = 'hidden'; // prevent background scrolling
        }

        function closeMenu() {
            menuDrawer.classList.remove('open');
            menuBackdrop.classList.remove('open');
            document.body.style.overflow = '';
        }

        if (menuToggleBtn) menuToggleBtn.addEventListener('click', openMenu);
        if (menuCloseBtn) menuCloseBtn.addEventListener('click', closeMenu);
        if (menuBackdrop) menuBackdrop.addEventListener('click', closeMenu);
    </script>
    @endauth

    @yield('extra-js')
</body>
</html>
