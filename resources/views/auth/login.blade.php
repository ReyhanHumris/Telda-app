<!DOCTYPE html>

<html class="light" lang="id"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Login | Telda Labuan Bajo - NTT</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary-container": "#d6e3ff",
                        "on-background": "#2b3437",
                        "on-error": "#fff7f6",
                        "primary-dim": "#0051a1",
                        "surface-container-lowest": "#ffffff",
                        "inverse-surface": "#0c0f10",
                        "on-tertiary-fixed": "#383751",
                        "tertiary-container": "#d9d7f8",
                        "outline": "#737c7f",
                        "on-secondary-fixed-variant": "#455f6b",
                        "on-tertiary-container": "#4b4a65",
                        "surface-container-highest": "#dbe4e7",
                        "on-tertiary-fixed-variant": "#54536f",
                        "on-secondary": "#f2faff",
                        "error": "#9f403d",
                        "secondary-fixed-dim": "#bdd9e6",
                        "secondary-container": "#cbe7f5",
                        "on-tertiary": "#fbf7ff",
                        "surface-tint": "#185eb0",
                        "secondary": "#49636f",
                        "tertiary": "#5d5c78",
                        "surface-container": "#eaeff1",
                        "surface-container-low": "#f1f4f6",
                        "tertiary-dim": "#51506c",
                        "primary-fixed-dim": "#c0d5ff",
                        "outline-variant": "#abb3b7",
                        "secondary-fixed": "#cbe7f5",
                        "inverse-on-surface": "#9b9d9e",
                        "surface-bright": "#f8f9fa",
                        "surface-variant": "#dbe4e7",
                        "on-primary-fixed": "#003e7e",
                        "on-secondary-container": "#3c5561",
                        "on-secondary-fixed": "#29434e",
                        "tertiary-fixed": "#d9d7f8",
                        "on-error-container": "#752121",
                        "error-container": "#fe8983",
                        "on-surface": "#2b3437",
                        "primary-fixed": "#d6e3ff",
                        "on-surface-variant": "#586064",
                        "surface": "#f8f9fa",
                        "primary": "#185eb0",
                        "on-primary-fixed-variant": "#125bad",
                        "on-primary": "#f7f7ff",
                        "secondary-dim": "#3d5762",
                        "surface-dim": "#d1dce0",
                        "tertiary-fixed-dim": "#cbc9e9",
                        "background": "#f8f9fa",
                        "on-primary-container": "#0051a0",
                        "error-dim": "#4e0309",
                        "inverse-primary": "#70a6fe",
                        "surface-container-high": "#e3e9ec"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "fontFamily": {
                        "headline": ["Manrope"],
                        "body": ["Inter"],
                        "label": ["Inter"]
                    }
                },
            },
        }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        .headline-font {
            font-family: 'Manrope', sans-serif;
        }
        .ghost-border {
            border: 1px solid rgba(171, 179, 183, 0.15);
        }
        .ambient-shadow {
            box-shadow: 0 20px 40px rgba(12, 15, 16, 0.06);
        }
    </style>
</head>
<body class="text-on-surface bg-surface min-h-screen flex items-center justify-center selection:bg-primary-container selection:text-on-primary-container">
<!-- Login Shell Suppression: No SideNav or TopNavBar as per "Destination Rule" for transactional screens -->
<main class="w-full max-w-[1200px] flex min-h-[700px] bg-surface-container-lowest rounded-xl overflow-hidden ambient-shadow ghost-border mx-4">
<!-- Left Side: Visual Branding (Asymmetric Layout) -->
<div class="hidden lg:flex w-1/2 relative bg-primary overflow-hidden items-center justify-center p-12">
<!-- Background Image with Overlay -->
<div class="absolute inset-0 z-0">
<img class="w-full h-full object-cover opacity-40 mix-blend-luminosity" data-alt="Cinematic aerial view of Labuan Bajo islands at sunrise with turquoise water and dramatic silhouettes of rolling green hills" src="https://lh3.googleusercontent.com/aida-public/AB6AXuB1pr8RtM4yCR8_V47v5e5Rg6Zx44lIfJLfcNRaED5FmwAAl14Kel9AOvhWpGZeb00hx7yM4NPgOseLvnR-nqEoTtgzpy4hpxHcvCukDimuwv12nSgR0nHkQ5uarrFK3YWYdPEkWdnPJekpuHrnjeZwyfn3s05r92U9EaZCb6TuhDao8iTrs-N257Nqs-gE6S78TH93AVAvDPkKDJSFZe_4xw02B44CXgPXIJ-zGYTscj7iskyP-5MyW5vnp_6QCISp-oI8BXmiQkEb"/>
<div class="absolute inset-0 bg-gradient-to-br from-primary via-primary-dim to-transparent opacity-80"></div>
</div>
<div class="relative z-10 text-on-primary max-w-md">
<div class="mb-8">
<span class="material-symbols-outlined text-5xl text-primary-fixed mb-4">analytics</span>
<h1 class="headline-font text-5xl font-extrabold tracking-tight leading-tight mb-4">
                        Telda Labuan Bajo - NTT
                    </h1>
<p class="text-primary-fixed text-lg opacity-90 leading-relaxed font-body">
                        Antarmuka manajemen definitif untuk kurasi data presisi dan analitik regional.
                    </p>
</div>
<div class="flex gap-4 items-center">
<div class="h-px w-12 bg-primary-fixed opacity-30"></div>
<span class="text-sm font-label uppercase tracking-widest text-primary-fixed">Sistem Terenkripsi</span>
</div>
</div>
</div>
<!-- Right Side: Login Form -->
<div class="w-full lg:w-1/2 flex flex-col items-center justify-center p-8 md:p-16 lg:p-20 bg-surface-container-lowest">
<div class="w-full max-w-sm">
<!-- Mobile Branding -->
<div class="lg:hidden mb-8 text-center">
<h2 class="headline-font text-2xl font-black text-primary tracking-tight">Telda Labuan Bajo - NTT</h2>
</div>
<div class="mb-10 text-left">
<h2 class="headline-font text-3xl font-bold text-on-surface mb-2">Selamat Datang Kembali</h2>
<p class="text-on-surface-variant font-body text-sm">Silakan masukkan kredensial Anda untuk mengakses portal manajemen.</p>
</div>
<form class="space-y-6" method="POST" action="{{ route('login.store') }}">
@csrf
<!-- Role Selector -->
<div class="space-y-2">
<label class="block text-xs font-label font-semibold uppercase tracking-wider text-on-surface-variant">Tingkat Akses</label>
<div class="grid grid-cols-2 gap-3">
<button class="flex items-center justify-center gap-2 py-3 px-4 rounded-lg bg-surface-container-highest border-b-2 border-primary text-primary font-medium text-sm transition-all duration-200" type="button">
<span class="material-symbols-outlined text-[18px]">admin_panel_settings</span>
                                Admin
                            </button>
<button class="flex items-center justify-center gap-2 py-3 px-4 rounded-lg bg-surface-container-low text-on-surface-variant font-medium text-sm hover:bg-surface-container-high transition-all duration-200" type="button">
<span class="material-symbols-outlined text-[18px]">badge</span>
                                Officer
                            </button>
</div>
</div>
<!-- Username/Email Field -->
<div class="space-y-2">
<label class="block text-xs font-label font-semibold uppercase tracking-wider text-on-surface-variant" for="identity">Nama Pengguna atau Email</label>
<div class="relative group">
<input class="w-full bg-surface-container-highest border-0 border-b-2 border-outline-variant py-3.5 px-0 text-on-surface placeholder-outline focus:ring-0 focus:border-primary transition-colors text-sm font-body" id="identity" name="username" placeholder="misal: admin@teldalabuanbajo.id" type="text" required />
</div>
</div>
<!-- Password Field -->
<div class="space-y-2">
<div class="flex justify-between items-center">
<label class="block text-xs font-label font-semibold uppercase tracking-wider text-on-surface-variant" for="password">Kata Sandi</label>
<a class="text-[11px] font-label font-bold text-primary hover:underline uppercase tracking-tighter" href="#">Lupa Kata Sandi?</a>
</div>
<div class="relative group">
<input class="w-full bg-surface-container-highest border-0 border-b-2 border-outline-variant py-3.5 px-0 text-on-surface placeholder-outline focus:ring-0 focus:border-primary transition-colors text-sm font-body" id="password" name="password" placeholder="••••••••" type="password" required />
<button class="absolute right-0 top-3 text-on-surface-variant hover:text-primary transition-colors" type="button">
<span class="material-symbols-outlined text-[20px]">visibility_off</span>
</button>
</div>
</div>
<!-- Actions -->
<div class="pt-4 flex flex-col gap-4">
<button class="w-full bg-gradient-to-br from-primary to-primary-dim text-on-primary py-4 rounded-lg font-bold headline-font text-sm tracking-wide shadow-lg hover:shadow-primary/20 active:scale-[0.98] transition-all duration-150" type="submit">
                            AUTENTIKASI AKSES
                        </button>
<div class="flex items-center justify-center gap-3">
<span class="material-symbols-outlined text-secondary text-[18px]">verified_user</span>
<span class="text-[11px] font-label font-medium text-on-surface-variant uppercase tracking-widest">Sesi Terenkripsi End-to-End</span>
</div>
</div>
</form>
</div>
<!-- Footer Meta -->
<div class="mt-16 text-center lg:mt-auto">
<p class="text-[10px] font-label text-outline uppercase tracking-widest leading-loose">
                    © 2024 Telda Labuan Bajo Management System<br/>
                    Proprietary Software Environment
                </p>
</div>
</div>
</main>
<!-- Glassmorphic Global Context (Subtle background elements) -->
<div class="fixed top-[-10%] right-[-5%] w-[400px] h-[400px] bg-primary/5 blur-[120px] rounded-full -z-10"></div>
<div class="fixed bottom-[-10%] left-[-5%] w-[300px] h-[300px] bg-secondary/5 blur-[100px] rounded-full -z-10"></div>
</body></html>