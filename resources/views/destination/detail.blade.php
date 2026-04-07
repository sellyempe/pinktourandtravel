<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $destination->name }} - PinkTravel</title>
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

            <!-- Detail Section -->
            <section class="py-20 px-4 bg-white">
                <div class="max-w-4xl mx-auto">
                    <!-- Back Button -->
                    <a href="/" class="inline-flex items-center gap-2 text-pink-600 hover:text-pink-700 mb-8">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Kembali ke Destinasi
                    </a>

                    <!-- Destination Title -->
                    <h1 class="text-5xl font-bold text-gray-900 mb-4">{{ $destination->name }}</h1>
                    
                    <!-- Category & Location -->
                    <div class="flex flex-wrap gap-4 mb-8">
                        <span class="inline-block px-4 py-2 bg-pink-100 text-pink-700 rounded-full text-sm font-semibold">
                            {{ $destination->category }}
                        </span>
                        <span class="inline-block px-4 py-2 bg-gray-100 text-gray-700 rounded-full text-sm font-semibold">
                            📍 {{ $destination->location }}
                        </span>
                    </div>

                    <!-- Description -->
                    <div class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Deskripsi</h2>
                        <p class="text-lg text-gray-600 leading-relaxed">
                            {{ $destination->description }}
                        </p>
                    </div>

                    <!-- Interesting Fact -->
                    <div class="bg-pink-50 border-l-4 border-pink-600 p-8 rounded-lg mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">✨ Fakta Menarik</h2>
                        <p class="text-lg text-gray-700 leading-relaxed">
                            {{ $destination->interesting_fact }}
                        </p>
                    </div>

                    <!-- CTA Section -->
                    <div class="bg-gray-900 text-white p-8 rounded-lg text-center">
                        <h2 class="text-2xl font-bold mb-4">Ingin Mengunjungi Destinasi Ini?</h2>
                        <p class="text-gray-300 mb-6">Pesan paket wisata Anda sekarang dan dapatkan pengalaman tak terlupakan</p>
                        <div class="flex gap-4 justify-center">
                            <a href="{{ route('login') }}" class="inline-block px-8 py-3 bg-pink-600 text-white rounded-lg font-semibold hover:bg-pink-700 transition">
                                Booking Sekarang
                            </a>
                            @auth
                            <button onclick="toggleWishlist('App\\Models\\Destination', {{ $destination->id }})" class="px-8 py-3 border-2 border-white text-white rounded-lg hover:bg-white hover:text-gray-900 transition font-semibold" id="wishlist-btn-{{ $destination->id }}">
                                <span id="wishlist-icon-{{ $destination->id }}">🤍 Favorit</span>
                            </button>
                            @endauth
                        </div>
                    </div>

                    <!-- Reviews Section -->
                    <div class="mt-12">
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
                </div>
            </section>
        </div>

        <!-- Footer Component -->
        <x-footer></x-footer>

        <script>
            const destinationId = {{ $destination->id }};
            const destinationType = 'App\\Models\\Destination';
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
                    const response = await fetch(`/api/reviews/${destinationType}/${destinationId}`);
                    const reviews = await response.json();

                    const reviewsList = document.getElementById('reviews-list');
                    
                    if (reviews.length === 0) {
                        reviewsList.innerHTML = '<p class="text-gray-500 text-center py-8">Belum ada ulasan untuk destinasi ini</p>';
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
                    reviewable_type: destinationType,
                    reviewable_id: destinationId,
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
                    const response = await fetch(`/api/wishlists/check/${destinationType}/${destinationId}`);
                    const data = await response.json();
                    updateWishlistButton(data.in_wishlist);
                } catch (error) {
                    console.error('Error checking wishlist:', error);
                }
            }

            async function toggleWishlist(type, itemId) {
                try {
                    const isInWishlist = document.getElementById(`wishlist-icon-${itemId}`).textContent.includes('❤️');

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
                const icon = document.getElementById(`wishlist-icon-${destinationId}`);
                if (icon) {
                    icon.innerHTML = isInWishlist ? '❤️ Favorit' : '🤍 Favorit';
                }
            }
        </script>
