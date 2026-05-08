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
        <div>
            <x-navbar></x-navbar>

            <!-- Hero Section with Destination Image -->
            <section class="relative h-[60vh] min-h-[500px] bg-gray-900 overflow-hidden flex items-end pb-16">
                <div class="absolute inset-0">
                    <img src="{{ $destination->image }}" alt="{{ $destination->name }}" class="w-full h-full object-cover">
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
                    <div class="flex flex-wrap gap-3 mb-4">
                        <span class="px-4 py-1.5 bg-pink-600/90 backdrop-blur-md text-white rounded-full text-sm font-bold shadow-lg shadow-pink-600/30 uppercase tracking-wide">
                            {{ $destination->category }}
                        </span>
                        <span class="px-4 py-1.5 bg-white/10 backdrop-blur-md border border-white/20 text-white rounded-full text-sm font-bold flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.242-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $destination->location }}
                        </span>
                    </div>
                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold text-white tracking-tight drop-shadow-lg">{{ $destination->name }}</h1>
                </div>
            </section>

            <!-- Detail Section -->
            <section class="py-24 px-4 bg-gray-50/50">
                <div class="max-w-4xl mx-auto">

                    <!-- Description -->
                    <div class="bg-white rounded-[2rem] p-8 md:p-10 mb-8 border border-gray-100 shadow-sm">
                        <h2 class="text-3xl font-extrabold text-gray-900 mb-6 tracking-tight">Tentang <span class="text-pink-600">Destinasi Ini</span></h2>
                        <p class="text-lg text-gray-600 leading-relaxed">
                            {{ $destination->description }}
                        </p>
                    </div>

                    <!-- Interesting Fact -->
                    <div class="bg-gradient-to-br from-pink-50 to-rose-50 rounded-[2rem] p-8 md:p-10 mb-8 border border-pink-100 shadow-sm relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-pink-200/50 rounded-full blur-2xl"></div>
                        <h2 class="text-2xl font-extrabold text-gray-900 mb-6 relative z-10 flex items-center gap-3">
                            <span class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm text-pink-500">✨</span> 
                            Fakta Menarik
                        </h2>
                        <p class="text-lg text-pink-900/80 font-medium leading-relaxed relative z-10">
                            "{{ $destination->interesting_fact }}"
                        </p>
                    </div>

                    <!-- CTA Section -->
                    <div class="bg-gray-900 rounded-[2rem] p-10 mb-16 shadow-xl shadow-gray-900/20 text-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-pink-900/20 to-transparent"></div>
                        <h2 class="text-3xl font-extrabold text-white mb-4 relative z-10 tracking-tight">Ingin Mengunjungi Destinasi Ini?</h2>
                        <p class="text-gray-300 mb-8 text-lg relative z-10">Pesan paket wisata Anda sekarang dan dapatkan pengalaman tak terlupakan</p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center relative z-10">
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-4 bg-pink-600 hover:bg-pink-500 text-white rounded-2xl font-bold transition-all hover:-translate-y-1 shadow-lg shadow-pink-600/30 gap-2">
                                Booking Sekarang
                            </a>
                            @auth
                            <button onclick="toggleWishlist('App\\Models\\Destination', {{ $destination->id }})" class="inline-flex items-center justify-center px-8 py-4 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white rounded-2xl font-bold transition-all hover:-translate-y-1 gap-2" id="wishlist-btn-{{ $destination->id }}">
                                <span id="wishlist-icon-{{ $destination->id }}">🤍</span> Tambah ke Favorit
                            </button>
                            @endauth
                        </div>
                    </div>

                    <!-- Reviews Section -->
                    <div class="mt-12">
                        <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-12 tracking-tight text-center">Apa Kata <span class="text-pink-600">Traveler?</span></h2>
                        
                        <div class="grid grid-cols-1 gap-12">
                            <!-- Reviews List -->
                            <div>
                                <div id="reviews-list" class="space-y-6 mb-16">
                                    <p class="text-gray-500 text-center py-8">Memuat ulasan...</p>
                                </div>

                                <!-- Review Form or Login CTA -->
                                @auth
                                    @if(isset($hasReviewed) && !$hasReviewed)
                                    <div class="bg-gray-50 rounded-[2rem] p-8 md:p-10 border border-gray-100 shadow-sm relative overflow-hidden">
                                        <div class="absolute top-0 right-0 w-64 h-64 bg-pink-100/50 rounded-full blur-3xl -mt-20 -mr-20"></div>
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
                                                <textarea name="comment" id="comment" rows="4" class="w-full px-6 py-4 bg-white border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-shadow resize-none" placeholder="Bagaimana pengalaman Anda di destinasi ini?"></textarea>
                                            </div>

                                            <button type="button" onclick="submitDestinationReview()" id="btnSubmitDestinationReview" class="w-full bg-pink-600 hover:bg-pink-500 text-white font-bold py-4 rounded-2xl transition-all hover:-translate-y-1 shadow-lg shadow-pink-600/30">
                                                Kirim Ulasan
                                            </button>
                                        </form>
                                    </div>
                                    @else
                                    <div class="bg-gray-50 rounded-[2rem] p-10 border border-gray-100 text-center shadow-sm">
                                        <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-blue-100">
                                            <span class="text-2xl">✨</span>
                                        </div>
                                        <h3 class="text-xl font-bold text-gray-900 mb-2">Terima kasih atas ulasan Anda!</h3>
                                        <p class="text-gray-500">Anda sudah membagikan pengalaman untuk destinasi ini.</p>
                                    </div>
                                    @endif
                                @else
                                <div class="bg-gray-50 rounded-[2rem] p-10 border border-gray-100 text-center shadow-sm">
                                    <div class="w-16 h-16 bg-pink-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                                        <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                                    </div>
                                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Ingin berbagi pengalaman?</h3>
                                    <p class="text-gray-500 mb-8">Login terlebih dahulu untuk meninggalkan ulasan Anda mengenai destinasi ini.</p>
                                    <a href="{{ route('login') }}" class="inline-flex px-8 py-4 bg-gray-900 text-white font-bold rounded-2xl hover:bg-gray-800 transition-all hover:-translate-y-1 shadow-lg shadow-gray-900/20">
                                        Ke Halaman Login
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
                    const response = await fetch(`/api/reviews/destination/${destinationId}`);
                    
                    if (!response.ok) throw new Error('Network response was not ok');
                    
                    const reviews = await response.json();

                    const reviewsList = document.getElementById('reviews-list');
                    
                    if (reviews.length === 0) {
                        reviewsList.innerHTML = '<p class="text-gray-500 text-center py-8">Belum ada ulasan untuk destinasi ini</p>';
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
            async function submitDestinationReview() {
                if (selectedRating === 0) {
                    document.getElementById('rating-error-msg').classList.remove('hidden');
                    return;
                }

                const btn = document.getElementById('btnSubmitDestinationReview');
                btn.disabled = true;
                btn.innerHTML = 'Mengirim...';

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