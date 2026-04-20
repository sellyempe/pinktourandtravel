<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="scroll-behavior: smooth;">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PinkTravel - Jelajahi Destinasi Impian Anda</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700" rel="stylesheet" />
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style></style>
        @endif
        <style>
            /* ── Hero Animations ────────────────────── */
            @keyframes heroZoom {
                from { transform: scale(1.08); }
                to   { transform: scale(1); }
            }
            @keyframes fadeSlideUp {
                from { opacity: 0; transform: translateY(30px); }
                to   { opacity: 1; transform: translateY(0); }
            }
            @keyframes floatParticle {
                0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0.3; }
                50%       { transform: translateY(-40px) rotate(180deg); opacity: 0.6; }
            }
            .hero-zoom {
                animation: heroZoom 8s ease-out forwards;
            }
            .hero-fade-1 { animation: fadeSlideUp 0.8s ease-out 0.2s both; }
            .hero-fade-2 { animation: fadeSlideUp 0.8s ease-out 0.4s both; }
            .hero-fade-3 { animation: fadeSlideUp 0.8s ease-out 0.6s both; }
            .hero-fade-4 { animation: fadeSlideUp 0.8s ease-out 0.8s both; }
            .hero-fade-5 { animation: fadeSlideUp 0.8s ease-out 1.0s both; }

            /* ── Particles ──────────────────────────── */
            .particle {
                position: absolute;
                border-radius: 50%;
                background: rgba(236,72,153,0.4);
                animation: floatParticle 6s ease-in-out infinite;
            }
            .particle-1 { width:12px; height:12px; top:20%; left:15%; animation-delay:0s; }
            .particle-2 { width:8px;  height:8px;  top:60%; right:20%; animation-delay:2s; }
            .particle-3 { width:16px; height:16px; bottom:25%; left:60%; animation-delay:4s; }

            /* ── Scroll Reveal ──────────────────────── */
            .reveal {
                opacity: 0;
                transform: translateY(40px);
                transition: opacity 0.7s ease, transform 0.7s ease;
            }
            .reveal.visible {
                opacity: 1;
                transform: translateY(0);
            }

            /* ── Section & Card Hover ───────────────── */
            .trip-card:hover, .dest-card:hover {
                transform: translateY(-6px);
                box-shadow: 0 20px 40px rgba(236,72,153,0.15);
            }
            .trip-card, .dest-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }

            /* ── Feature Icon bounce on hover ──────── */
            .feature-icon:hover { animation: none; transform: scale(1.1); }
        </style>
    </head>
    <body class="font-poppins bg-white text-gray-900">
        <!-- Navbar Component -->
        <div>
            <x-navbar></x-navbar>

            <!-- Hero Section -->
            <section id="beranda" class="relative min-h-screen flex items-center justify-center overflow-hidden">
                <!-- Background Image -->
                <div class="absolute inset-0">
                    <img src="/images/hero-travel.png" alt="Keindahan Indonesia" class="w-full h-full object-cover scale-105 hero-zoom">
                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-black/70"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-pink-900/30 via-transparent to-transparent"></div>
                </div>

                <!-- Floating particles -->
                <div class="absolute inset-0 overflow-hidden pointer-events-none">
                    <div class="particle particle-1"></div>
                    <div class="particle particle-2"></div>
                    <div class="particle particle-3"></div>
                </div>

                <!-- Content -->
                <div class="relative z-10 max-w-5xl mx-auto px-4 text-center">
                    <!-- Badge -->
                    <div class="hero-fade-1 inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-white text-sm font-medium mb-8">
                        <span class="w-2 h-2 bg-pink-400 rounded-full animate-pulse"></span>
                        Open Trip Tersedia — Ni Banda Neira
                    </div>

                    <h1 class="hero-fade-2 text-5xl md:text-7xl font-bold text-white mb-6 leading-tight tracking-tight">
                        Jelajahi Surga<br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-400 to-rose-300">Indonesia Bersamaku</span>
                    </h1>

                    <p class="hero-fade-3 text-xl text-white/80 mb-10 leading-relaxed max-w-2xl mx-auto">
                        Nikmati pengalaman wisata tak terlupakan ke pulau-pulau eksotis dengan pemandu profesional, itinerary lengkap, dan harga terjangkau.
                    </p>

                    <div class="hero-fade-4 flex flex-col sm:flex-row gap-4 justify-center mb-16">
                        <a href="{{ route('login') }}"
                           class="group px-8 py-4 bg-pink-600 hover:bg-pink-500 text-white rounded-2xl font-semibold transition-all shadow-lg shadow-pink-600/30 hover:shadow-pink-500/40 hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            <span>Pesan Sekarang</span>
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                        <a href="#destinasi"
                           class="px-8 py-4 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/30 text-white rounded-2xl font-semibold transition-all hover:-translate-y-0.5">
                            Jelajahi Destinasi
                        </a>
                    </div>

                    <!-- Floating Stats -->
                    <div class="hero-fade-5 grid grid-cols-3 gap-4 max-w-lg mx-auto">
                        <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl px-4 py-3 text-center">
                            <p class="text-2xl font-bold text-white">500+</p>
                            <p class="text-xs text-white/60 mt-0.5">Happy Traveler</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl px-4 py-3 text-center">
                            <p class="text-2xl font-bold text-white">15+</p>
                            <p class="text-xs text-white/60 mt-0.5">Destinasi</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl px-4 py-3 text-center">
                            <p class="text-2xl font-bold text-white">4.9★</p>
                            <p class="text-xs text-white/60 mt-0.5">Rating</p>
                        </div>
                    </div>
                </div>

                <!-- Scroll Indicator -->
                <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1 animate-bounce">
                    <span class="text-white/50 text-xs">Scroll</span>
                    <svg class="w-5 h-5 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </section>

            <!-- Explore Banda Neira Section - Featured Destination -->
            <section class="relative py-24 px-4 bg-white overflow-hidden">
                <!-- Decorative Blur -->
                <div class="absolute top-0 right-0 -mt-32 -mr-32 w-96 h-96 bg-pink-400/20 rounded-full blur-[100px] pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 -mb-32 -ml-32 w-96 h-96 bg-rose-400/20 rounded-full blur-[100px] pointer-events-none"></div>

                <div class="relative max-w-7xl mx-auto">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                        <!-- Left Content -->
                        <div class="reveal">
                            <span class="inline-flex items-center gap-2 px-4 py-2 bg-pink-50 border border-pink-100 text-pink-600 rounded-full text-sm font-bold mb-6 tracking-wide uppercase">
                                ✨ Featured Destination
                            </span>
                            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6 leading-tight tracking-tight">
                                Explore <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-rose-400">Banda Neira</span><br>with Us
                            </h2>
                            <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                                Kami menyediakan layanan open trip ke Banda Neira dengan informasi perjalanan yang lengkap dan mudah diakses. Anda dapat memilih kota keberangkatan, melihat detail itinerary, serta melakukan booking secara langsung.
                            </p>
                            <p class="text-lg text-gray-600 mb-10 leading-relaxed">
                                Perjalanan ini dirancang untuk memberikan pengalaman wisata yang aman, nyaman, dan berkesan bagi setiap peserta.
                            </p>
                            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-gray-900 hover:bg-gray-800 text-white rounded-2xl font-semibold transition-all hover:-translate-y-1 hover:shadow-xl hover:shadow-gray-900/20">
                                <span>Booking Sekarang</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </a>
                        </div>

                        <!-- Right Image -->
                        <div class="reveal relative">
                            <div class="absolute inset-0 bg-gradient-to-tr from-pink-500 to-rose-400 rounded-[2.5rem] transform rotate-3 scale-105 opacity-20 blur-xl"></div>
                            <div class="relative rounded-[2.5rem] overflow-hidden shadow-2xl border border-white/50">
                                <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&h=600&fit=crop" alt="Banda Neira" class="w-full h-auto object-cover hover:scale-105 transition-transform duration-700">
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Trips Section -->
            <section id="trips" class="py-24 px-4 bg-gray-50/50 border-t border-gray-100">
                <div class="max-w-7xl mx-auto">
                    <div class="text-center mb-16 reveal">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 tracking-tight">Opsi Keberangkatan <span class="text-pink-600">Banda Neira</span></h2>
                        <p class="text-lg text-gray-500">Pilih kota keberangkatan Anda untuk memulai perjalanan</p>
                    </div>

                    <!-- Trips Carousel -->
                    <div class="relative flex items-center gap-4">
                        <!-- Left Button -->
                        <button onclick="previousTripSlide()" class="flex-shrink-0 p-3 rounded-full border border-gray-300 hover:bg-gray-100 hover:border-pink-600 transition">
                            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>

                        <!-- Carousel Content -->
                        <div class="trips-carousel-container overflow-hidden flex-1">
                            <div class="trips-carousel-track flex transition-transform duration-500 ease-in-out" id="tripsCarouselTrack">
                                <!-- Trip slides loaded via JavaScript -->
                            </div>
                        </div>

                        <!-- Right Button -->
                        <button onclick="nextTripSlide()" class="flex-shrink-0 p-3 rounded-full border border-gray-300 hover:bg-gray-100 hover:border-pink-600 transition">
                            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Trip Carousel Dots -->
                    <div class="flex items-center justify-center gap-2 mt-8" id="tripCarouselDots">
                        <!-- Dots loaded via JavaScript -->
                    </div>
                </div>
            </section>

            <!-- Destinasi Section -->
            <section id="destinasi" class="py-24 px-4 bg-white border-t border-gray-100">
                <div class="max-w-7xl mx-auto">
                    <div class="text-center mb-16 reveal">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 tracking-tight">Destinasi <span class="text-pink-600">Lainnya</span></h2>
                        <p class="text-lg text-gray-500">Jelajahi berbagai destinasi menarik selain Banda Neira</p>
                    </div>

                    <!-- Carousel Container -->
                    <div class="relative flex items-center gap-4">
                        <!-- Left Button -->
                        <button onclick="previousSlide()" class="flex-shrink-0 p-3 rounded-full border border-gray-300 hover:bg-gray-100 hover:border-pink-600 transition">
                            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>

                        <!-- Carousel Content -->
                        <div class="carousel-container overflow-hidden flex-1">
                            <div class="carousel-track flex transition-transform duration-500 ease-in-out" id="carouselTrack">
                                <!-- Slides loaded via JavaScript -->
                            </div>
                        </div>

                        <!-- Right Button -->
                        <button onclick="nextSlide()" class="flex-shrink-0 p-3 rounded-full border border-gray-300 hover:bg-gray-100 hover:border-pink-600 transition">
                            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Carousel Dots - Bottom Center -->
                    <div class="flex items-center justify-center gap-2 mt-8" id="carouselDots">
                        <!-- Dots loaded via JavaScript -->
                    </div>
                </div>
            </section>

            <!-- Testimonials Section -->
            <section class="py-24 px-4 bg-gray-50/50 border-t border-gray-100">
                <div class="max-w-7xl mx-auto">
                    <div class="text-center mb-16 reveal">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 tracking-tight">Apa Kata <span class="text-pink-600">Traveler?</span></h2>
                        <p class="text-lg text-gray-500">Dengarkan pengalaman mereka yang telah menjelajahi keindahan Indonesia bersama kami</p>
                    </div>

                    <div id="testimonials-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <p class="col-span-full text-center text-gray-500">Memuat testimoni...</p>
                    </div>
                </div>
            </section>

            <!-- Features Section -->
            <section class="py-24 px-4 bg-white border-t border-gray-100">
                <div class="max-w-7xl mx-auto">
                    <div class="text-center mb-16 reveal">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 tracking-tight">Mengapa Memilih <span class="text-pink-600">PinkTravel?</span></h2>
                        <p class="text-lg text-gray-500">Kami memberikan layanan terbaik untuk memastikan perjalanan Anda tak terlupakan</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 reveal">
                        <div class="text-center group">
                            <div class="w-20 h-20 bg-pink-50 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:-translate-y-2 group-hover:shadow-lg group-hover:shadow-pink-100 transition-all duration-300 border border-pink-100/50">
                                <span class="text-4xl">👥</span>
                            </div>
                            <h3 class="font-bold text-gray-900 mb-2">Tim Profesional</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">Pemandu wisata berpengalaman dan bersertifikat</p>
                        </div>

                        <div class="text-center group">
                            <div class="w-20 h-20 bg-pink-50 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:-translate-y-2 group-hover:shadow-lg group-hover:shadow-pink-100 transition-all duration-300 border border-pink-100/50">
                                <span class="text-4xl">💰</span>
                            </div>
                            <h3 class="font-bold text-gray-900 mb-2">Harga Kompetitif</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">Paket wisata dengan harga terjangkau berkualitas</p>
                        </div>

                        <div class="text-center group">
                            <div class="w-20 h-20 bg-pink-50 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:-translate-y-2 group-hover:shadow-lg group-hover:shadow-pink-100 transition-all duration-300 border border-pink-100/50">
                                <span class="text-4xl">🛡️</span>
                            </div>
                            <h3 class="font-bold text-gray-900 mb-2">Jaminan Keamanan</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">Asuransi perjalanan dan perlindungan lengkap</p>
                        </div>

                        <div class="text-center group">
                            <div class="w-20 h-20 bg-pink-50 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:-translate-y-2 group-hover:shadow-lg group-hover:shadow-pink-100 transition-all duration-300 border border-pink-100/50">
                                <span class="text-4xl">⭐</span>
                            </div>
                            <h3 class="font-bold text-gray-900 mb-2">Terpercaya</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">Rating tinggi dari ribuan pelanggan yang puas</p>
                        </div>

                        <div class="text-center group">
                            <div class="w-20 h-20 bg-pink-50 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:-translate-y-2 group-hover:shadow-lg group-hover:shadow-pink-100 transition-all duration-300 border border-pink-100/50">
                                <span class="text-4xl">📅</span>
                            </div>
                            <h3 class="font-bold text-gray-900 mb-2">Fleksibel</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">Jadwal yang dapat disesuaikan dengan kebutuhan Anda</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CTA Section -->
            <section class="relative py-24 px-4 overflow-hidden">
                <div class="absolute inset-0 bg-gray-900"></div>
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-[40rem] h-[40rem] bg-pink-600/20 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/3"></div>
                <div class="absolute bottom-0 left-0 w-[30rem] h-[30rem] bg-rose-500/20 rounded-full blur-[80px] translate-y-1/3 -translate-x-1/4"></div>
                
                <div class="relative max-w-4xl mx-auto text-center z-10 reveal">
                    <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-6 tracking-tight">Siap Memulai <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-400 to-rose-300">Petualangan Baru?</span></h2>
                    <p class="text-xl text-gray-300 mb-10 leading-relaxed max-w-2xl mx-auto">
                        Hubungi kami hari ini dan dapatkan penawaran spesial untuk paket wisata impian Anda. Jangan lewatkan momen berharga!
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('login') }}" class="px-8 py-4 bg-pink-600 hover:bg-pink-500 text-white rounded-2xl font-bold transition-all hover:-translate-y-1 shadow-lg shadow-pink-600/30 flex items-center justify-center gap-2">
                            <span>Booking Sekarang</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                        <a href="tel:+62829510333" class="px-8 py-4 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white rounded-2xl font-bold transition-all hover:-translate-y-1 flex items-center justify-center gap-2">
                            <span>Hubungi Kami</span>
                        </a>
                    </div>
                </div>
            </section>
        </div>

        <!-- Footer Component -->
        <footer id="kontak" class="bg-gray-900 text-gray-300">
            <x-footer></x-footer>
        </footer>

        <script>
            let currentSlide = 0;
            let currentTripSlide = 0;
            let destinationsData = [];
            let tripsData = [];

            // Load departure trips as carousel
            async function loadTrips() {
                try {
                    const response = await fetch('/api/trips');
                    tripsData = await response.json();

                    // Generate trip slides - 4 trips per slide
                    const slides = [];
                    for (let i = 0; i < tripsData.length; i += 4) {
                        slides.push(tripsData.slice(i, i + 4));
                    }

                    const track = document.getElementById('tripsCarouselTrack');
                    track.innerHTML = slides.map((slide, slideIndex) => `
                        <div class="trips-carousel-slide min-w-full">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 px-4">
                                ${slide.map(trip => `
                                    <a href="/trip/${trip.id}" class="bg-white border border-gray-100 rounded-[2rem] overflow-hidden hover:border-pink-200 hover:shadow-xl hover:shadow-pink-100 transition-all duration-300 cursor-pointer group flex flex-col hover:-translate-y-1">
                                        <div class="aspect-[4/3] bg-gray-100 overflow-hidden relative">
                                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/50 to-transparent z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                            <img src="${trip.image}" alt="${trip.departure_city}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                            <div class="absolute top-4 right-4 z-20 px-3 py-1 bg-white/95 backdrop-blur-md rounded-full text-xs font-bold text-pink-600 shadow-sm border border-white/50">
                                                ${trip.duration_days} Hari
                                            </div>
                                        </div>
                                        <div class="p-6 flex-1 flex flex-col">
                                            <p class="text-pink-500 text-xs font-bold tracking-wider uppercase mb-1">Berangkat dari</p>
                                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex-1">${trip.departure_city.split(' - ')[0]}</h3>
                                            <div class="flex items-center justify-between pt-4 border-t border-gray-50 mt-auto">
                                                <span class="text-gray-500 text-xs">Mulai dari</span>
                                                <span class="text-lg font-extrabold text-pink-600">Rp ${(trip.price/1000000).toFixed(1)}J</span>
                                            </div>
                                        </div>
                                    </a>
                                `).join('')}
                            </div>
                        </div>
                    `).join('');

                    // Generate dots
                    const dotsContainer = document.getElementById('tripCarouselDots');
                    dotsContainer.innerHTML = slides.map((_, index) => `
                        <button onclick="goToTripSlide(${index})" class="w-3 h-3 rounded-full trip-carousel-dot ${index === 0 ? 'bg-pink-600' : 'bg-gray-300'}" data-slide="${index}"></button>
                    `).join('');

                } catch (error) {
                    console.error('Error loading trips:', error);
                }
            }

            function updateTripCarousel() {
                const track = document.getElementById('tripsCarouselTrack');
                track.style.transform = `translateX(-${currentTripSlide * 100}%)`;

                // Update dots
                document.querySelectorAll('.trip-carousel-dot').forEach((dot, index) => {
                    if (index === currentTripSlide) {
                        dot.classList.remove('bg-gray-300');
                        dot.classList.add('bg-pink-600');
                    } else {
                        dot.classList.remove('bg-pink-600');
                        dot.classList.add('bg-gray-300');
                    }
                });
            }

            function nextTripSlide() {
                const totalSlides = Math.ceil(tripsData.length / 4);
                currentTripSlide = (currentTripSlide + 1) % totalSlides;
                updateTripCarousel();
            }

            function previousTripSlide() {
                const totalSlides = Math.ceil(tripsData.length / 4);
                currentTripSlide = (currentTripSlide - 1 + totalSlides) % totalSlides;
                updateTripCarousel();
            }

            function goToTripSlide(slideNumber) {
                currentTripSlide = slideNumber;
                updateTripCarousel();
            }

            function updateCarousel() {
                const track = document.getElementById('carouselTrack');
                track.style.transform = `translateX(-${currentSlide * 100}%)`;

                // Update dots
                document.querySelectorAll('.carousel-dot').forEach((dot, index) => {
                    if (index === currentSlide) {
                        dot.classList.remove('bg-gray-300');
                        dot.classList.add('bg-pink-600');
                    } else {
                        dot.classList.remove('bg-pink-600');
                        dot.classList.add('bg-gray-300');
                    }
                });
            }

            function nextSlide() {
                const totalSlides = Math.ceil(destinationsData.length / 3);
                currentSlide = (currentSlide + 1) % totalSlides;
                updateCarousel();
            }

            function previousSlide() {
                const totalSlides = Math.ceil(destinationsData.length / 3);
                currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                updateCarousel();
            }

            function goToSlide(slideNumber) {
                currentSlide = slideNumber;
                updateCarousel();
            }

            async function loadDestinations() {
                try {
                    const response = await fetch('/api/destinations');
                    destinationsData = await response.json();
                    
                    // Generate slides - 3 destinations per slide
                    const slides = [];
                    for (let i = 0; i < destinationsData.length; i += 3) {
                        slides.push(destinationsData.slice(i, i + 3));
                    }

                    const track = document.getElementById('carouselTrack');
                    track.innerHTML = slides.map((slide, slideIndex) => `
                        <div class="carousel-slide min-w-full">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-4">
                                ${slide.map(destination => `
                                    <a href="/destination/${destination.id}" class="bg-gray-50 border border-gray-100 rounded-[2rem] overflow-hidden hover:border-pink-200 hover:shadow-xl hover:shadow-pink-100 transition-all duration-300 cursor-pointer group flex flex-col hover:-translate-y-1">
                                        <div class="aspect-[4/3] bg-gray-100 overflow-hidden relative">
                                            <img src="${destination.image}" alt="${destination.name}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                            <div class="absolute top-4 left-4 z-20 px-3 py-1 bg-gray-900/60 backdrop-blur-md rounded-full text-xs font-medium text-white border border-white/20 shadow-sm">
                                                ${destination.category}
                                            </div>
                                        </div>
                                        <div class="p-6 flex-1 flex flex-col">
                                            <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-pink-600 transition-colors">${destination.name}</h3>
                                            <p class="text-gray-500 text-sm mb-6 flex-1 leading-relaxed">${destination.description.length > 80 ? destination.description.substring(0, 80) + '...' : destination.description}</p>
                                            <div class="flex items-center gap-2 pt-4 border-t border-gray-200/60 mt-auto text-sm text-gray-600 font-medium">
                                                <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.242-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                ${destination.location}
                                            </div>
                                        </div>
                                    </a>
                                `).join('')}
                            </div>
                        </div>
                    `).join('');

                    // Generate dots
                    const dotsContainer = document.getElementById('carouselDots');
                    dotsContainer.innerHTML = slides.map((_, index) => `
                        <button onclick="goToSlide(${index})" class="w-3 h-3 rounded-full carousel-dot ${index === 0 ? 'bg-pink-600' : 'bg-gray-300'}" data-slide="${index}"></button>
                    `).join('');

                } catch (error) {
                    console.error('Error loading destinations:', error);
                }
            }

            // Load testimonials
            async function loadTestimonials() {
                try {
                    const response = await fetch('/api/reviews');
                    const reviews = await response.json();

                    const container = document.getElementById('testimonials-container');
                    
                    if (reviews.length === 0) {
                        container.innerHTML = '<p class="col-span-full text-center text-gray-500 py-8">Belum ada testimoni</p>';
                        return;
                    }

                    // Show max 6 reviews
                    const displayReviews = reviews.slice(0, 6);
                    container.innerHTML = displayReviews.map(review => `
                        <div class="bg-white rounded-[2rem] p-8 border border-gray-100 hover:border-pink-100 hover:shadow-xl hover:shadow-pink-50 transition-all duration-300 relative group">
                            <div class="absolute top-8 right-8 text-6xl text-gray-50 font-serif leading-none group-hover:text-pink-50 transition-colors duration-300">"</div>
                            <div class="flex items-center gap-4 mb-6 relative z-10">
                                <div class="w-14 h-14 bg-gradient-to-br from-pink-100 to-rose-100 rounded-2xl flex items-center justify-center text-xl font-bold text-pink-600 border border-white shadow-sm transform -rotate-3">
                                    ${review.user.name.charAt(0).toUpperCase()}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">${review.user.name}</p>
                                    <div class="text-yellow-400 text-sm flex gap-0.5 mt-1">${'⭐'.repeat(review.rating)}</div>
                                </div>
                            </div>
                            <p class="text-gray-600 leading-relaxed relative z-10">"${review.comment || 'Pengalaman wisata yang sangat berkesan dan terorganisir dengan sangat baik!'}"</p>
                        </div>
                    `).join('');
                } catch (error) {
                    console.error('Error loading testimonials:', error);
                    document.getElementById('testimonials-container').innerHTML = '<p class="col-span-full text-center text-red-500 py-8">Error memuat testimoni</p>';
                }
            }

            // Load destinations when page loads
            document.addEventListener('DOMContentLoaded', () => {
                loadTrips();
                loadDestinations();
                loadTestimonials();

                // ── Scroll Reveal ──────────────────────────────────────
                const revealObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('visible');
                        }
                    });
                }, { threshold: 0.12 });

                // Add reveal class to section headings & feature cards
                document.querySelectorAll(
                    '.reveal, #trips h2, #destinasi h2, #destinasi p, section h2, section > div > div:first-child, .text-center.mb-16'
                ).forEach(el => {
                    if (!el.classList.contains('reveal')) {
                        el.classList.add('reveal');
                    }
                    revealObserver.observe(el);
                });

                // ── Navbar scroll effect ───────────────────────────────
                const navbar = document.querySelector('x-navbar') || document.querySelector('nav');
                window.addEventListener('scroll', () => {
                    if (window.scrollY > 80 && navbar) {
                        navbar.classList.add('scrolled');
                    } else if (navbar) {
                        navbar.classList.remove('scrolled');
                    }
                });
            });
        </script>
    </body>
</html>