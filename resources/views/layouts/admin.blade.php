<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ $title ?? 'Sistem Manajemen Telda - Labuan Bajo' }}</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary-container": "#d6e3ff","on-background": "#2b3437","on-error": "#fff7f6","primary-dim": "#0051a1",
                        "surface-container-lowest": "#ffffff","inverse-surface": "#0c0f10","on-tertiary-fixed": "#383751","tertiary-container": "#d9d7f8",
                        "outline": "#737c7f","on-secondary-fixed-variant": "#455f6b","on-tertiary-container": "#4b4a65","surface-container-highest": "#dbe4e7",
                        "on-tertiary-fixed-variant": "#54536f","on-secondary": "#f2faff","error": "#9f403d","secondary-fixed-dim": "#bdd9e6",
                        "secondary-container": "#cbe7f5","on-tertiary": "#fbf7ff","surface-tint": "#185eb0","secondary": "#49636f","tertiary": "#5d5c78",
                        "surface-container": "#eaeff1","surface-container-low": "#f1f4f6","tertiary-dim": "#51506c","primary-fixed-dim": "#c0d5ff",
                        "outline-variant": "#abb3b7","secondary-fixed": "#cbe7f5","inverse-on-surface": "#9b9d9e","surface-bright": "#f8f9fa",
                        "surface-variant": "#dbe4e7","on-primary-fixed": "#003e7e","on-secondary-container": "#3c5561","on-secondary-fixed": "#29434e",
                        "tertiary-fixed": "#d9d7f8","on-error-container": "#752121","error-container": "#fe8983","on-surface": "#2b3437",
                        "primary-fixed": "#d6e3ff","on-surface-variant": "#586064","surface": "#f8f9fa","primary": "#185eb0","on-primary-fixed-variant": "#125bad",
                        "on-primary": "#f7f7ff","secondary-dim": "#3d5762","surface-dim": "#d1dce0","tertiary-fixed-dim": "#cbc9e9","background": "#f8f9fa",
                        "on-primary-container": "#0051a0","error-dim": "#4e0309","inverse-primary": "#70a6fe","surface-container-high": "#e3e9ec"
                    },
                    borderRadius: { lg: "0.25rem", xl: "0.5rem" },
                    fontFamily: { headline: ["Manrope"], body: ["Inter"], label: ["Inter"] }
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; color: #2b3437; margin: 0; }
        .font-headline { font-family: 'Manrope', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    </style>
    @stack('head')
</head>
<body class="bg-surface selection:bg-primary-container selection:text-on-primary-container">
<aside class="flex flex-col h-screen fixed left-0 top-0 z-40 bg-[#f1f4f6] w-64 border-r-0 font-body">
    <div class="px-6 py-8">
        <h1 class="text-lg font-bold text-[#2b3437] tracking-tight font-headline">Telda Labuan Bajo</h1>
        <p class="text-[11px] uppercase tracking-wider text-on-surface-variant font-medium mt-1">Sistem Manajemen</p>
    </div>
    <nav class="flex-1 px-4 space-y-1">
        <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('dashboard') ? 'border-l-4 border-[#185eb0] text-[#185eb0] font-semibold bg-[#d6e3ff]' : 'text-[#49636f] hover:text-[#185eb0] hover:bg-[#dbe4e7]' }}" href="{{ route('dashboard') }}">
            <span class="material-symbols-outlined">dashboard</span><span class="text-sm">Dashboard</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('indibiz.*') ? 'border-l-4 border-[#185eb0] text-[#185eb0] font-semibold bg-[#d6e3ff]' : 'text-[#49636f] hover:text-[#185eb0] hover:bg-[#dbe4e7]' }}" href="{{ route('indibiz.index') }}">
            <span class="material-symbols-outlined">database</span><span class="text-sm">Data Indibiz</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('survey.*') ? 'border-l-4 border-[#185eb0] text-[#185eb0] font-semibold bg-[#d6e3ff]' : 'text-[#49636f] hover:text-[#185eb0] hover:bg-[#dbe4e7]' }}" href="{{ route('survey.index') }}">
            <span class="material-symbols-outlined">fact_check</span><span class="text-sm">Data Survei</span>
        </a>
        @if (auth()->user()->role === 'admin')
            <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('aktivitas.*') ? 'border-l-4 border-[#185eb0] text-[#185eb0] font-semibold bg-[#d6e3ff]' : 'text-[#49636f] hover:text-[#185eb0] hover:bg-[#dbe4e7]' }}" href="{{ route('aktivitas.index') }}">
                <span class="material-symbols-outlined">history</span><span class="text-sm">Aktivitas</span>
            </a>
        @endif
    </nav>
    <div class="px-4 py-6 mt-auto bg-[#eaeff1] space-y-1">
        <a class="flex items-center gap-3 px-4 py-2 text-[#49636f] hover:text-[#185eb0] text-sm" href="#">
            <span class="material-symbols-outlined text-lg">settings</span><span>Pengaturan</span>
        </a>
        <form method="POST" action="{{ route('logout') }}" class="px-4 py-2">
            @csrf
            <button class="flex items-center gap-3 text-[#49636f] hover:text-error text-sm">
                <span class="material-symbols-outlined text-lg">logout</span><span>Keluar</span>
            </button>
        </form>
    </div>
</aside>

<header class="flex justify-between items-center w-full px-8 py-4 ml-64 max-w-[calc(100%-16rem)] bg-white/80 backdrop-blur-md sticky top-0 border-b border-[#f1f4f6] z-30 shadow-sm">
    <div class="flex items-center gap-6">
        <div class="relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-xl">search</span>
            <input class="bg-surface-container-low border-none rounded-lg pl-10 pr-4 py-2 text-sm w-80 focus:ring-2 focus:ring-primary/20 transition-all" placeholder="Cari catatan sistem..." type="text"/>
        </div>
    </div>
    <div class="flex items-center gap-4">
        <button class="w-10 h-10 flex items-center justify-center rounded-full text-slate-500 hover:bg-surface-container transition-all">
            <span class="material-symbols-outlined">notifications</span>
        </button>
        <div class="h-8 w-[1px] bg-outline-variant/20 mx-2"></div>
        <div class="flex items-center gap-3">
            <div class="text-right">
                <p class="text-xs font-bold text-on-surface">{{ auth()->user()->nama_lengkap }}</p>
                <p class="text-[10px] text-on-surface-variant uppercase tracking-tighter">{{ auth()->user()->role }}</p>
            </div>
            <div class="w-10 h-10 rounded-full bg-primary-container border-2 border-primary-container flex items-center justify-center text-primary font-bold">
                {{ strtoupper(substr(auth()->user()->nama_lengkap, 0, 1)) }}
            </div>
        </div>
    </div>
</header>

<main class="ml-64 p-8 min-h-screen">
    @include('partials.flash')
    @yield('content')
</main>

@stack('scripts')
</body>
</html>
