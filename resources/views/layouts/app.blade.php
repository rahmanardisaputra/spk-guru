<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SPK Guru Terbaik - SD Muhammadiyah Sang Pencerah</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #1a7a5c;
            --primary-dark: #145f47;
            --primary-light: #e8f5f0;
            --sidebar-width: 270px;
            --accent: #f39c12;
        }

        * { font-family: 'Inter', sans-serif; }

        body {
            background-color: #f0f2f5;
            overflow-x: hidden;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--primary-dark) 0%, var(--primary) 100%);
            z-index: 1040;
            transition: all 0.3s ease;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 24px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-brand img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255,255,255,0.3);
            margin-bottom: 10px;
            background: #fff;
            padding: 4px;
        }

        .sidebar-brand h5 {
            color: #fff;
            font-weight: 700;
            font-size: 14px;
            margin: 0;
            line-height: 1.4;
        }

        .sidebar-brand small {
            color: rgba(255,255,255,0.6);
            font-size: 11px;
        }

        .sidebar-menu {
            padding: 16px 12px;
        }

        .sidebar-menu .menu-label {
            color: rgba(255,255,255,0.4);
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 10px 16px 6px;
        }

        .sidebar-menu .nav-link {
            color: rgba(255,255,255,0.75);
            padding: 11px 16px;
            border-radius: 10px;
            margin-bottom: 3px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s ease;
        }

        .sidebar-menu .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 15px;
        }

        .sidebar-menu .nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,0.12);
            transform: translateX(4px);
        }

        .sidebar-menu .nav-link.active {
            color: var(--primary-dark);
            background: #fff;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* ===== TOP NAVBAR ===== */
        .top-navbar {
            background: #fff;
            padding: 14px 30px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06);
            position: sticky;
            top: 0;
            z-index: 1030;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .top-navbar .page-title {
            font-weight: 600;
            font-size: 18px;
            color: #2c3e50;
            margin: 0;
        }

        .top-navbar .user-dropdown .btn {
            border: none;
            background: var(--primary-light);
            color: var(--primary);
            font-weight: 600;
            font-size: 13px;
            padding: 8px 16px;
            border-radius: 25px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .top-navbar .user-dropdown .btn:hover {
            background: var(--primary);
            color: #fff;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--primary);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
        }

        /* ===== CONTENT AREA ===== */
        .content-area {
            padding: 28px 30px;
        }

        /* ===== SIDEBAR TOGGLE (Mobile) ===== */
        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 22px;
            color: var(--primary);
            cursor: pointer;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1035;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .sidebar-overlay.active {
                display: block;
            }
            .main-content {
                margin-left: 0;
            }
            .sidebar-toggle {
                display: block;
            }
        }

        /* ===== SCROLLBAR SIDEBAR ===== */
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 4px; }
    </style>
</head>
<body>

    {{-- Sidebar Overlay (Mobile) --}}
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    {{-- ===== SIDEBAR ===== --}}
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            {{-- Ganti src di bawah dengan path logo sekolahmu --}}
            <img src="data:image/png;base64,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" alt="Logo"
                 onerror="this.src='https://ui-avatars.com/api/?name=SD+MSP&background=1a7a5c&color=fff&size=128&bold=true'">
            <h5>SD Muhammadiyah<br>Sang Pencerah</h5>
            <small>Kota Metro</small>
        </div>

        <nav class="sidebar-menu">
            @guest
                <div class="menu-label">Menu</div>
                <a class="nav-link" href="{{ route('login') }}">
                    <i class="fa-solid fa-right-to-bracket"></i> Masuk
                </a>
            @else
                <div class="menu-label">Utama</div>
                <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                    <i class="fa-solid fa-gauge-high"></i> Dashboard
                </a>

                @if(Auth::user()->role == 'tu')
                    <div class="menu-label">Data Master</div>
                    <a class="nav-link {{ request()->routeIs('guru.*') ? 'active' : '' }}" href="{{ route('guru.index') }}">
                        <i class="fa-solid fa-chalkboard-user"></i> Data Guru
                    </a>
                    <div class="menu-label">Cetak Dokumen</div>
                    <a class="nav-link {{ request()->routeIs('reward.tu') ? 'active' : '' }}" href="{{ route('reward.tu') }}">
                        <i class="fa-solid fa-certificate"></i> Sertifikat Penghargaan
                    </a>
                @endif

                @if(Auth::user()->role == 'kepala_sekolah')
                    <div class="menu-label">Data Master</div>
                    <a class="nav-link {{ request()->routeIs('kriteria.*') ? 'active' : '' }}" href="{{ route('kriteria.index') }}">
                        <i class="fa-solid fa-list-check"></i> Data Kriteria
                    </a>

                    <div class="menu-label">SPK</div>
                    <a class="nav-link {{ request()->routeIs('kandidat.*') ? 'active' : '' }}" href="{{ route('kandidat.index') }}">
                        <i class="fa-solid fa-users"></i> Kandidat Penilaian
                    </a>
                    <a class="nav-link {{ request()->routeIs('floating.*') ? 'active' : '' }}" href="{{ route('floating.index') }}">
                        <i class="fa-solid fa-network-wired"></i> Floating Tugas
                    </a>
                    <a class="nav-link {{ request()->routeIs('perhitungan.*') ? 'active' : '' }}" href="{{ route('perhitungan.index') }}">
                        <i class="fa-solid fa-calculator"></i> Perhitungan Hasil
                    </a>
                    <div class="menu-label">Manajemen Pengguna</div>
                    <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                        <i class="fa-solid fa-users-gear"></i> Manajemen Akun
                    </a>
                @endif

                @if(Auth::user()->role == 'guru_supervisi' || Auth::user()->role == 'kepala_sekolah')
                    <div class="menu-label">Evaluasi</div>
                    <a class="nav-link {{ request()->routeIs('penilaian.*') ? 'active' : '' }}" href="{{ route('penilaian.index') }}">
                        <i class="fa-solid fa-clipboard-check"></i> Penilaian
                    </a>
                @endif

                @if(Auth::user()->role == 'guru')
                 <div class="menu-label">Evaluasi</div>
                    <a class="nav-link {{ request()->routeIs('reward.*') ? 'active' : '' }}" href="{{ route('reward.guru') }}">
                        <i class="fa-solid fa-clipboard-check"></i> Info Penghargaan
                    </a>
                
                @endif
                @if(Auth::user()->role == 'kepala_sekolah')
                 <div class="menu-label">Evaluasi</div>
                    <a class="nav-link {{ request()->routeIs('reward.*') ? 'active' : '' }}" href="{{ route('reward.admin') }}">
                        <i class="fa-solid fa-clipboard-check"></i> Audit Berkas Guru Terbaik
                    </a>
                
                @endif

                <div class="menu-label">Akun</div>
                <a class="nav-link" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa-solid fa-power-off"></i> Keluar
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            @endguest
        </nav>
    </aside>

    {{-- ===== MAIN CONTENT ===== --}}
    <div class="main-content">

        {{-- Top Navbar --}}
        <div class="top-navbar">
            <div class="d-flex align-items-center gap-3">
                <button class="sidebar-toggle" onclick="toggleSidebar()">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h5 class="page-title mb-0">@yield('page-title', 'Dashboard')</h5>
            </div>

            @auth
            <div class="user-dropdown dropdown">
                <button class="btn dropdown-toggle" data-bs-toggle="dropdown">
                    <span class="user-avatar">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                    <li class="px-3 py-2 border-bottom">
                        <small class="text-muted">Login sebagai</small><br>
                        <a href="{{ route('profile.edit') }}" class="dropdown-item py-1 px-3">
                            <i class="fa-solid fa-user me-1"></i> {{ Auth::user()->name }}
                        </a>
                         <strong class="dropdown-item py-1 px-3 text-primary" style="font-size: 13px;">
                             <i class="fa-solid fa-id-badge me-1"></i> {{ ucfirst(str_replace('_',' ', Auth::user()->role)) }}
                         </strong>
                    </li>
                    <li>
                        <a class="dropdown-item py-2" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa-solid fa-power-off text-danger me-2"></i> Keluar
                        </a>
                    </li>
                </ul>
            </div>
            @endauth
        </div>

        {{-- Page Content --}}
        <div class="content-area">
            @yield('content')
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('sidebarOverlay').classList.toggle('active');
        }
    </script>

    {{-- Auto highlight active menu --}}
    @hasSection('page-title')
    <script>
        // Optional: set active class based on URL
    </script>
    @endif

</body>
</html>