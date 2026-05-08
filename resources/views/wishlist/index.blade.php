<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Wishlist Saya - PinkTravel</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-poppins bg-gray-50/50 text-gray-900 min-h-screen flex flex-col">

    <!-- Navbar -->
    <x-navbar alwaysScrolled="true"></x-navbar>

    <!-- Main Content -->
    <main class="flex-grow pt-28 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Wishlist Saya</h1>
                    <p class="text-gray-500 mt-2">Daftar impian perjalanan Anda yang tersimpan.</p>
                </div>
            </div>

            @if($wishlists->isEmpty())
                <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm p-16 text-center">
                    <div class="w-24 h-24 bg-pink-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-4xl">🤍</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Wishlist Masih Kosong</h3>
                    <p class="text-gray-500 max-w-md mx-auto mb-8">Anda belum menambahkan trip atau destinasi apa pun ke dalam daftar impian. Yuk, mulai eksplorasi dan simpan tempat favorit Anda!</p>
                    <a href="/" class="inline-flex items-center gap-2 px-6 py-3 bg-pink-600 hover:bg-pink-700 text-white font-medium rounded-full transition-all shadow-lg shadow-pink-600/30 hover:-translate-y-1">
                        Eksplor Sekarang
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($wishlists as $wishlist)
                        @php
                            $item = $wishlist->wishlistable;
                            $isTrip = $wishlist->wishlistable_type === 'App\Models\Trip';
                            $link = $isTrip ? route('trip.detail', $item->id) : route('destination.show', $item->id);
                        @endphp
                        
                        <div class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 group flex flex-col h-full" id="wishlist-item-{{ $wishlist->id }}">
                            <!-- Image -->
                            <div class="relative h-56 overflow-hidden">
                                <img src="{{ $item->image }}" alt="{{ $isTrip ? $item->title : $item->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                                
                                <!-- Tags -->
                                <div class="absolute top-4 left-4">
                                    <span class="px-3 py-1 bg-white/20 backdrop-blur-md text-white text-xs font-bold rounded-full border border-white/30 shadow-sm">
                                        {{ $isTrip ? 'Trip Package' : 'Destinasi' }}
                                    </span>
                                </div>

                                <!-- Remove Button -->
                                <button onclick="removeWishlist({{ $wishlist->id }})" class="absolute top-4 right-4 w-10 h-10 bg-white/20 hover:bg-white/90 backdrop-blur-md rounded-full flex items-center justify-center text-white hover:text-red-500 border border-white/30 transition-all duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                                
                                @if($isTrip)
                                    <div class="absolute bottom-4 left-4 right-4 flex justify-between items-end">
                                        <span class="text-white font-semibold text-lg drop-shadow-md flex items-center gap-1.5">
                                            <span class="text-pink-400">Rp</span>{{ number_format($item->price, 0, ',', '.') }}
                                        </span>
                                        <span class="px-2.5 py-1 bg-black/40 backdrop-blur-sm text-white text-xs font-medium rounded-lg">
                                            {{ $item->duration_days }} Hari
                                        </span>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Content -->
                            <div class="p-6 flex flex-col flex-grow">
                                <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">{{ $isTrip ? $item->title : $item->name }}</h3>
                                <p class="text-gray-500 text-sm mb-4 line-clamp-2">{{ $item->description }}</p>
                                
                                <div class="mt-auto">
                                    <a href="{{ $link }}" class="w-full inline-flex justify-center items-center gap-2 px-4 py-2.5 bg-pink-50 hover:bg-pink-100 text-pink-600 font-semibold rounded-xl transition-colors">
                                        Lihat Detail
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </main>

    <!-- Footer -->
    <x-footer></x-footer>

    <script>
        async function removeWishlist(id) {
            if (!confirm('Apakah Anda yakin ingin menghapus item ini dari wishlist?')) return;
            
            try {
                const response = await fetch(`/api/wishlists/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });
                
                if (response.ok) {
                    const el = document.getElementById(`wishlist-item-${id}`);
                    el.style.opacity = '0';
                    el.style.transform = 'scale(0.9)';
                    setTimeout(() => {
                        el.remove();
                        // Reload if empty
                        if (document.querySelectorAll('[id^="wishlist-item-"]').length === 0) {
                            window.location.reload();
                        }
                    }, 300);
                } else {
                    alert('Gagal menghapus wishlist.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan sistem.');
            }
        }
    </script>
</body>
</html>