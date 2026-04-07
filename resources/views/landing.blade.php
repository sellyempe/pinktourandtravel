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
    </head>
    <body class="font-poppins bg-white text-gray-900">
        <!-- Navbar Component -->
        <div class="pt-16">
            <x-navbar></x-navbar>

            <!-- Hero Section -->
            <section id="beranda" class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100 px-4">
                <div class="max-w-3xl text-center">
                    <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                        Jelajahi Destinasi<br>Impian Anda
                    </h1>
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                        Nikmati pengalaman wisata tak terlupakan dengan paket wisata berkualitas tinggi, pemandu profesional, dan layanan terbaik di kelasnya.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('login') }}" class="px-8 py-3 bg-pink-600 text-white rounded-lg font-semibold hover:bg-pink-700 transition">
                            Pesan Sekarang
                        </a>
                        <a href="#destinasi" class="px-8 py-3 border border-pink-300 text-pink-600 rounded-lg font-semibold hover:bg-pink-50 transition">
                            Jelajahi Lebih
                        </a>
                    </div>
                </div>
            </section>

            <!-- Explore Banda Neira Section - Featured Destination -->
            <section class="py-20 px-4 bg-gradient-to-br from-pink-50 to-rose-50">
                <div class="max-w-7xl mx-auto">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                        <!-- Left Content -->
                        <div>
                            <span class="inline-block px-4 py-2 bg-pink-100 text-pink-700 rounded-full text-sm font-semibold mb-4">✨ Featured Destination</span>
                            <h2 class="text-5xl font-bold text-pink-600 mb-6 leading-tight">
                                Explore<br>Banda Neira<br>with Us
                            </h2>
                            <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                                Kami menyediakan layanan open trip ke Banda Neira dengan informasi perjalanan yang lengkap dan mudah diakses. Anda dapat memilih kota keberangkatan, melihat detail itinerary, serta melakukan booking secara langsung.
                            </p>
                            <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                                Perjalanan ini dirancang untuk memberikan pengalaman wisata yang aman, nyaman, dan berkesan bagi setiap peserta.
                            </p>
                            <a href="{{ route('login') }}" class="inline-block px-8 py-3 bg-pink-600 text-white rounded-lg font-semibold hover:bg-pink-700 transition">
                                Booking Sekarang
                            </a>
                        </div>

                        <!-- Right Image -->
                        <div>
                            <div class="rounded-2xl overflow-hidden shadow-xl">
                                <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600&h=400&fit=crop" alt="Banda Neira Mountain" class="w-full h-auto object-cover">
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Trips Section -->
            <section id="trips" class="py-20 px-4 bg-white">
                <div class="max-w-7xl mx-auto">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl font-bold text-gray-900 mb-4">Opsi Keberangkatan Trip Banda Neira</h2>
                        <p class="text-lg text-gray-600">Pilih kota keberangkatan Anda</p>
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
            <section id="destinasi" class="py-20 px-4 bg-pink-50">
                <div class="max-w-7xl mx-auto">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl font-bold text-gray-900 mb-4">Destinasi Wisata Lainnya</h2>
                        <p class="text-lg text-gray-600">Jelajahi berbagai destinasi menarik lainnya</p>
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
            <section class="py-20 px-4 bg-white">
                <div class="max-w-7xl mx-auto">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl font-bold text-gray-900 mb-4">Testimoni Traveler</h2>
                        <p class="text-lg text-gray-600">Dengarkan pengalaman traveler yang telah menggunakan layanan kami</p>
                    </div>

                    <div id="testimonials-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <p class="col-span-full text-center text-gray-500">Memuat testimoni...</p>
                    </div>
                </div>
            </section>

            <!-- Features Section -->
            <section class="py-20 px-4 bg-gray-50">
                <div class="max-w-7xl mx-auto">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl font-bold text-gray-900 mb-4">Mengapa Memilih Kami?</h2>
                        <p class="text-lg text-gray-600">Layanan terbaik untuk pengalaman wisata Anda</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center mx-auto mb-4">
                                <span class="text-3xl">👥</span>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-2">Tim Profesional</h3>
                            <p class="text-gray-600 text-sm">Pemandu wisata berpengalaman dan bersertifikat</p>
                        </div>

                        <div class="text-center">
                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center mx-auto mb-4">
                                <span class="text-3xl">💰</span>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-2">Harga Kompetitif</h3>
                            <p class="text-gray-600 text-sm">Paket wisata dengan harga terjangkau berkualitas</p>
                        </div>

                        <div class="text-center">
                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center mx-auto mb-4">
                                <span class="text-3xl">🛡️</span>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-2">Jaminan Keamanan</h3>
                            <p class="text-gray-600 text-sm">Asuransi perjalanan dan perlindungan lengkap</p>
                        </div>

                        <div class="text-center">
                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center mx-auto mb-4">
                                <span class="text-3xl">⭐</span>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-2">Terpercaya</h3>
                            <p class="text-gray-600 text-sm">Rating tinggi dari ribuan pelanggan puas</p>
                        </div>

                        <div class="text-center">
                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center mx-auto mb-4">
                                <span class="text-3xl">📅</span>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-2">Fleksibel</h3>
                            <p class="text-gray-600 text-sm">Jadwal dapat disesuaikan dengan kebutuhan</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CTA Section -->
            <section class="py-20 px-4 bg-gradient-to-r from-pink-600 to-pink-700 text-white">
                <div class="max-w-3xl mx-auto text-center">
                    <h2 class="text-4xl font-bold mb-6">Siap Memulai Petualangan?</h2>
                    <p class="text-lg text-gray-300 mb-8">
                        Hubungi kami hari ini dan dapatkan penawaran spesial untuk paket wisata impian Anda.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('login') }}" class="px-8 py-3 bg-white text-pink-600 rounded-lg font-semibold hover:bg-pink-50 transition">
                            Booking Sekarang
                        </a>
                        <a href="tel:+62829510333" class="px-8 py-3 border border-white text-white rounded-lg font-semibold hover:bg-pink-500 transition">
                            Hubungi Kami
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
                                    <a href="/trip/${trip.id}" class="border border-gray-200 rounded-lg overflow-hidden hover:border-pink-600 hover:shadow-lg transition bg-gray-50 cursor-pointer group">
                                        <div class="aspect-square bg-gray-100 overflow-hidden">
                                            <img src="${trip.image}" alt="${trip.departure_city}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                        </div>
                                        <div class="p-6">
                                            <h3 class="text-xl font-semibold text-gray-900 mb-2">${trip.departure_city}</h3>
                                            <p class="text-gray-600 text-sm mb-4">➜ ${trip.destination}</p>
                                            <div class="flex items-center justify-between">
                                                <span class="inline-block px-2 py-1 bg-pink-100 text-pink-700 rounded text-xs font-semibold">
                                                    ${trip.duration_days} Hari
                                                </span>
                                                <span class="text-sm font-bold text-pink-600">Rp ${(trip.price/1000000).toFixed(1)}J</span>
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
                                    <a href="/destination/${destination.id}" class="border border-gray-200 rounded-lg overflow-hidden hover:border-pink-600 hover:shadow-lg transition bg-gray-50 cursor-pointer group">
                                        <div class="aspect-square bg-gray-100 overflow-hidden">
                                            <img src="${destination.image}" alt="${destination.name}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                        </div>
                                        <div class="p-6">
                                            <h3 class="text-xl font-semibold text-gray-900 mb-2">${destination.name}</h3>
                                            <p class="text-gray-600 text-sm mb-4">${destination.description.length > 50 ? destination.description.substring(0, 50) + '...' : destination.description}</p>
                                            <div class="flex items-center justify-between">
                                                <span class="inline-block px-2 py-1 bg-pink-100 text-pink-700 rounded text-xs font-semibold">
                                                    ${destination.category}
                                                </span>
                                                <span class="text-sm text-gray-600">📍 ${destination.location}</span>
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
                        <div class="bg-white rounded-lg p-8 border border-gray-200 hover:shadow-lg transition">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-12 h-12 bg-teal-100 rounded-full flex items-center justify-center text-lg font-bold text-teal-600">
                                    ${review.user.name.charAt(0).toUpperCase()}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">${review.user.name}</p>
                                    <div class="text-yellow-400">${'⭐'.repeat(review.rating)}</div>
                                </div>
                            </div>
                            <p class="text-gray-600 leading-relaxed italic">"${review.comment || 'Pengalaman yang luar biasa!'}"</p>
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
            });
        </script>
    </body>
</html>