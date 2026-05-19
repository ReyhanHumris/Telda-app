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

<!-- Overlay Mobile -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-30 hidden md:hidden transition-opacity opacity-0"></div>

<aside id="sidebar" class="flex flex-col h-screen fixed left-0 top-0 z-40 bg-[#f1f4f6] w-64 border-r-0 font-body -translate-x-full md:translate-x-0 transition-transform duration-300">
    <div class="px-6 py-8 flex justify-between items-center">
        <div>
            <h1 class="text-lg font-bold text-[#2b3437] tracking-tight font-headline">Telda Labuan Bajo</h1>
            <p class="text-[11px] uppercase tracking-wider text-on-surface-variant font-medium mt-1">Sistem Manajemen</p>
        </div>
        <button id="closeSidebarBtn" class="md:hidden text-on-surface-variant hover:text-error transition-colors">
            <span class="material-symbols-outlined">close</span>
        </button>
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
            <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('pengguna.*') ? 'border-l-4 border-[#185eb0] text-[#185eb0] font-semibold bg-[#d6e3ff]' : 'text-[#49636f] hover:text-[#185eb0] hover:bg-[#dbe4e7]' }}" href="{{ route('pengguna.index') }}">
                <span class="material-symbols-outlined">group</span><span class="text-sm">Kelola User</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('aktivitas.*') ? 'border-l-4 border-[#185eb0] text-[#185eb0] font-semibold bg-[#d6e3ff]' : 'text-[#49636f] hover:text-[#185eb0] hover:bg-[#dbe4e7]' }}" href="{{ route('aktivitas.index') }}">
                <span class="material-symbols-outlined">history</span><span class="text-sm">Aktivitas</span>
            </a>
        @endif
    </nav>
    <div class="px-4 py-6 mt-auto bg-[#eaeff1] space-y-1">
        <a class="flex items-center gap-3 px-4 py-2 text-[#49636f] hover:text-[#185eb0] text-sm" href="{{ route('profile.edit') }}">
            <span class="material-symbols-outlined text-lg">person</span><span>Profil Saya</span>
        </a>
        <form method="POST" action="{{ route('logout') }}" class="px-4 py-2" data-swal-confirm data-swal-title="Konfirmasi Logout" data-swal-text="Apakah Anda yakin ingin keluar dari sistem?" data-swal-confirm-btn="Ya, Keluar" data-swal-icon="question">
            @csrf
            <button type="submit" class="flex items-center gap-3 text-[#49636f] hover:text-error text-sm w-full text-left">
                <span class="material-symbols-outlined text-lg">logout</span><span>Keluar</span>
            </button>
        </form>
    </div>
</aside>

<header class="flex justify-between items-center w-full px-4 md:px-8 py-4 md:ml-64 md:max-w-[calc(100%-16rem)] bg-white/80 backdrop-blur-md sticky top-0 border-b border-[#f1f4f6] z-20 shadow-sm">
    <div class="flex items-center gap-4">
        <button id="openSidebarBtn" class="md:hidden w-10 h-10 flex items-center justify-center rounded-lg bg-surface-container hover:bg-surface-container-high transition-colors text-on-surface">
            <span class="material-symbols-outlined">menu</span>
        </button>
        <div class="relative hidden sm:block">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-xl">search</span>
            <input class="bg-surface-container-low border-none rounded-lg pl-10 pr-4 py-2 text-sm w-48 lg:w-80 focus:ring-2 focus:ring-primary/20 transition-all" placeholder="Cari catatan..." type="text"/>
        </div>
    </div>
    <div class="flex items-center gap-2">
        <div class="relative">
            <button id="notifButton" class="w-10 h-10 flex items-center justify-center rounded-full text-slate-500 hover:bg-surface-container hover:text-primary transition-all relative group">
                <span class="material-symbols-outlined group-hover:scale-110 transition-transform">notifications</span>
                @if(isset($notifications) && $notifications->count() > 0)
                    <span class="absolute top-2 right-2 w-2.5 h-2.5 bg-error rounded-full border-2 border-white animate-pulse"></span>
                @endif
            </button>
            
            <div id="notifDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-xl shadow-surface-dim/20 border border-outline-variant/10 overflow-hidden z-50 transform origin-top-right transition-all">
                <div class="px-4 py-3 bg-surface-container-low border-b border-outline-variant/10 flex justify-between items-center">
                    <h3 class="text-sm font-bold text-on-surface">Notifikasi Sistem</h3>
                    <span class="text-[10px] bg-primary text-on-primary px-2 py-0.5 rounded-full font-bold">Baru</span>
                </div>
                <div class="max-h-80 overflow-y-auto scrollbar-thin">
                    @forelse($notifications ?? [] as $notif)
                        <div class="px-4 py-3 border-b border-outline-variant/5 hover:bg-surface-container-lowest transition-colors flex gap-3 cursor-pointer">
                            <div class="w-8 h-8 rounded-full bg-primary-container text-primary flex items-center justify-center flex-shrink-0 mt-0.5">
                                <span class="material-symbols-outlined text-[16px]">history</span>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-on-surface line-clamp-1">{{ $notif->nama_aktivitas }}</p>
                                <p class="text-[11px] text-on-surface-variant line-clamp-2 mt-0.5">{{ $notif->keterangan }}</p>
                                <p class="text-[9px] text-primary mt-1.5 font-bold uppercase tracking-widest">{{ $notif->tanggal_aktivitas->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="px-4 py-8 text-center">
                            <span class="material-symbols-outlined text-4xl text-outline-variant opacity-50 mb-2">notifications_paused</span>
                            <p class="text-xs font-bold text-on-surface-variant">Belum ada notifikasi terkini.</p>
                        </div>
                    @endforelse
                </div>
                @if(auth()->user()->role === 'admin')
                    <div class="p-2 border-t border-outline-variant/10 text-center bg-surface-container-lowest hover:bg-surface-container-low transition-colors">
                        <a href="{{ route('aktivitas.index') }}" class="block text-[11px] font-bold text-primary py-1 uppercase tracking-widest">Lihat Semua Log Aktivitas</a>
                    </div>
                @endif
            </div>
        </div>

        <div class="h-6 w-[1px] bg-outline-variant/30 mx-2"></div>
        
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 hover:bg-surface-container-high px-3 py-1.5 rounded-xl transition-all group">
            <div class="text-right hidden sm:block">
                <p class="text-xs font-bold text-on-surface group-hover:text-primary transition-colors">{{ auth()->user()->nama_lengkap }}</p>
                <p class="text-[10px] text-on-surface-variant uppercase tracking-tighter group-hover:text-primary/70">{{ auth()->user()->role }}</p>
            </div>
            @if (auth()->user()->foto)
                <img src="{{ auth()->user()->foto_url }}" alt="Profile" class="w-10 h-10 rounded-full object-cover border-2 border-primary-container shadow-sm group-hover:border-primary transition-colors group-hover:scale-105">
            @else
                <div class="w-10 h-10 rounded-full bg-primary-container border-2 border-primary-container flex items-center justify-center text-primary font-bold group-hover:bg-primary group-hover:text-white group-hover:border-primary transition-all group-hover:scale-105 shadow-sm">
                    {{ strtoupper(substr(auth()->user()->nama_lengkap, 0, 1)) }}
                </div>
            @endif
        </a>
    </div>
</header>

<main class="md:ml-64 p-4 md:p-8 min-h-screen">
    @include('partials.flash')
    @yield('content')
</main>

@stack('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Mobile Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const openBtn = document.getElementById('openSidebarBtn');
        const closeBtn = document.getElementById('closeSidebarBtn');

        function toggleSidebar(show) {
            if (show) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                // Small timeout to allow display:block to apply before changing opacity
                setTimeout(() => overlay.classList.remove('opacity-0'), 10);
                document.body.style.overflow = 'hidden'; // prevent scrolling
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('opacity-0');
                setTimeout(() => overlay.classList.add('hidden'), 300);
                document.body.style.overflow = '';
            }
        }

        if (openBtn) openBtn.addEventListener('click', () => toggleSidebar(true));
        if (closeBtn) closeBtn.addEventListener('click', () => toggleSidebar(false));
        if (overlay) overlay.addEventListener('click', () => toggleSidebar(false));

        // Logika Dropdown Notifikasi
        const notifButton = document.getElementById('notifButton');
        const notifDropdown = document.getElementById('notifDropdown');
        if (notifButton && notifDropdown) {
            notifButton.addEventListener('click', (e) => {
                e.stopPropagation();
                notifDropdown.classList.toggle('hidden');
            });
            document.addEventListener('click', (e) => {
                if (!notifDropdown.contains(e.target)) {
                    notifDropdown.classList.add('hidden');
                }
            });
        }

        const inputs = document.querySelectorAll('input, select, textarea');
        
        inputs.forEach(input => {
            input.addEventListener('invalid', function (e) {
                e.preventDefault(); 
                
                let form = input.closest('form');
                if (form && !form.dataset.isSwalShown) {
                    form.dataset.isSwalShown = "true";
                    
                    let labelText = input.name;
                    let container = input.closest('.space-y-2') || input.closest('.space-y-3') || input.closest('.space-y-4') || input.parentElement;
                    if(container) {
                        let label = container.querySelector('label');
                        if(label) labelText = label.textContent.trim();
                    }
                    
                    let message = 'Harap lengkapi isian untuk: <b>' + labelText + '</b>';
                    if(input.type === 'radio') {
                        message = 'Harap pilih salah satu opsi untuk: <b>' + labelText + '</b>';
                    }
                    
                    Swal.fire({
                        icon: 'warning',
                        title: 'Formulir Belum Lengkap',
                        html: message,
                        confirmButtonColor: '#185eb0'
                    }).then(() => {
                        delete form.dataset.isSwalShown;
                        // Focus won't work on hidden radios, so wrap in try-catch or check
                        try { input.focus(); } catch(e) {}
                    });
                }
            });
        });

        // SweetAlert untuk konfirmasi Hapus/Tindakan (intercept form dengan data-swal-confirm)
        const customConfirmForms = document.querySelectorAll('form[data-swal-confirm]');
        customConfirmForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: form.dataset.swalTitle || 'Konfirmasi',
                    text: form.dataset.swalText || 'Anda yakin?',
                    icon: form.dataset.swalIcon || 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#9f403d',
                    cancelButtonColor: '#737c7f',
                    confirmButtonText: form.dataset.swalConfirmBtn || 'Ya, Lanjutkan',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // SweetAlert untuk konfirmasi Hapus/Tindakan (intercept semua form dengan onsubmit="confirm")
        const confirmForms = document.querySelectorAll('form[onsubmit*="confirm"]');
        confirmForms.forEach(form => {
            const onsubmitText = form.getAttribute('onsubmit');
            const match = onsubmitText.match(/confirm\(['"]([^'"]+)['"]\)/);
            const message = match ? match[1] : 'Anda yakin ingin melanjutkan tindakan ini?';
            
            // Hapus onsubmit bawaan browser agar native confirm tidak muncul
            form.removeAttribute('onsubmit');
            
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Konfirmasi',
                    text: message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#9f403d', // Error color for delete/destructive actions
                    cancelButtonColor: '#737c7f', // Outline color
                    confirmButtonText: 'Ya, Lanjutkan',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
</body>
</html>
