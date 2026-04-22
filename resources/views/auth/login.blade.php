<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Login | Telda Labuan Bajo - NTT</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary": "#185eb0",
                        "primary-dim": "#0051a1",
                        "primary-container": "#d6e3ff",
                        "on-primary": "#f7f7ff",
                        "on-surface": "#2b3437",
                        "on-surface-variant": "#586064",
                        "surface-container-low": "#f1f4f6",
                        "surface-container-highest": "#dbe4e7",
                        "surface-container-lowest": "#ffffff",
                        "outline-variant": "#abb3b7",
                        "error": "#9f403d",
                    },
                    "fontFamily": {
                        "headline": ["Manrope"],
                        "body": ["Inter"],
                    }
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body { font-family: 'Inter', sans-serif; }
        .headline-font { font-family: 'Manrope', sans-serif; }
        .ambient-shadow { box-shadow: 0 20px 40px rgba(12, 15, 16, 0.06); }
    </style>
</head>
<body class="text-on-surface bg-[#f8f9fa] min-h-screen flex items-center justify-center p-4 selection:bg-primary-container">

    <main class="w-full max-w-[1100px] flex min-h-[650px] bg-surface-container-lowest rounded-2xl overflow-hidden ambient-shadow border border-outline-variant/15">
        
        <div class="hidden lg:flex w-1/2 relative bg-primary items-center justify-center p-12">
            <div class="absolute inset-0">
                <img class="w-full h-full object-cover opacity-30 mix-blend-luminosity" src="https://lh3.googleusercontent.com/aida-public/AB6AXuB1pr8RtM4yCR8_V47v5e5Rg6Zx44lIfJLfcNRaED5FmwAAl14Kel9AOvhWpGZeb00hx7yM4NPgOseLvnR-nqEoTtgzpy4hpxHcvCukDimuwv12nSgR0nHkQ5uarrFK3YWYdPEkWdnPJekpuHrnjeZwyfn3s05r92U9EaZCb6TuhDao8iTrs-N257Nqs-gE6S78TH93AVAvDPkKDJSFZe_4xw02B44CXgPXIJ-zGYTscj7iskyP-5MyW5vnp_6QCISp-oI8BXmiQkEb" alt="Labuan Bajo View">
                <div class="absolute inset-0 bg-gradient-to-br from-primary via-primary-dim to-transparent opacity-90"></div>
            </div>
            <div class="relative z-10 text-on-primary">
                <span class="material-symbols-outlined text-6xl mb-6">analytics</span>
                <h1 class="headline-font text-5xl font-extrabold leading-tight mb-4">Telda Labuan Bajo</h1>
                <p class="text-lg opacity-80 font-body max-w-sm">Antarmuka manajemen definitif untuk kurasi data presisi dan analitik regional NTT.</p>
                <div class="mt-8 flex items-center gap-3">
                    <div class="h-px w-8 bg-white/30"></div>
                    <span class="text-xs font-bold uppercase tracking-[0.2em] opacity-60">Secure Authentication</span>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex flex-col justify-center p-8 md:p-16">
            <div class="w-full max-w-sm mx-auto">
                
                <div class="mb-10">
                    <h2 class="headline-font text-3xl font-bold text-on-surface mb-2">Selamat Datang</h2>
                    <p class="text-on-surface-variant text-sm">Silakan pilih tingkat akses dan masukkan kredensial Anda.</p>
                </div>

                <form class="space-y-6" method="POST" action="{{ route('login.store') }}">
                    @csrf

                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Tingkat Akses</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-0 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px] pointer-events-none">
                                shield_person
                            </span>
                            <select name="role" required class="w-full bg-transparent border-0 border-b-2 border-outline-variant py-3.5 pl-8 pr-4 text-on-surface focus:ring-0 focus:border-primary transition-colors text-sm font-medium appearance-none cursor-pointer">
                                <option value="" disabled selected>Pilih Tingkat Akses</option>
                                <option value="admin">Administrator (Akses Penuh)</option>
                                <option value="officer">Officer (Petugas Lapangan)</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-0 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">
                                expand_more
                            </span>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-on-surface-variant" for="identity">Nama Pengguna</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-0 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">
                                person
                            </span>
                            <input class="w-full bg-transparent border-0 border-b-2 border-outline-variant py-3.5 pl-8 text-on-surface placeholder-outline-variant/60 focus:ring-0 focus:border-primary transition-colors text-sm" 
                                id="identity" name="username" placeholder="admin@teldalabuanbajo.id" type="text" required />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-on-surface-variant" for="password">Kata Sandi</label>
                            <a class="text-[10px] font-bold text-primary hover:underline uppercase tracking-tighter" href="#">Lupa?</a>
                        </div>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-0 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">
                                lock
                            </span>
                            <input class="w-full bg-transparent border-0 border-b-2 border-outline-variant py-3.5 pl-8 pr-10 text-on-surface placeholder-outline-variant/60 focus:ring-0 focus:border-primary transition-colors text-sm" 
                                id="password" name="password" placeholder="••••••••" type="password" required />
                            <button type="button" class="absolute right-0 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-primary">
                                <span class="material-symbols-outlined text-[20px]">visibility_off</span>
                            </button>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button class="w-full bg-gradient-to-br from-primary to-primary-dim text-white py-4 rounded-xl font-bold headline-font text-sm tracking-widest shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all" type="submit">
                            MASUK KE SISTEM
                        </button>
                    </div>
                </form>

                <div class="mt-12 text-center">
                    <p class="text-[9px] font-medium text-outline-variant uppercase tracking-[0.2em] leading-loose">
                        © 2024 Performansi Telda Labuan Bajo<br/>
                        NTT Regional Data Management
                    </p>
                </div>
            </div>
        </div>
    </main>

</body>
</html>