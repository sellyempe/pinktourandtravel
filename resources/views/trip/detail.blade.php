<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $trip->title }} - PinkTravel</title>
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

            <!-- Hero Section with Trip Image -->
            <section class="relative h-96 bg-gray-900 overflow-hidden">
                <img src="{{ $trip->image }}" alt="{{ $trip->title }}" class="w-full h-full object-cover opacity-70">
                <div class="absolute inset-0 bg-black/40 flex items-center">
                    <div class="max-w-7xl mx-auto px-4 w-full">
                        <a href="/" class="text-white mb-4 inline-flex items-center hover:text-pink-400 transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Kembali
                        </a>
                        <h1 class="text-5xl md:text-6xl font-bold text-white mb-4">{{ $trip->title }}</h1>
                        <div class="flex items-center gap-4">
                            <span class="px-4 py-2 bg-pink-600 text-white rounded-full font-semibold">{{ $trip->duration_days }} Hari</span>
                            <span class="text-xl text-white font-bold">Rp {{ number_format($trip->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main Content -->
            <section class="py-20 px-4 bg-gray-50">
                <div class="max-w-7xl mx-auto">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Main Content Column -->
                        <div class="lg:col-span-2">
                            <!-- Overview -->
                            <div class="bg-white rounded-lg p-8 mb-8 border border-gray-200">
                                <h2 class="text-3xl font-bold text-gray-900 mb-4">Tentang Paket Ini</h2>
                                <p class="text-gray-600 leading-relaxed mb-6">{{ $trip->description }}</p>
                                <p class="text-gray-600 leading-relaxed">{{ $trip->overview }}</p>
                            </div>

                            <!-- Meeting Point -->
                            <div class="bg-white rounded-lg p-8 mb-8 border border-gray-200">
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">📍 Titik Pemberangkatan</h2>
                                <p class="text-lg font-semibold text-gray-900">{{ $trip->meeting_point }}</p>
                                <p class="text-gray-600 mt-2">{{ $trip->meeting_address }}</p>
                            </div>

                            <!-- Itinerary -->
                            <div class="bg-white rounded-lg p-8 mb-8 border border-gray-200">
                                <h2 class="text-3xl font-bold text-gray-900 mb-8">📅 Jadwal Perjalanan</h2>
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
                            <div class="bg-white rounded-lg p-8 border border-gray-200 sticky top-24">
                                <h3 class="text-2xl font-bold text-gray-900 mb-6">Ringkasan Paket</h3>
                                
                                <div class="mb-6">
                                    <p class="text-gray-600 text-sm mb-1">Durasi</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $trip->duration_days }} Hari</p>
                                </div>

                                <div class="mb-6">
                                    <p class="text-gray-600 text-sm mb-1">Harga per Orang</p>
                                    <p class="text-3xl font-bold text-pink-600">Rp {{ number_format($trip->price, 0, ',', '.') }}</p>
                                </div>

                                <div class="flex gap-3 mb-4">
                                    @auth
                                    <a href="{{ route('booking.create', $trip->id) }}" class="flex-1 bg-pink-600 text-white font-bold py-3 rounded-lg hover:bg-pink-700 transition text-center">
                                        Pesan Sekarang
                                    </a>
                                    @else
                                    <a href="{{ route('login') }}" class="flex-1 bg-pink-600 text-white font-bold py-3 rounded-lg hover:bg-pink-700 transition text-center">
                                        Login untuk Pesan
                                    </a>
                                    @endauth
                                    @auth
                                    <button onclick="toggleWishlist('App\\Models\\Trip', {{ $trip->id }})" class="px-4 py-3 border-2 border-gray-300 rounded-lg hover:border-pink-600 transition" id="wishlist-btn-{{ $trip->id }}">
                                        <span id="wishlist-icon-{{ $trip->id }}">🤍</span>
                                    </button>
                                    @endauth
                                </div>

                                <!-- Includes -->
                                <div class="mb-6 border-t pt-6">
                                    <h4 class="font-bold text-gray-900 mb-4">✅ Yang Sudah Termasuk</h4>
                                    <ul class="space-y-3">
                                        @foreach($trip->includes as $include)
                                            <li class="flex items-start gap-3">
                                                <svg class="w-5 h-5 text-pink-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="text-gray-600">{{ $include->item_name }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <!-- Excludes -->
                                <div class="border-t pt-6">
                                    <h4 class="font-bold text-gray-900 mb-4">❌ Yang Tidak Termasuk</h4>
                                    <ul class="space-y-3">
                                        @foreach($trip->excludes as $exclude)
                                            <li class="flex items-start gap-3">
                                                <svg class="w-5 h-5 text-gray-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="text-gray-600">{{ $exclude->item_name }}</span>
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
            <section class="py-20 px-4 bg-white">
                <div class="max-w-4xl mx-auto">
                    <h2 class="text-3xl font-bold text-gray-900 mb-8">💬 Ulasan Traveler</h2>
                    
                    <div class="grid grid-cols-1 gap-8">
                        <!-- Reviews List -->
                        <div>
                            <div id="reviews-list" class="space-y-6 mb-12">
                                <p class="text-gray-500 text-center py-8">Memuat ulasan...</p>
                            </div>

                            <!-- Review Form or Login CTA -->
                            @auth
                            <div class="bg-pink-50 rounded-lg p-8 border border-pink-200">
                                <h3 class="text-xl font-bold text-gray-900 mb-6">Bagikan Pengalamanmu</h3>
                                <form id="review-form" class="space-y-4">
                                    @csrf
                                    
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Rating</label>
                                        <div class="flex gap-2" id="rating-stars">
                                            @for($i = 1; $i <= 5; $i++)
                                                <button type="button" onclick="setRating({{ $i }})" class="text-3xl hover:scale-110 transition" data-rating="{{ $i }}">
                                                    ⭐
                                                </button>
                                            @endfor
                                        </div>
                                        <input type="hidden" id="rating-value" name="rating" value="0">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Komentar</label>
                                        <textarea name="comment" id="comment" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-pink-600" placeholder="Bagikan pengalaman Anda..."></textarea>
                                    </div>

                                    <button type="submit" class="w-full bg-pink-600 text-white font-bold py-2 rounded-lg hover:bg-pink-700 transition">
                                        Kirim Ulasan
                                    </button>
                                </form>
                            </div>
                            @else
                            <div class="bg-pink-50 rounded-lg p-8 border border-pink-200 text-center">
                                <p class="text-gray-700 mb-4 text-lg">Ingin berbagi pengalaman Anda?</p>
                                <a href="{{ route('login') }}" class="inline-block px-8 py-3 bg-pink-600 text-white font-bold rounded-lg hover:bg-pink-700 transition">
                                    Login untuk Memberikan Ulasan
                                </a>
                            </div>
                            @endauth
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
            });

            // Load and display reviews
            async function loadReviews() {
                try {
                    const response = await fetch(`/api/reviews/${tripType}/${tripId}`);
                    const reviews = await response.json();

                    const reviewsList = document.getElementById('reviews-list');
                    
                    if (reviews.length === 0) {
                        reviewsList.innerHTML = '<p class="text-gray-500 text-center py-8">Belum ada ulasan untuk trip ini</p>';
                        return;
                    }

                    reviewsList.innerHTML = reviews.map(review => `
                        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <p class="font-semibold text-gray-900">${review.user.name}</p>
                                    <p class="text-sm text-gray-500">${new Date(review.created_at).toLocaleDateString('id-ID')}</p>
                                </div>
                                <div class="text-2xl">${'⭐'.repeat(review.rating)}</div>
                            </div>
                            <p class="text-gray-700">${review.comment || 'Tidak ada komentar'}</p>
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
            document.getElementById('review-form')?.addEventListener('submit', async function(e) {
                e.preventDefault();

                if (selectedRating === 0) {
                    alert('Pilih rating terlebih dahulu');
                    return;
                }

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
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        },
                        body: JSON.stringify(formData),
                    });

                    if (response.ok) {
                        alert('Ulasan berhasil dikirim! Menunggu persetujuan admin.');
                        this.reset();
                        setRating(0);
                        loadReviews();
                    } else {
                        const error = await response.json();
                        alert(error.message || 'Gagal mengirim ulasan');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Gagal mengirim ulasan');
                }
            });

            // Wishlist functions
            async function checkWishlist() {
                try {
                    const response = await fetch(`/api/wishlists/check/${tripType}/${tripId}`);
                    const data = await response.json();
                    updateWishlistButton(data.in_wishlist);
                } catch (error) {
                    console.error('Error checking wishlist:', error);
                }
            }

            async function toggleWishlist(type, itemId) {
                try {
                    const isInWishlist = document.getElementById(`wishlist-icon-${itemId}`).textContent === '❤️';

                    if (isInWishlist) {
                        // Remove from wishlist
                        const response = await fetch(`/api/wishlists/item/${type}/${itemId}`, {
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
        </script>
