<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Telda Labuan Bajo' }}</title>
    @yield('head')
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{--stroke:rgb(71 85 105)}
        *{font-family:'Inter',system-ui,-apple-system,Segoe UI,Roboto,sans-serif}
        .panel{border:1px solid rgb(51 65 85);background:rgba(15,23,42,.55);border-radius:22px}
        .panel-soft{border:1px solid rgb(51 65 85);background:rgba(2,6,23,.72);border-radius:999px}
        .btn-main{border:1px solid rgb(148 163 184);background:#0b1120;color:#f8fafc;border-radius:999px;padding:.55rem 1.1rem}
        .btn-main:hover{background:#111827}
        .btn-danger{border:1px solid rgb(239 68 68 / .6);background:rgb(127 29 29 / .28);color:#fecaca;border-radius:999px;padding:.35rem .85rem}
        .input-dark{width:100%;border:1px solid rgb(71 85 105);background:rgba(2,6,23,.65);border-radius:14px;padding:.55rem .75rem;outline:none}
        .input-dark:focus{border-color:rgb(148 163 184)}
        .page-title{font-size:1.5rem;font-weight:700;letter-spacing:.01em}
        .page-subtitle{font-size:.9rem;color:rgb(148 163 184)}
        .table-shell{overflow:hidden;border:1px solid var(--stroke);border-radius:22px;background:rgba(2,6,23,.45)}
        .table-shell table thead{background:rgba(15,23,42,.85)}
        .table-shell table th{font-weight:600;color:rgb(226 232 240)}
        .table-shell table td{color:rgb(226 232 240)}
        .badge-node{display:inline-flex;align-items:center;border:1px solid rgb(100 116 139);border-radius:999px;padding:.2rem .65rem;font-size:.72rem;background:rgba(15,23,42,.8)}
    </style>
</head>
<body class="@yield('body_class', 'min-h-screen bg-black text-slate-100')">
    <div class="min-h-screen bg-[linear-gradient(to_bottom,_#000,_#020617)]">
        @auth
            @php
                $hideAppNav = trim($__env->yieldContent('hide_app_nav')) === '1';
            @endphp
        @endauth

        @auth
            @if (! $hideAppNav)
            <nav class="sticky top-0 z-40 border-b border-slate-800/80 bg-slate-950/80 backdrop-blur">
                <div class="mx-auto max-w-6xl px-4 py-4 flex items-center justify-between gap-4">
                    <a href="{{ route('dashboard') }}" class="font-semibold tracking-wide flex items-center gap-2">
                        <span class="inline-flex size-2.5 rounded-full bg-white"></span>
                        <span>Telda Labuan Bajo</span>
                    </a>

                    <div class="flex items-center gap-2 text-sm">
                        <a class="px-3 py-2 rounded-full border border-slate-700 hover:bg-slate-800/60 {{ request()->routeIs('indibiz.*') ? 'bg-slate-800/70' : '' }}" href="{{ route('indibiz.index') }}">Indibiz</a>
                        <a class="px-3 py-2 rounded-full border border-slate-700 hover:bg-slate-800/60 {{ request()->routeIs('survey.*') ? 'bg-slate-800/70' : '' }}" href="{{ route('survey.index') }}">Survey</a>
                        @can('admin')
                            <a class="px-3 py-2 rounded-full border border-slate-700 hover:bg-slate-800/60 {{ request()->routeIs('aktivitas.*') ? 'bg-slate-800/70' : '' }}" href="{{ route('aktivitas.index') }}">Aktivitas</a>
                        @endcan
                    </div>

                    <div class="flex items-center gap-3 text-sm">
                        <div class="hidden sm:block text-slate-300">
                            {{ auth()->user()->nama_lengkap }} • {{ auth()->user()->role }}
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="px-3 py-2 rounded-full bg-slate-800/70 hover:bg-slate-700/70 border border-slate-700 transition">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </nav>
            @endif
        @endauth

        <main class="mx-auto max-w-6xl px-4 py-8">
            @include('partials.flash')
            {{ $slot ?? '' }}
            @yield('content')
        </main>
    </div>
</body>
</html>

