<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="CV Nisrina Jaya — Jasa Service & Cleaning AC profesional di Indonesia. Teknisi berpengalaman, harga transparan, bergaransi.">
    <meta property="og:title" content="CV Nisrina Jaya | AC Service Specialist">
    <meta property="og:description" content="Layanan cuci AC, isi freon, perbaikan AC rumah & kantor dengan teknisi berpengalaman.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <title>{{ $title ?? 'CV Nisrina Jaya | AC Service Specialist' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        * { font-family: 'Inter', sans-serif; scroll-behavior: smooth; }
        [x-cloak] { display: none !important; }
        .glass { background: rgba(255,255,255,0.8); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); }
        .hero-gradient { background: linear-gradient(135deg, #064e3b 0%, #059669 40%, #14b8a6 100%); }
        .card-hover { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-6px) scale(1.01); }
        .text-gradient { background: linear-gradient(135deg, #059669, #14b8a6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .nav-link { position: relative; }
        .nav-link::after { content: ''; position: absolute; left: 0; bottom: -4px; width: 0; height: 2px; background: #059669; transition: width 0.3s ease; }
        .nav-link:hover::after { width: 100%; }
        .scroll-indicator { animation: float 2s ease-in-out infinite; }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(8px); } }
        .shimmer { background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent); background-size: 200% 100%; animation: shimmer 2.5s infinite; }
        @keyframes shimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
    </style>
</head>

<body class="bg-white text-slate-800 antialiased" x-data="app()" x-init="init()">

    {{-- NAV --}}
    <header x-data="{ open: false, scrolled: false }" x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 40)"
        class="fixed top-0 left-0 w-full z-50 transition-all duration-300"
        :class="scrolled ? 'glass shadow-lg border-b border-slate-200/60' : 'bg-transparent'">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-4 sm:px-6 py-3 md:py-4">
            <a href="#home" class="flex items-center gap-3 shrink-0">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center text-white font-bold shadow-lg shadow-emerald-200">
                    <span class="text-sm">AC</span>
                </div>
                <div>
                    <div class="font-bold text-base md:text-lg text-slate-800 tracking-wide">CV Nisrina Jaya</div>
                    <div class="text-[11px] text-slate-400 hidden sm:block">Air Conditioning Specialist</div>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-8 text-sm font-medium">
                <a href="#home" class="nav-link text-slate-600 hover:text-emerald-600 transition">Home</a>
                <a href="#about" class="nav-link text-slate-600 hover:text-emerald-600 transition">Tentang</a>
                <a href="#services" class="nav-link text-slate-600 hover:text-emerald-600 transition">Layanan</a>
                <a href="#workflow" class="nav-link text-slate-600 hover:text-emerald-600 transition">Cara Kerja</a>
                <a href="#testimonials" class="nav-link text-slate-600 hover:text-emerald-600 transition">Testimoni</a>
                <a href="#contact" class="nav-link text-slate-600 hover:text-emerald-600 transition">Kontak</a>
            </nav>

            <div class="hidden md:flex items-center gap-3">
                @auth
                    @if (auth()->user()->hasAnyRole(['Owner', 'Admin', 'Teknisi']))
                        <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 text-sm font-semibold bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition shadow-lg hover:shadow-emerald-200">Dashboard</a>
                    @elseif(auth()->user()->hasRole('Customer'))
                        <a href="{{ route('customer.dashboard') }}" class="px-5 py-2.5 text-sm font-semibold bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition shadow-lg hover:shadow-emerald-200">Akun Saya</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-emerald-600 transition">Login</a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-semibold bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition shadow-lg hover:shadow-emerald-200">Register</a>
                @endauth
            </div>

            <button @click="open = !open" class="md:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100 transition" :class="scrolled || open ? 'bg-slate-100' : 'bg-white/20'">
                <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-show="open" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-3" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-3"
            x-cloak class="md:hidden bg-white border-t border-slate-100 shadow-xl">
            <div class="px-4 py-4 space-y-1">
                <a href="#home" @click="open=false" class="block px-4 py-3 rounded-xl hover:bg-emerald-50 text-slate-600 hover:text-emerald-600 transition font-medium">Home</a>
                <a href="#about" @click="open=false" class="block px-4 py-3 rounded-xl hover:bg-emerald-50 text-slate-600 hover:text-emerald-600 transition font-medium">Tentang</a>
                <a href="#services" @click="open=false" class="block px-4 py-3 rounded-xl hover:bg-emerald-50 text-slate-600 hover:text-emerald-600 transition font-medium">Layanan</a>
                <a href="#workflow" @click="open=false" class="block px-4 py-3 rounded-xl hover:bg-emerald-50 text-slate-600 hover:text-emerald-600 transition font-medium">Cara Kerja</a>
                <a href="#testimonials" @click="open=false" class="block px-4 py-3 rounded-xl hover:bg-emerald-50 text-slate-600 hover:text-emerald-600 transition font-medium">Testimoni</a>
                <a href="#contact" @click="open=false" class="block px-4 py-3 rounded-xl hover:bg-emerald-50 text-slate-600 hover:text-emerald-600 transition font-medium">Kontak</a>
                <div class="border-t border-slate-100 pt-4 mt-4">
                    @auth
                        @if (auth()->user()->hasAnyRole(['Owner', 'Admin', 'Teknisi']))
                            <a href="{{ route('admin.dashboard') }}" class="block w-full text-center px-4 py-3 rounded-xl bg-emerald-600 text-white font-semibold hover:bg-emerald-700 transition">Dashboard</a>
                        @elseif(auth()->user()->hasRole('Customer'))
                            <a href="{{ route('customer.dashboard') }}" class="block w-full text-center px-4 py-3 rounded-xl bg-emerald-600 text-white font-semibold hover:bg-emerald-700 transition">Akun Saya</a>
                        @endif
                    @else
                        <div class="flex flex-col gap-3">
                            <a href="{{ route('login') }}" class="block text-center px-4 py-3 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 transition font-medium">Login</a>
                            <a href="{{ route('register') }}" class="block text-center px-4 py-3 rounded-xl bg-emerald-600 text-white font-semibold hover:bg-emerald-700 transition">Register</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    {{-- HERO --}}
    <section id="home" class="relative min-h-screen flex items-center overflow-hidden hero-gradient">
        <div class="absolute inset-0">
            <div class="absolute top-20 left-10 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-80 h-80 bg-teal-300/10 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-emerald-400/5 rounded-full blur-3xl"></div>
        </div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 py-32 md:py-40">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div data-aos="fade-right" data-aos-duration="1000">
                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-white/15 backdrop-blur rounded-full text-white/90 text-sm font-medium border border-white/10 mb-6">
                        <span class="w-2 h-2 rounded-full bg-emerald-300 animate-pulse"></span>
                        AIR CONDITIONER BERGARANSI SERVICE
                    </span>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight">
                        Jasa Service & Cleaning AC
                        <span class="text-emerald-200">Profesional</span>
                    </h1>
                    <p class="mt-5 text-lg text-white/80 max-w-xl leading-relaxed">
                        Layanan cuci AC, perawatan, isi freon, dan perbaikan AC rumah & kantor dengan teknisi berpengalaman. Harga transparan, bergaransi.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-4">
                        <a href="#services" class="inline-flex items-center gap-2 px-7 py-3.5 bg-white text-emerald-700 rounded-2xl font-bold shadow-2xl hover:shadow-emerald-200/40 hover:scale-105 transition-all duration-300">
                            Lihat Layanan
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                        </a>
                        <a href="#contact" class="inline-flex items-center gap-2 px-7 py-3.5 border-2 border-white/30 text-white rounded-2xl font-semibold hover:bg-white/10 hover:border-white/50 transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            Hubungi Kami
                        </a>
                    </div>
                    <div class="mt-10 flex items-center gap-6 text-white/60 text-sm">
                        <div class="flex items-center gap-2"><span class="w-5 h-5 rounded-full bg-emerald-400/20 flex items-center justify-center text-emerald-300 text-xs">✓</span> 10+ Tahun</div>
                        <div class="flex items-center gap-2"><span class="w-5 h-5 rounded-full bg-emerald-400/20 flex items-center justify-center text-emerald-300 text-xs">✓</span> 1000+ Pelanggan</div>
                        <div class="flex items-center gap-2"><span class="w-5 h-5 rounded-full bg-emerald-400/20 flex items-center justify-center text-emerald-300 text-xs">✓</span> Bergaransi</div>
                    </div>
                </div>

                <div data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200"
                    x-data="{
                        active: 0,
                        images: [
                            '{{ asset('gambar/img1.jpg') }}',
                            '{{ asset('gambar/img2.jpg') }}',
                            '{{ asset('gambar/img3.jpg') }}',
                            '{{ asset('gambar/img4.jpg') }}'
                        ],
                        init() { setInterval(() => this.active = (this.active + 1) % this.images.length, 4000); }
                    }" class="relative">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl shadow-emerald-900/30">
                        <template x-for="(image, index) in images" :key="index">
                            <img :src="image" x-show="active === index"
                                x-transition:enter="transition ease-out duration-1000"
                                x-transition:enter-start="opacity-0 scale-105" x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-700" x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0"
                                class="w-full h-[350px] md:h-[420px] object-cover absolute inset-0" loading="lazy"
                                alt="AC Service">
                        </template>
                        <div class="h-[350px] md:h-[420px]"></div>
                        <div class="absolute inset-0 rounded-3xl bg-gradient-to-t from-emerald-900/40 via-transparent to-transparent"></div>
                        <div class="absolute bottom-4 left-4 bg-white/95 backdrop-blur text-slate-800 px-5 py-3 rounded-2xl shadow-xl">
                            <div class="font-semibold flex items-center gap-2">❄️ Professional AC Service</div>
                            <div class="text-xs text-slate-400">Fast • Clean • Trusted</div>
                        </div>
                        <div class="absolute bottom-4 right-4 flex gap-2">
                            <template x-for="(image, index) in images">
                                <button @click="active=index" :class="active === index ? 'w-8 bg-white' : 'w-3 bg-white/50'" class="h-3 rounded-full transition-all duration-300"></button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 scroll-indicator">
            <svg class="w-6 h-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7"/></svg>
        </div>
    </section>

    {{-- ABOUT --}}
    <section id="about" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="grid lg:grid-cols-2 gap-14 items-center">
                <div data-aos="fade-right" data-aos-duration="800">
                    <div class="relative">
                        <img src="{{ asset('gambar/img4.jpg') }}" class="rounded-3xl shadow-xl w-full h-[500px] object-cover" loading="lazy" alt="Workshop CV Nisrina Jaya">
                        <div class="absolute -bottom-6 -right-6 bg-gradient-to-br from-emerald-600 to-teal-600 text-white p-6 md:p-7 rounded-2xl shadow-xl shadow-emerald-200">
                            <div class="text-3xl md:text-4xl font-bold">10+</div>
                            <div class="text-sm opacity-90 font-medium">Tahun Pengalaman</div>
                        </div>
                    </div>
                </div>
                <div data-aos="fade-left" data-aos-duration="800">
                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-sm font-semibold">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        Tentang Perusahaan
                    </span>
                    <h2 class="mt-5 text-3xl md:text-4xl font-bold text-slate-900">Solusi Service & Perawatan AC Profesional</h2>
                    <p class="mt-5 text-slate-600 leading-relaxed">
                        CV Nisrina Jaya merupakan perusahaan yang bergerak di bidang service, perawatan, instalasi, dan perbaikan AC untuk rumah, perkantoran, toko, serta industri.
                    </p>
                    <p class="mt-3 text-slate-600 leading-relaxed">
                        Dengan teknisi berpengalaman dan peralatan modern, kami berkomitmen memberikan layanan yang cepat, transparan, profesional, dan bergaransi.
                    </p>
                    <div class="grid sm:grid-cols-2 gap-4 mt-8">
                        @foreach ([
                            ['icon' => '👨‍🔧', 'title' => 'Teknisi Berpengalaman', 'desc' => 'Ditangani tenaga ahli profesional.'],
                            ['icon' => '💰', 'title' => 'Harga Transparan', 'desc' => 'Tanpa biaya tersembunyi.'],
                            ['icon' => '✅', 'title' => 'Bergaransi', 'desc' => 'Garansi untuk setiap pekerjaan.'],
                            ['icon' => '⚡', 'title' => 'Respon Cepat', 'desc' => 'Siap melayani setiap hari.'],
                        ] as $feat)
                            <div class="flex items-start gap-3 p-4 rounded-2xl hover:bg-emerald-50 transition">
                                <div class="w-11 h-11 rounded-xl bg-emerald-100 flex items-center justify-center text-lg shrink-0">{{ $feat['icon'] }}</div>
                                <div>
                                    <h4 class="font-semibold text-slate-800">{{ $feat['title'] }}</h4>
                                    <p class="text-sm text-slate-500">{{ $feat['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- COMPANY STATS --}}
    <section class="py-20 hero-gradient">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach ([
                    ['count' => 1000, 'suffix' => '+', 'label' => 'Pelanggan Puas', 'icon' => '😊'],
                    ['count' => 10, 'suffix' => '+', 'label' => 'Tahun Pengalaman', 'icon' => '📅'],
                    ['count' => 15, 'suffix' => '+', 'label' => 'Teknisi Ahli', 'icon' => '👨‍🔧'],
                    ['count' => 24, 'suffix' => '/7', 'label' => 'Support Service', 'icon' => '🔄'],
                ] as $stat)
                    <div data-aos="zoom-in" data-aos-duration="600"
                        class="bg-white/10 backdrop-blur rounded-3xl p-6 md:p-8 text-center border border-white/10 hover:bg-white/15 transition card-hover">
                        <div class="text-3xl mb-3">{{ $stat['icon'] }}</div>
                        <div class="text-3xl md:text-4xl font-extrabold text-white" x-data="counter({{ $stat['count'] }})" x-init="start()">
                            <span x-text="count"></span>{{ $stat['suffix'] }}
                        </div>
                        <p class="mt-2 text-emerald-100/80 text-sm font-medium">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- WHY CHOOSE US --}}
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-sm font-semibold">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Keunggulan Kami
                </span>
                <h2 class="mt-4 text-3xl md:text-4xl font-bold text-slate-900">Mengapa Memilih CV Nisrina Jaya?</h2>
                <p class="mt-3 text-slate-500 max-w-2xl mx-auto">Memberikan layanan AC yang cepat, profesional, transparan dan bergaransi untuk rumah, kantor, toko maupun industri.</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ([
                    ['icon' => '🛠️', 'title' => 'Teknisi Bersertifikat', 'desc' => 'Dikerjakan oleh teknisi berpengalaman dan terlatih.'],
                    ['icon' => '⚡', 'title' => 'Respon Cepat', 'desc' => 'Penanganan cepat untuk kebutuhan service mendesak.'],
                    ['icon' => '💰', 'title' => 'Harga Transparan', 'desc' => 'Tanpa biaya tersembunyi dan sesuai kebutuhan.'],
                    ['icon' => '✅', 'title' => 'Bergaransi', 'desc' => 'Setiap pekerjaan dilengkapi garansi layanan.'],
                ] as $why)
                    <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}"
                        class="group bg-slate-50 p-7 md:p-8 rounded-3xl card-hover hover:bg-emerald-50 border border-transparent hover:border-emerald-100">
                        <div class="w-14 h-14 rounded-2xl bg-white shadow-sm flex items-center justify-center text-2xl mb-5 group-hover:scale-110 transition-transform">{{ $why['icon'] }}</div>
                        <h3 class="font-bold text-lg text-slate-800">{{ $why['title'] }}</h3>
                        <p class="text-slate-500 mt-2 text-sm leading-relaxed">{{ $why['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CLIENTS --}}
    <section class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-2xl md:text-3xl font-bold text-slate-800">Dipercaya Berbagai Perusahaan</h2>
                <p class="text-slate-500 mt-2">Beberapa klien yang telah menggunakan layanan kami</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-8 items-center justify-items-center opacity-60 grayscale hover:grayscale-0 transition-all duration-500">
                <img src="{{ asset('logo/logo6.jpg') }}" class="h-12 object-contain" loading="lazy" alt="Client logo">
                <img src="{{ asset('logo/logo2.png') }}" class="h-12 object-contain" loading="lazy" alt="Client logo">
                <img src="{{ asset('logo/logo3.png') }}" class="h-12 object-contain" loading="lazy" alt="Client logo">
                <img src="{{ asset('logo/logo4.png') }}" class="h-12 object-contain" loading="lazy" alt="Client logo">
                <img src="{{ asset('logo/logo5.png') }}" class="h-12 object-contain" loading="lazy" alt="Client logo">
            </div>
        </div>
    </section>

    {{-- SERVICES --}}
    <section id="services" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-14" data-aos="fade-up">
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-sm font-semibold">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Layanan Kami
                </span>
                <h2 class="mt-4 text-3xl md:text-4xl font-bold text-slate-900">Solusi Lengkap Perawatan AC</h2>
                <p class="mt-3 text-slate-500">Layanan profesional untuk AC rumah, kantor, dan industri</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6 md:gap-8">
                @foreach ([
                    ['img' => 'img4.jpg', 'title' => 'Cuci AC', 'desc' => 'Membersihkan indoor & outdoor AC agar dingin maksimal. Mencegah bau dan meningkatkan efisiensi listrik.'],
                    ['img' => 'img4.jpg', 'title' => 'Isi & Tambah Freon', 'desc' => 'Pengisian freon untuk menjaga performa pendinginan AC. Deteksi kebocoran juga dilakukan.'],
                    ['img' => 'img4.jpg', 'title' => 'Perbaikan AC', 'desc' => 'Perbaikan kerusakan AC rumah, kantor, dan industri. Mulai dari PCB, kompressor, hingga fan motor.'],
                    ['img' => 'img4.jpg', 'title' => 'Bongkar Pasang AC', 'desc' => 'Jasa bongkar pasang AC untuk pindahan atau instalasi baru dengan rapi dan aman.'],
                    ['img' => 'img4.jpg', 'title' => 'Perawatan Berkala', 'desc' => 'Program maintenance rutin untuk menjaga performa AC tetap optimal sepanjang tahun.'],
                    ['img' => 'img4.jpg', 'title' => 'Konsultasi AC', 'desc' => 'Konsultasi gratis untuk pemilihan AC, penanganan masalah, dan kebutuhan pendinginan Anda.'],
                ] as $svc)
                    <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}"
                        class="group bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-100 card-hover hover:shadow-xl">
                        <div class="relative overflow-hidden h-52">
                            <img src="{{ asset('gambar/' . $svc['img']) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" loading="lazy" alt="{{ $svc['title'] }}">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                            <div class="absolute bottom-4 left-5">
                                <span class="px-3 py-1.5 bg-white/90 backdrop-blur rounded-xl text-xs font-semibold text-emerald-700">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="font-bold text-lg text-slate-800 group-hover:text-emerald-600 transition">{{ $svc['title'] }}</h3>
                            <p class="text-slate-500 text-sm mt-2 leading-relaxed">{{ $svc['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- WORKFLOW --}}
    <section id="workflow" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-sm font-semibold">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Cara Kerja
                </span>
                <h2 class="mt-4 text-3xl md:text-4xl font-bold text-slate-900">Proses Layanan Kami</h2>
                <p class="mt-3 text-slate-500">Mudah, cepat dan transparan</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ([
                    ['num' => '01', 'title' => 'Hubungi Kami', 'desc' => 'Hubungi via WhatsApp, telepon, atau form website. Tim kami akan merespon cepat.'],
                    ['num' => '02', 'title' => 'Survey & Diagnosa', 'desc' => 'Teknisi datang ke lokasi untuk mengecek dan mendiagnosa kondisi AC Anda.'],
                    ['num' => '03', 'title' => 'Pengerjaan', 'desc' => 'Service dilakukan oleh teknisi profesional dengan peralatan lengkap dan modern.'],
                    ['num' => '04', 'title' => 'Garansi', 'desc' => 'Setiap pekerjaan selesai dengan garansi layanan. Kepuasan Anda prioritas kami.'],
                ] as $step)
                    <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}"
                        class="relative bg-white rounded-3xl p-7 md:p-8 border border-slate-100 card-hover hover:shadow-lg">
                        <span class="text-5xl md:text-6xl font-black text-emerald-100/70 absolute top-4 right-6 select-none">{{ $step['num'] }}</span>
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-emerald-200 mb-5 relative">
                            {{ $step['num'] }}
                        </div>
                        <h3 class="font-bold text-lg text-slate-800 relative">{{ $step['title'] }}</h3>
                        <p class="text-slate-500 text-sm mt-2 leading-relaxed relative">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- GALLERY --}}
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-14" data-aos="fade-up">
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-sm font-semibold">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Workshop Kami
                </span>
                <h2 class="mt-4 text-3xl md:text-4xl font-bold text-slate-900">Suasana Kerja & Proses Service</h2>
                <p class="mt-3 text-slate-500">Dokumentasi kegiatan workshop dan pelayanan kami</p>
            </div>
            <div class="grid md:grid-cols-3 gap-4">
                @foreach (['img1.jpg', 'img2.jpg', 'img4.jpg'] as $i => $img)
                    <div data-aos="zoom-in" data-aos-delay="{{ $i * 100 }}" class="overflow-hidden rounded-2xl group">
                        <img src="{{ asset('gambar/' . $img) }}" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-700" loading="lazy" alt="Workshop {{ $i + 1 }}">
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- BEFORE AFTER --}}
    <section class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-14" data-aos="fade-up">
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-sm font-semibold">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Hasil Pekerjaan
                </span>
                <h2 class="mt-4 text-3xl md:text-4xl font-bold text-slate-900">Perbedaan Sebelum & Sesudah</h2>
                <p class="mt-3 text-slate-500">Lihat sendiri kualitas hasil kerja teknisi kami</p>
            </div>
            <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <div data-aos="fade-right" class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-100">
                    <div class="relative">
                        <img src="{{ asset('gambar/img4.jpg') }}" class="w-full h-72 object-cover" loading="lazy" alt="Sebelum cleaning">
                        <div class="absolute top-3 left-3 px-4 py-2 bg-red-500/90 backdrop-blur text-white text-sm font-semibold rounded-xl">Sebelum</div>
                    </div>
                </div>
                <div data-aos="fade-left" class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-100">
                    <div class="relative">
                        <img src="{{ asset('gambar/img5.jpg') }}" class="w-full h-72 object-cover" loading="lazy" alt="Sesudah cleaning">
                        <div class="absolute top-3 left-3 px-4 py-2 bg-emerald-500/90 backdrop-blur text-white text-sm font-semibold rounded-xl">Sesudah</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- TESTIMONIALS --}}
    <section id="testimonials" class="py-24 hero-gradient">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-white/15 backdrop-blur rounded-full text-white/90 text-sm font-medium border border-white/10">
                    Testimoni Pelanggan
                </span>
                <h2 class="mt-4 text-3xl md:text-4xl font-bold text-white">Apa Kata Pelanggan Kami?</h2>
                <p class="mt-3 text-emerald-100/80">Kepuasan pelanggan adalah prioritas utama CV Nisrina Jaya</p>
            </div>

            <div x-data="{
                active: 0,
                testimonials: [
                    { name: 'Budi Santoso', role: 'Pelanggan Rumah', text: 'Service AC sangat memuaskan! Teknisi datang tepat waktu, kerja rapih, AC jadi dingin kembali. Recommended!', rating: 5, avatar: '/profile/profile1.jpg' },
                    { name: 'Sari Dewi', role: 'Pemilik Kantor', text: 'Kami menggunakan jasa maintenance rutin untuk kantor. Pelayanan profesional dan respon cepat. Sangat puas!', rating: 5, avatar: '/profile/profile2.jpg' },
                    { name: 'Ahmad Fauzi', role: 'Pelanggan Bisnis', text: 'Harga transparan, tidak ada biaya tersembunyi. Teknisi ramah dan berpengalaman. Pasti pakai lagi.', rating: 5, avatar: '/profile/profile3.jpg' },
                    { name: 'Rina Marlina', role: 'Ibu Rumah Tangga', text: 'AC bocor dan langsung ditangani. Cepat, bersih, dan harganya masuk akal. Terima kasih CV Nisrina Jaya!', rating: 5, avatar: '/profile/profile1.jpg' },
                    { name: 'Doni Prasetyo', role: 'Pelanggan Toko', text: 'Sudah 3 tahun langganan, tidak pernah kecewa. Pelayanan selalu maksimal. AC toko saya selalu terjaga.', rating: 5, avatar: '/profile/profile2.jpg' },
                ],
                get current() { return this.testimonials[this.active]; },
                next() { this.active = (this.active + 1) % this.testimonials.length; },
                prev() { this.active = (this.active - 1 + this.testimonials.length) % this.testimonials.length; },
                init() { setInterval(() => this.next(), 5000); }
            }" class="relative max-w-3xl mx-auto">
                <div class="overflow-hidden">
                    <div x-show="true" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0" class="bg-white/10 backdrop-blur border border-white/10 rounded-3xl p-8 md:p-10 text-center" :key="active">
                        <div class="flex justify-center gap-1 mb-6">
                            <template x-for="i in 5">
                                <svg class="w-5 h-5" :class="i <= current.rating ? 'text-yellow-400' : 'text-white/20'" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </template>
                        </div>
                        <p class="text-white/90 text-lg md:text-xl leading-relaxed italic" x-text="'\"' + current.text + '\"'"></p>
                        <div class="mt-6 flex items-center justify-center gap-4">
                            <img :src="current.avatar" class="w-14 h-14 rounded-full object-cover border-2 border-white/30 shadow-lg" loading="lazy" />
                            <div class="text-left">
                                <p class="font-semibold text-white" x-text="current.name"></p>
                                <p class="text-sm text-emerald-200/70" x-text="current.role"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center gap-3 mt-8">
                    <template x-for="(t, i) in testimonials">
                        <button @click="active = i" :class="active === i ? 'w-10 bg-emerald-300' : 'w-3 bg-white/30 hover:bg-white/50'" class="h-3 rounded-full transition-all duration-300"></button>
                    </template>
                </div>
            </div>
        </div>
    </section>

    {{-- CONTACT --}}
    <section id="contact" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-sm font-semibold">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Hubungi Kami
                </span>
                <h2 class="mt-4 text-3xl md:text-4xl font-bold text-slate-900">Siap Membantu Anda</h2>
                <p class="mt-3 text-slate-500">Jangan ragu untuk menghubungi tim kami</p>
            </div>

            <div class="grid lg:grid-cols-2 gap-10">
                <div class="space-y-6" data-aos="fade-right">
                    @foreach ([
                        ['icon' => '📍', 'title' => 'Alamat', 'detail' => 'Jl. Raya Contoh No. 123, Kota Anda'],
                        ['icon' => '📞', 'title' => 'Telepon', 'detail' => '0812-3456-7890'],
                        ['icon' => '✉️', 'title' => 'Email', 'detail' => 'info@nisrinajaya.com'],
                        ['icon' => '🕐', 'title' => 'Jam Operasional', 'detail' => 'Senin - Sabtu, 08:00 - 17:00'],
                    ] as $contact)
                        <div class="flex items-start gap-4 p-5 rounded-2xl bg-slate-50 hover:bg-emerald-50 transition card-hover">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center text-xl shrink-0">{{ $contact['icon'] }}</div>
                            <div>
                                <h4 class="font-semibold text-slate-800">{{ $contact['title'] }}</h4>
                                <p class="text-slate-600 mt-0.5">{{ $contact['detail'] }}</p>
                            </div>
                        </div>
                    @endforeach

                    <a href="https://wa.me/6281234567890" target="_blank"
                        class="inline-flex items-center justify-center gap-2 w-full py-4 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-2xl font-bold shadow-lg hover:shadow-xl hover:scale-[1.02] transition-all duration-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        Hubungi via WhatsApp
                    </a>
                </div>

                <div data-aos="fade-left" class="rounded-3xl overflow-hidden shadow-sm border border-slate-100 h-[400px]">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.0!2d106.8!3d-6.2!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTInMDAuMCJTIDEwNsKwNDgnMDAuMCJF!5e0!3m2!1sid!2sid!4v1"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                        title="Lokasi CV Nisrina Jaya">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA BANNER --}}
    <section class="py-20 hero-gradient">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 text-center" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-white">Siap Merasakan Layanan Terbaik Kami?</h2>
            <p class="mt-3 text-emerald-100/80 max-w-2xl mx-auto">Hubungi kami sekarang dan dapatkan konsultasi gratis untuk kebutuhan AC Anda.</p>
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <a href="#contact" class="inline-flex items-center gap-2 px-8 py-4 bg-white text-emerald-700 rounded-2xl font-bold shadow-2xl hover:shadow-emerald-200/40 hover:scale-105 transition-all duration-300">
                    Hubungi Kami
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-4 border-2 border-white/30 text-white rounded-2xl font-semibold hover:bg-white/10 hover:border-white/50 transition-all duration-300">
                    Daftar Jadi Pelanggan
                </a>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-slate-900 text-slate-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-16">
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-10">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white font-bold">AC</div>
                        <span class="font-bold text-white text-lg">CV Nisrina Jaya</span>
                    </div>
                    <p class="text-sm leading-relaxed text-slate-400">Solusi service & perawatan AC profesional untuk rumah, kantor, dan industri.</p>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-4">Layanan</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#services" class="hover:text-emerald-400 transition">Cuci AC</a></li>
                        <li><a href="#services" class="hover:text-emerald-400 transition">Isi Freon</a></li>
                        <li><a href="#services" class="hover:text-emerald-400 transition">Perbaikan AC</a></li>
                        <li><a href="#services" class="hover:text-emerald-400 transition">Bongkar Pasang</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-4">Perusahaan</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#about" class="hover:text-emerald-400 transition">Tentang</a></li>
                        <li><a href="#testimonials" class="hover:text-emerald-400 transition">Testimoni</a></li>
                        <li><a href="#contact" class="hover:text-emerald-400 transition">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-4">Ikuti Kami</h4>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 rounded-xl bg-slate-800 hover:bg-emerald-600 flex items-center justify-center transition"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg></a>
                        <a href="#" class="w-10 h-10 rounded-xl bg-slate-800 hover:bg-emerald-600 flex items-center justify-center transition"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg></a>
                        <a href="#" class="w-10 h-10 rounded-xl bg-slate-800 hover:bg-emerald-600 flex items-center justify-center transition"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/></svg></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-slate-800 mt-12 pt-8 text-center text-sm text-slate-500">
                &copy; {{ date('Y') }} CV Nisrina Jaya. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 80,
        });

        document.addEventListener('alpine:init', () => {
            Alpine.data('counter', (target) => ({
                count: 0,
                started: false,
                start() {
                    if (this.started) return;
                    this.started = true;
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                this.animateTo(target);
                                observer.disconnect();
                            }
                        });
                    }, { threshold: 0.3 });
                    observer.observe(this.$el);
                },
                animateTo(target) {
                    const duration = 2000;
                    const steps = 60;
                    const increment = target / steps;
                    let current = 0;
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            this.count = target;
                            clearInterval(timer);
                        } else {
                            this.count = Math.floor(current);
                        }
                    }, duration / steps);
                }
            }));

            Alpine.data('app', () => ({
                init() {}
            }));
        });
    </script>
</body>
</html>
