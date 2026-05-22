<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Login | Telda Labuan Bajo - NTT</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
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
                        "officer-teal": "#0d9488",
                        "officer-teal-dim": "#0f766e"
                    },
                    fontFamily: {
                        "headline": ["Outfit", "sans-serif"],
                        "body": ["Plus Jakarta Sans", "sans-serif"],
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
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: linear-gradient(135deg, #f3f6f9 0%, #e9eef3 100%);
            overflow-x: hidden;
        }
        .headline-font { font-family: 'Outfit', sans-serif; }
        .ambient-shadow { 
            box-shadow: 0 30px 60px -15px rgba(15, 23, 42, 0.08), 
                        0 0 50px -10px rgba(24, 94, 176, 0.03); 
        }
        
        /* Bulatan blur latar belakang */
        .glow-ball {
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
            z-index: 0;
            pointer-events: none;
            transition: background-color 1s ease, transform 0.5s ease;
        }
        .glow-1 {
            top: -10%;
            left: -10%;
            background-color: rgba(24, 94, 176, 0.15);
            animation: floatGlow 15s infinite alternate ease-in-out;
        }
        .glow-2 {
            bottom: -10%;
            right: -10%;
            background-color: rgba(13, 148, 136, 0.12);
            animation: floatGlow 20s infinite alternate-reverse ease-in-out;
        }

        @keyframes floatGlow {
            0% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(40px, 30px) scale(1.1); }
            100% { transform: translate(-20px, -40px) scale(0.9); }
        }

        /* Transisi hover card */
        .login-card {
            transition: transform 0.3s ease, border-color 0.8s ease;
        }
        .login-card:hover {
            transform: translateY(-4px);
        }

        .wave-bg {
            background-image: radial-gradient(circle at 20% 30%, rgba(255,255,255,0.08) 1px, transparent 1px),
                              radial-gradient(circle at 75% 60%, rgba(255,255,255,0.08) 1px, transparent 1px);
            background-size: 24px 24px;
        }

        /* Animasi ring ketika klik cepat */
        .input-active-glow {
            animation: ringRipple 0.6s ease-out;
        }
        @keyframes ringRipple {
            0% { box-shadow: 0 0 0 0px rgba(24, 94, 176, 0.4); }
            100% { box-shadow: 0 0 0 8px rgba(24, 94, 176, 0); }
        }

        /* Animasi form error */
        .shake {
            animation: shakeErr 0.5s ease-in-out;
        }
        @keyframes shakeErr {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-6px); }
            40%, 80% { transform: translateX(6px); }
        }
    </style>
</head>
<body class="text-on-surface min-h-screen flex items-center justify-center p-4 selection:bg-primary-container relative">

    <div class="glow-ball glow-1" id="glowBallPrimary"></div>
    <div class="glow-ball glow-2" id="glowBallSecondary"></div>

    <main class="w-full max-w-[1050px] login-card-container z-10 animate-fade-in">
        <div class="login-card w-full flex min-h-[620px] bg-white/95 rounded-3xl overflow-hidden ambient-shadow border border-slate-200/50 backdrop-blur-md" id="loginCard">
            
            <!-- Sisi Kiri: Panel Info Gambar -->
            <div class="hidden lg:flex w-1/2 relative bg-primary items-center justify-center p-12 overflow-hidden transition-all duration-700" id="brandPanel">
                <div class="absolute inset-0">
                    <img class="w-full h-full object-cover opacity-25 mix-blend-luminosity scale-110" src="https://lh3.googleusercontent.com/aida-public/AB6AXuB1pr8RtM4yCR8_V47v5e5Rg6Zx44lIfJLfcNRaED5FmwAAl14Kel9AOvhWpGZeb00hx7yM4NPgOseLvnR-nqEoTtgzpy4hpxHcvCukDimuwv12nSgR0nHkQ5uarrFK3YWYdPEkWdnPJekpuHrnjeZwyfn3s05r92U9EaZCb6TuhDao8iTrs-N257Nqs-gE6S78TH93AVAvDPkKDJSFZe_4xw02B44CXgPXIJ-zGYTscj7iskyP-5MyW5vnp_6QCISp-oI8BXmiQkEb" alt="Labuan Bajo View">
                    <div class="absolute inset-0 bg-gradient-to-br from-primary via-primary-dim to-transparent opacity-95 transition-all duration-700" id="brandGradient"></div>
                    <div class="absolute inset-0 wave-bg opacity-40"></div>
                </div>
                
                <div class="absolute w-80 h-80 bg-white/5 rounded-full blur-2xl top-[-80px] left-[-80px]"></div>
                
                <div class="relative z-10 text-on-primary text-center lg:text-left">
                    <div class="inline-flex p-3.5 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 mb-6 shadow-xl" id="brandIconBox">
                        <span class="material-symbols-outlined text-4xl text-white" id="brandIcon">analytics</span>
                    </div>
                    <h1 class="headline-font text-4xl font-extrabold leading-tight mb-4 tracking-tight">
                        Telda <br class="hidden xl:block"/>Labuan Bajo
                    </h1>
                    <p class="text-sm opacity-80 font-body max-w-sm leading-relaxed mb-8">
                        Sistem informasi pemantauan data hasil survei lapangan dan langganan Indibiz untuk kantor daerah Telkom Labuan Bajo.
                    </p>
                    
                    <div class="flex items-center gap-3">
                        <div class="h-[2px] w-6 bg-white/40 rounded-full"></div>
                        <span class="text-[10px] font-bold uppercase tracking-[0.25em] opacity-75 font-headline" id="brandRoleTag">Sistem Otentikasi</span>
                    </div>
                </div>
            </div>

            <!-- Sisi Kanan: Formulir Input Login -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center p-8 md:p-14 bg-white/40">
                <div class="w-full max-w-[360px] mx-auto">
                    
                    <div class="mb-8">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest bg-primary/10 text-primary mb-3.5" id="roleBadge">
                            <span class="material-symbols-outlined text-[12px] fill-1">shield</span>
                            <span>Telkom LBO</span>
                        </div>
                        <h2 class="headline-font text-3xl font-extrabold text-slate-800 tracking-tight mb-2">Selamat Datang</h2>
                        <p class="text-slate-500 text-xs">Pilih hak akses dan masukkan username beserta password Anda.</p>
                    </div>

                    <form class="space-y-5" method="POST" action="{{ route('login.store') }}" id="loginForm">
                        @csrf

                        <!-- Pilihan Role -->
                        <div class="space-y-1.5 group">
                            <label class="block text-[10px] font-extrabold uppercase tracking-wider text-slate-400 group-focus-within:text-primary transition-colors" id="labelRole">Tingkat Akses</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-0 top-1/2 -translate-y-1/2 text-slate-400 text-[20px] pointer-events-none transition-colors" id="iconRole">
                                    shield_person
                                </span>
                                <select name="role" id="roleSelect" required class="w-full bg-transparent border-0 border-b-2 border-slate-300 py-3 pl-7 pr-8 text-slate-700 focus:ring-0 focus:border-primary transition-all text-xs font-semibold appearance-none cursor-pointer">
                                    <option value="" disabled selected>Pilih Tingkat Akses</option>
                                    <option value="admin">Admin (Akses Penuh)</option>
                                    <option value="officer">Officer (Petugas Lapangan)</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-0 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-[20px]">
                                    expand_more
                                </span>
                            </div>
                        </div>

                        <!-- Input Username -->
                        <div class="space-y-1.5 group">
                            <label class="block text-[10px] font-extrabold uppercase tracking-wider text-slate-400 group-focus-within:text-primary transition-colors" id="labelUsername">Nama Pengguna</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-0 top-1/2 -translate-y-1/2 text-slate-400 text-[20px] transition-colors" id="iconUsername">
                                    person
                                </span>
                                <input class="w-full bg-transparent border-0 border-b-2 border-slate-300 py-3 pl-7 text-slate-700 placeholder-slate-300 focus:ring-0 focus:border-primary transition-all text-xs" 
                                    id="identity" name="username" placeholder="Masukkan username" type="text" required />
                            </div>
                        </div>

                        <!-- Input Password -->
                        <div class="space-y-1.5 group">
                            <div class="flex justify-between items-center">
                                <label class="block text-[10px] font-extrabold uppercase tracking-wider text-slate-400 group-focus-within:text-primary transition-colors" id="labelPassword">Kata Sandi</label>
                                <a class="text-[9px] font-bold text-primary hover:underline uppercase tracking-tighter transition-colors" href="#" id="linkForgot">Lupa Sandi?</a>
                            </div>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-0 top-1/2 -translate-y-1/2 text-slate-400 text-[20px] transition-colors" id="iconPassword">
                                    lock
                                </span>
                                <input class="w-full bg-transparent border-0 border-b-2 border-slate-300 py-3 pl-7 pr-10 text-slate-700 placeholder-slate-300 focus:ring-0 focus:border-primary transition-all text-xs" 
                                    id="password" name="password" placeholder="••••••••" type="password" required />
                                <button type="button" id="togglePasswordBtn" class="absolute right-0 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                                    <span class="material-symbols-outlined text-[18px]" id="passwordEyeIcon">visibility_off</span>
                                </button>
                            </div>
                        </div>

                        <div class="pt-3">
                            <button id="submitBtn" class="w-full bg-gradient-to-br from-primary to-primary-dim text-white py-3.5 rounded-xl font-bold headline-font text-xs tracking-widest shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300" type="submit">
                                MASUK KE SISTEM
                            </button>
                        </div>
                    </form>



                    <!-- Hak Cipta -->
                    <div class="mt-8 text-center">
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.2em] leading-loose">
                            © 2026 Performansi Telda Labuan Bajo<br/>
                            <span class="opacity-75">Telkom Indonesia - Labuan Bajo</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleSelect = document.getElementById('roleSelect');
            const submitBtn = document.getElementById('submitBtn');
            const roleBadge = document.getElementById('roleBadge');
            const brandPanel = document.getElementById('brandPanel');
            const brandGradient = document.getElementById('brandGradient');
            const brandIcon = document.getElementById('brandIcon');
            const brandIconBox = document.getElementById('brandIconBox');
            const brandRoleTag = document.getElementById('brandRoleTag');
            
            const labels = ['labelRole', 'labelUsername', 'labelPassword'];
            const icons = ['iconRole', 'iconUsername', 'iconPassword'];
            const inputs = ['roleSelect', 'identity', 'password'];
            const linkForgot = document.getElementById('linkForgot');

            // Fungsi mengubah tema warna secara dinamis pas role dipilih
            function updateTheme(role) {
                if (role === 'officer') {
                    submitBtn.className = "w-full bg-gradient-to-br from-officer-teal to-officer-teal-dim text-white py-3.5 rounded-xl font-bold headline-font text-xs tracking-widest shadow-lg shadow-teal-700/20 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300";
                    
                    roleBadge.className = "inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest bg-teal-50 text-teal-700 border border-teal-200 transition-all duration-500";
                    roleBadge.innerHTML = `<span class="material-symbols-outlined text-[12px] fill-1">engineering</span><span>Petugas Lapangan</span>`;
                    
                    brandPanel.style.backgroundColor = "#0d9488";
                    brandGradient.className = "absolute inset-0 bg-gradient-to-br from-teal-600 via-teal-800 to-transparent opacity-95 transition-all duration-700";
                    brandIconBox.className = "inline-flex p-3.5 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 mb-6 shadow-xl";
                    brandIcon.innerText = "engineering";
                    brandRoleTag.innerText = "Halaman Officer";

                    inputs.forEach(id => {
                        const el = document.getElementById(id);
                        el.style.setProperty('--tw-ring-color', '#0d9488');
                        el.addEventListener('focus', () => el.style.borderColor = '#0d9488');
                        el.addEventListener('blur', () => { if (document.activeElement !== el) el.style.borderColor = '#cbd5e1'; });
                    });
                    labels.forEach(id => {
                        const el = document.getElementById(id);
                        el.addEventListener('focusin', () => el.style.color = '#0d9488');
                    });
                    icons.forEach(id => {
                        const el = document.getElementById(id);
                        el.addEventListener('focusin', () => el.style.color = '#0d9488');
                    });
                    linkForgot.style.color = "#0d9488";

                    document.getElementById('glowBallPrimary').style.backgroundColor = "rgba(13, 148, 136, 0.15)";

                } else if (role === 'admin') {
                    submitBtn.className = "w-full bg-gradient-to-br from-primary to-primary-dim text-white py-3.5 rounded-xl font-bold headline-font text-xs tracking-widest shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300";
                    
                    roleBadge.className = "inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest bg-primary/10 text-primary border border-primary/25 transition-all duration-500";
                    roleBadge.innerHTML = `<span class="material-symbols-outlined text-[12px] fill-1">security</span><span>Administrator</span>`;
                    
                    brandPanel.style.backgroundColor = "#185eb0";
                    brandGradient.className = "absolute inset-0 bg-gradient-to-br from-primary via-primary-dim to-transparent opacity-95 transition-all duration-700";
                    brandIconBox.className = "inline-flex p-3.5 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 mb-6 shadow-xl";
                    brandIcon.innerText = "analytics";
                    brandRoleTag.innerText = "Sistem Otentikasi";

                    inputs.forEach(id => {
                        const el = document.getElementById(id);
                        el.addEventListener('focus', () => el.style.borderColor = '#185eb0');
                        el.addEventListener('blur', () => { if (document.activeElement !== el) el.style.borderColor = '#cbd5e1'; });
                    });
                    linkForgot.style.color = "#185eb0";
                    document.getElementById('glowBallPrimary').style.backgroundColor = "rgba(24, 94, 176, 0.15)";
                }
            }

            roleSelect.addEventListener('change', function () {
                updateTheme(this.value);
            });

            // Toggle password visibility
            const togglePasswordBtn = document.getElementById('togglePasswordBtn');
            const passwordInput = document.getElementById('password');
            const passwordEyeIcon = document.getElementById('passwordEyeIcon');

            togglePasswordBtn.addEventListener('click', function () {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    passwordEyeIcon.innerText = 'visibility';
                } else {
                    passwordInput.type = 'password';
                    passwordEyeIcon.innerText = 'visibility_off';
                }
                
                passwordEyeIcon.style.transform = 'scale(0.85)';
                setTimeout(() => passwordEyeIcon.style.transform = 'scale(1)', 150);
            });

            // Efek hover halus pada card
            const loginCard = document.getElementById('loginCard');

            // Validasi input role saat submit form
            const loginForm = document.getElementById('loginForm');
            loginForm.addEventListener('submit', function (e) {
                if (!roleSelect.value) {
                    e.preventDefault();
                    loginCard.classList.add('shake');
                    setTimeout(() => loginCard.classList.remove('shake'), 500);
                    
                    Swal.fire({
                        icon: 'warning',
                        title: 'Akses Ditolak',
                        text: 'Silakan pilih Tingkat Akses terlebih dahulu!',
                        confirmButtonColor: roleSelect.value === 'officer' ? '#0d9488' : '#185eb0'
                    });
                }
            });
        });

        // Isi otomatis kredensial akun uji coba (Demo)
        function quickFill(role) {
            const roleSelect = document.getElementById('roleSelect');
            const usernameInput = document.getElementById('identity');
            const passwordInput = document.getElementById('password');

            roleSelect.value = role;
            usernameInput.value = role;
            passwordInput.value = role === 'admin' ? 'admin12345' : 'officer12345';

            roleSelect.dispatchEvent(new Event('change'));

            [roleSelect, usernameInput, passwordInput].forEach(el => {
                el.classList.add('input-active-glow');
                setTimeout(() => el.classList.remove('input-active-glow'), 600);
            });

            const themeColor = role === 'officer' ? '#0d9488' : '#185eb0';
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                icon: 'success',
                title: `Mengisi data sebagai ${role.toUpperCase()}`,
                background: '#ffffff',
                color: '#1e293b',
                iconColor: themeColor
            });
        }
    </script>

    @if($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Login Gagal',
                    text: '{{ addslashes($errors->first()) }}',
                    confirmButtonColor: '#185eb0',
                    customClass: {
                        popup: 'font-body rounded-2xl shadow-2xl border border-slate-100',
                    }
                });
            });
        </script>
    @endif
</body>
</html>