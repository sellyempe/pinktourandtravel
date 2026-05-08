<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $trip->title }} - PinkTravel</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700" rel="stylesheet" />
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style></style>
        @endif
        
        {{-- Leaflet CSS --}}
        @if($trip->latitude && $trip->longitude)
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
        @endif
    </head>
    <body class="font-poppins bg-white text-gray-900">
        <!-- Navbar Component -->
        <div>
            <x-navbar></x-navbar>

            <!-- Hero Section with Trip Image -->
            <section class="relative h-[60vh] min-h-[500px] bg-gray-900 overflow-hidden flex items-end pb-16">
                <div class="absolute inset-0">
                    <img src="{{ $trip->image }}" alt="{{ $trip->title }}" class="w-full h-full object-cover">
                    <!-- Gradient Overlays -->
                    <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/20 to-black/80"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-pink-900/30 via-transparent to-transparent"></div>
                </div>
                
                <div class="relative z-10 max-w-7xl mx-auto px-4 w-full">
                    <a href="/" class="text-white/80 mb-6 inline-flex items-center hover:text-white transition group bg-white/10 backdrop-blur-md px-4 py-2 rounded-full border border-white/20 text-sm font-medium w-fit">
                        <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Kembali ke Beranda
                    </a>
                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold text-white mb-6 tracking-tight drop-shadow-lg">{{ $trip->title }}</h1>
                    <div class="flex flex-wrap items-center gap-4">
                        <span class="px-5 py-2.5 bg-pink-600 text-white rounded-full font-bold shadow-lg shadow-pink-600/30 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $trip->duration_days }} Hari
                        </span>
                        <span class="px-5 py-2.5 bg-white/10 backdrop-blur-md text-white border border-white/20 rounded-full font-bold flex items-center gap-2">
                            <span class="text-pink-400">Rp</span> {{ number_format($trip->price, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </section>

            <!-- Main Content -->
            <section class="py-24 px-4 bg-gray-50/50">
                <div class="max-w-7xl mx-auto">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                        <!-- Main Content Column -->
                        <div class="lg:col-span-2">
                            <!-- Overview -->
                            <div class="bg-white rounded-[2rem] p-8 md:p-10 mb-8 border border-gray-100 shadow-sm">
                                <h2 class="text-3xl font-extrabold text-gray-900 mb-6 tracking-tight">Tentang <span class="text-pink-600">Paket Ini</span></h2>
                                <p class="text-gray-600 leading-relaxed mb-6 text-lg">{{ $trip->description }}</p>
                                <p class="text-gray-600 leading-relaxed text-lg">{{ $trip->overview }}</p>
                            </div>

                            <!-- Meeting Point -->
                            <div class="bg-gradient-to-br from-pink-50 to-rose-50 rounded-[2rem] p-8 md:p-10 mb-8 border border-pink-100 shadow-sm relative overflow-hidden">
                                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-pink-200/50 rounded-full blur-2xl pointer-events-none"></div>
                                <h2 class="text-2xl font-extrabold text-gray-900 mb-6 relative z-10 flex items-center gap-3">
                                    <span class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm text-pink-500">📍</span> 
                                    Titik Pemberangkatan
                                </h2>
                                <div class="flex flex-col gap-6 relative z-10">
                                    <div>
                                        <p class="text-xl font-bold text-pink-900 mb-2">{{ $trip->meeting_point }}</p>
                                        <p class="text-pink-700/80 leading-relaxed">{{ $trip->meeting_address }}</p>
                                    </div>
                                    <div class="w-full h-64 md:h-80 rounded-2xl overflow-hidden shadow-inner border border-pink-200/50 bg-white relative z-0">
                                        @if($trip->latitude && $trip->longitude)
                                            <!-- Leaflet Map Container -->
                                            <div id="map" class="w-full h-full"></div>
                                        @else
                                            <!-- Fallback Iframe -->
                                            <iframe 
                                                width="100%" 
                                                height="100%" 
                                                style="border:0;" 
                                                loading="lazy" 
                                                allowfullscreen 
                                                referrerpolicy="no-referrer-when-downgrade"
                                                src="https://www.google.com/maps?q={{ urlencode($trip->meeting_address ?? $trip->meeting_point) }}&output=embed">
                                            </iframe>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Itinerary -->
                            <div class="bg-white rounded-[2rem] p-8 md:p-10 mb-8 border border-gray-100 shadow-sm">
                                <h2 class="text-3xl font-extrabold text-gray-900 mb-8 tracking-tight flex items-center gap-3">
                                    <span class="w-12 h-12 bg-pink-50 rounded-2xl flex items-center justify-center text-pink-500">📅</span>
                                    Jadwal Perjalanan
                                </h2>
                                <div class="space-y-8">
                                    @foreach($trip->itineraries as $itinerary)
                                        <div class="border-l-4 border-pink-600 pl-6 pb-8">
                                            <div class="flex items-center gap-3 mb-3">
                                                <span class="bg-pink-600 text-white rounded-full w-10 h-10 flex items-center justify-center font-bold">{{ $itinerary->day_number }}</span>
                                                <h3 class="text-2xl font-bold text-gray-900">{{ $itinerary->title }}</h3>
                                            </div>
                                            <p class="text-gray-600 mb-4">{{ $itinerary->description }}</p>
                                            
                                            @if($itinerary->activities)
                                                <div class="bg-gray-50 rounded-lg p-6 space-y-4">
                                                    @foreach($itinerary->activities as $activity)
                                                        <div class="flex gap-4">
                                                            <span class="text-pink-600 font-bold whitespace-nowrap">{{ $activity['time'] }}</span>
                                                            <div>
                                                                <p class="font-semibold text-gray-900">{{ $activity['activity'] }}</p>
                                                                <p class="text-gray-600 text-sm">{{ $activity['description'] }}</p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="lg:col-span-1">
                            <!-- Quick Info -->
                            <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-xl shadow-pink-50 sticky top-24">
                                <h3 class="text-2xl font-extrabold text-gray-900 mb-8 tracking-tight">Ringkasan Paket</h3>
                                
                                <div class="mb-6 bg-gray-50 rounded-2xl p-4 flex items-center justify-between">
                                    <p class="text-gray-500 font-medium">Durasi</p>
                                    <p class="text-xl font-bold text-gray-900">{{ $trip->duration_days }} Hari</p>
                                </div>

                                <div class="mb-8 p-4">
                                    <p class="text-gray-500 font-medium mb-1">Mulai dari</p>
                                    <p class="text-4xl font-extrabold text-pink-600">Rp {{ number_format($trip->price, 0, ',', '.') }}</p>
                                </div>

                                <div class="flex gap-3 mb-8">
                                    @auth
                                    <a href="{{ route('booking.create', $trip->id) }}" class="flex-1 bg-gray-900 text-white font-bold py-4 rounded-2xl hover:bg-gray-800 transition-all hover:-translate-y-1 shadow-lg shadow-gray-900/20 text-center flex items-center justify-center gap-2">
                                        Pesan Sekarang
                                    </a>
                                    @else
                                    <a href="{{ route('login') }}" class="flex-1 bg-pink-600 text-white font-bold py-4 rounded-2xl hover:bg-pink-700 transition-all hover:-translate-y-1 shadow-lg shadow-pink-600/30 text-center flex items-center justify-center gap-2">
                                        Login untuk Pesan
                                    </a>
                                    @endauth
                                    @auth
                                    <button onclick="toggleWishlist('App\\Models\\Trip', {{ $trip->id }})" class="w-14 h-14 flex items-center justify-center border border-gray-200 rounded-2xl hover:border-pink-300 hover:bg-pink-50 transition-all" id="wishlist-btn-{{ $trip->id }}">
                                        <span id="wishlist-icon-{{ $trip->id }}" class="text-xl">🤍</span>
                                    </button>
                                    @endauth
                                </div>

                                <!-- Includes -->
                                <div class="mb-6 border-t border-gray-100 pt-6">
                                    <h4 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                                        <span class="w-8 h-8 bg-green-50 text-green-500 rounded-lg flex items-center justify-center">✓</span> 
                                        Termasuk
                                    </h4>
                                    <ul class="space-y-3">
                                        @foreach($trip->includes as $include)
                                            <li class="flex items-start gap-3">
                                                <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                <span class="text-gray-600 font-medium">{{ $include->item_name }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <!-- Excludes -->
                                <div class="border-t border-gray-100 pt-6">
                                    <h4 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                                        <span class="w-8 h-8 bg-red-50 text-red-500 rounded-lg flex items-center justify-center">✕</span> 
                                        Tidak Termasuk
                                    </h4>
                                    <ul class="space-y-3">
                                        @foreach($trip->excludes as $exclude)
                                            <li class="flex items-start gap-3">
                                                <svg class="w-5 h-5 text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                <span class="text-gray-500">{{ $exclude->item_name }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Reviews Section -->
            <section class="py-24 px-4 bg-white border-t border-gray-100">
                <div class="max-w-4xl mx-auto">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-12 tracking-tight text-center">Apa Kata <span class="text-pink-600">Traveler?</span></h2>
                    
                    <div class="grid grid-cols-1 gap-12">
                        <!-- Reviews List -->
                        <div>
                            <div id="reviews-list" class="space-y-6 mb-16">
                                <p class="text-gray-500 text-center py-8">Memuat ulasan...</p>
                            </div>

                            <!-- Review Form -->
                            @if(isset($canReview) && $canReview)
                            <div class="bg-gray-50 rounded-[2rem] p-8 md:p-10 border border-gray-100 shadow-sm relative overflow-hidden mt-8">
                                <div class="absolute top-0 right-0 w-64 h-64 bg-pink-100/50 rounded-full blur-3xl -mt-20 -mr-20 pointer-events-none"></div>
                                <h3 class="text-2xl font-extrabold text-gray-900 mb-8 relative z-10">Bagikan Pengalamanmu</h3>
                                <form id="review-form" class="space-y-6 relative z-10">
                                    @csrf
                                    
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-3">Rating Anda</label>
                                        <div class="flex gap-2" id="rating-stars">
                                            @for($i = 1; $i <= 5; $i++)
                                                <button type="button" onclick="setRating({{ $i }})" class="text-4xl hover:scale-110 transition-transform filter drop-shadow-sm" data-rating="{{ $i }}" style="opacity: 0.3;">
                                                    ⭐
                                                </button>
                                            @endfor
                                        </div>
                                        <input type="hidden" id="rating-value" name="rating" value="0">
                                        <p id="rating-error-msg" class="text-red-500 text-sm font-medium mt-2 hidden">Silakan pilih rating terlebih dahulu</p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-3">Ceritakan Pengalaman Anda</label>
                                        <textarea name="comment" id="comment" rows="4" class="w-full px-6 py-4 bg-white border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-shadow resize-none" placeholder="Bagaimana perjalanan Anda bersama kami?"></textarea>
                                    </div>

                                    <button type="button" onclick="submitTripReview()" id="btnSubmitTripReview" class="w-full bg-pink-600 hover:bg-pink-500 text-white font-bold py-4 rounded-2xl transition-all hover:-translate-y-1 shadow-lg shadow-pink-600/30">
                                        Kirim Ulasan
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            <!-- Footer -->
            <x-footer></x-footer>
        </div>

        <script>
            const tripId = {{ $trip->id }};
            const tripType = 'App\\Models\\Trip';
            let selectedRating = 0;

            // Load reviews on page load
            document.addEventListener('DOMContentLoaded', function() {
                loadReviews();
                @auth
                    checkWishlist();
                @endauth

                // Navbar scroll effect
                const navbar = document.querySelector('x-navbar') || document.querySelector('nav');
                window.addEventListener('scroll', () => {
                    if (window.scrollY > 80 && navbar) {
                        navbar.classList.add('scrolled');
                    } else if (navbar) {
                        navbar.classList.remove('scrolled');
                    }
                });
            });

            // Load and display reviews
            async function loadReviews() {
                try {
                    const response = await fetch(`/api/reviews/trip/${tripId}`);
                    
                    if (!response.ok) throw new Error('Network response was not ok');
                    
                    const reviews = await response.json();

                    const reviewsList = document.getElementById('reviews-list');
                    
                    if (reviews.length === 0) {
                        reviewsList.innerHTML = '<p class="text-gray-500 text-center py-8">Belum ada ulasan untuk trip ini</p>';
                        return;
                    }

                    reviewsList.innerHTML = reviews.map(review => `
                        <div class="bg-white rounded-[2rem] p-8 border border-gray-100 hover:shadow-xl hover:shadow-gray-100/50 transition-all duration-300">
                            <div class="flex items-center justify-between mb-6 border-b border-gray-50 pb-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-pink-50 text-pink-600 font-bold text-lg rounded-2xl flex items-center justify-center">
                                        ${review.user.name.charAt(0).toUpperCase()}
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900">${review.user.name}</p>
                                        <p class="text-xs text-gray-400 font-medium">${new Date(review.created_at).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' })}</p>
                                    </div>
                                </div>
                                <div class="text-yellow-400 text-sm flex gap-0.5">${'⭐'.repeat(review.rating)}</div>
                            </div>
                            <p class="text-gray-600 leading-relaxed">${review.comment || 'Tidak ada komentar'}</p>
                        </div>
                    `).join('');
                } catch (error) {
                    console.error('Error loading reviews:', error);
                }
            }

            // Set rating stars
            function setRating(rating) {
                selectedRating = rating;
                document.getElementById('rating-value').value = rating;
                
                const stars = document.querySelectorAll('#rating-stars button');
                stars.forEach((star, index) => {
                    if (index < rating) {
                        star.style.opacity = '1';
                        star.textContent = '⭐';
                    } else {
                        star.style.opacity = '0.3';
                        star.textContent = '⭐';
                    }
                });
            }

            // Submit review
            async function submitTripReview() {
                if (selectedRating === 0) {
                    document.getElementById('rating-error-msg').classList.remove('hidden');
                    return;
                }

                const btn = document.getElementById('btnSubmitTripReview');
                btn.disabled = true;
                btn.innerHTML = 'Mengirim...';

                const formData = {
                    reviewable_type: tripType,
                    reviewable_id: tripId,
                    rating: selectedRating,
                    comment: document.getElementById('comment').value,
                };

                try {
                    const response = await fetch('/api/reviews', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')?.value || '{{ csrf_token() }}',
                        },
                        body: JSON.stringify(formData),
                    });

                    if (response.ok) {
                        alert('Ulasan berhasil dikirim!');
                        document.getElementById('review-form').reset();
                        setRating(0);
                        loadReviews();
                    } else {
                        const error = await response.json();
                        alert(error.message || 'Gagal mengirim ulasan');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Gagal mengirim ulasan');
                } finally {
                    btn.disabled = false;
                    btn.innerHTML = 'Kirim Ulasan';
                }
            }

            // Wishlist functions
            async function checkWishlist() {
                try {
                    const encodedType = encodeURIComponent(tripType);
                    const response = await fetch(`/api/wishlists/check/${encodedType}/${tripId}`);
                    if (response.ok) {
                        const data = await response.json();
                        updateWishlistButton(data.in_wishlist);
                    }
                } catch (error) {
                    console.error('Error checking wishlist:', error);
                }
            }

            async function toggleWishlist(type, itemId) {
                try {
                    const isInWishlist = document.getElementById(`wishlist-icon-${itemId}`).textContent === '❤️';
                    const encodedType = encodeURIComponent(type);

                    if (isInWishlist) {
                        // Remove from wishlist
                        const response = await fetch(`/api/wishlists/item/${encodedType}/${itemId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                            },
                        });
                        if (response.ok) {
                            updateWishlistButton(false);
                        }
                    } else {
                        // Add to wishlist
                        const response = await fetch('/api/wishlists', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                            },
                            body: JSON.stringify({
                                wishlistable_type: type,
                                wishlistable_id: itemId,
                            }),
                        });
                        if (response.ok) {
                            updateWishlistButton(true);
                        }
                    }
                } catch (error) {
                    console.error('Error toggling wishlist:', error);
                }
            }

            function updateWishlistButton(isInWishlist) {
                const icon = document.getElementById(`wishlist-icon-${tripId}`);
                if (icon) {
                    icon.textContent = isInWishlist ? '❤️' : '🤍';
                }
            }

            // Panggil saat halaman dimuat
            @auth
            checkWishlist();
            @endauth

            @if($trip->latitude && $trip->longitude)
            // Initialize Leaflet Map for Trip Detail
            document.addEventListener('DOMContentLoaded', function() {
                const lat = {{ $trip->latitude }};
                const lng = {{ $trip->longitude }};
                const map = L.map('map').setView([lat, lng], 14);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);

                const marker = L.marker([lat, lng]).addTo(map);
                marker.bindPopup(`<b>{{ $trip->meeting_point }}</b><br>{{ $trip->meeting_address }}`).openPopup();

                // Fix rendering if it's hidden initially
                setTimeout(() => map.invalidateSize(), 500);
            });
            @endif
        </script>

        @if($trip->latitude && $trip->longitude)
        {{-- Leaflet JS --}}
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        @endif
    </body>
</html>