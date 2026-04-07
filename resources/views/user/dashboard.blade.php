@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-4xl font-bold text-gray-900">My Dashboard</h1>
                <p class="text-gray-600 mt-2">Selamat datang kembali, {{ auth()->user()->name }}!</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-600">Member sejak</p>
                <p class="text-lg font-semibold text-gray-900">{{ auth()->user()->created_at->format('d M Y') }}</p>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="bg-white border-b border-gray-200 rounded-t-lg">
            <div class="flex space-x-8 px-6 overflow-x-auto">
                <button onclick="switchTab('dashboard')" class="tab-link active px-4 py-4 text-gray-900 font-medium border-b-2 border-pink-600 whitespace-nowrap">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Overview
                </button>
                <button onclick="switchTab('bookings')" class="tab-link px-4 py-4 text-gray-700 font-medium border-b-2 border-transparent hover:text-gray-900 whitespace-nowrap">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    My Bookings
                </button>
                <button onclick="switchTab('wishlist')" class="tab-link px-4 py-4 text-gray-700 font-medium border-b-2 border-transparent hover:text-gray-900 whitespace-nowrap">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    Wishlist
                </button>
                <button onclick="switchTab('profile')" class="tab-link px-4 py-4 text-gray-700 font-medium border-b-2 border-transparent hover:text-gray-900 whitespace-nowrap">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Profile
                </button>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="bg-white rounded-b-lg shadow">
            <!-- Dashboard Tab -->
            <div id="dashboard-tab" class="tab-content p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-gradient-to-br from-pink-50 to-pink-100 rounded-lg p-6">
                        <p class="text-pink-900 text-sm font-medium">Total Bookings</p>
                        <p class="text-4xl font-bold text-pink-600">{{ auth()->user()->bookings()->count() }}</p>
                        <p class="text-pink-700 text-xs mt-2">Riwayat pesanan perjalanan</p>
                    </div>
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6">
                        <p class="text-blue-900 text-sm font-medium">Confirmed Bookings</p>
                        <p class="text-4xl font-bold text-blue-600">{{ auth()->user()->bookings()->where('status', 'confirmed')->count() }}</p>
                        <p class="text-blue-700 text-xs mt-2">Pesanan yang sudah dikonfirmasi</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-6">
                        <p class="text-green-900 text-sm font-medium">Wishlist</p>
                        <p class="text-4xl font-bold text-green-600">{{ auth()->user()->wishlists()->count() }}</p>
                        <p class="text-green-700 text-xs mt-2">Destinasi impian</p>
                    </div>
                </div>

                <h3 class="text-xl font-bold text-gray-900 mb-4">Recent Activity</h3>
                <div class="space-y-4">
                    @forelse(auth()->user()->bookings()->latest()->take(5)->get() as $booking)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="flex items-center space-x-4 flex-1">
                                <div class="flex-shrink-0">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ 
                                        $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' :
                                        $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                        $booking->status === 'completed' ? 'bg-blue-100 text-blue-800' :
                                        'bg-red-100 text-red-800'
                                    }}">
                                        {{ strtoupper($booking->status) }}
                                    </span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900">{{ $booking->trip->title }}</p>
                                    <p class="text-xs text-gray-500">{{ $booking->participants }} peserta • {{ $booking->trip->duration_days }} hari</p>
                                </div>
                            </div>
                            <div class="text-right ml-4">
                                <p class="font-semibold text-gray-900">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                <a href="{{ route('booking.show', $booking->id) }}" class="text-pink-600 hover:text-pink-900 text-xs font-medium">Detail →</a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-gray-50 rounded-lg">
                            <p class="text-gray-500">Belum ada pemesanan</p>
                            <a href="/" class="text-pink-600 hover:text-pink-900 font-medium">Jelajahi trips →</a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Bookings Tab -->
            <div id="bookings-tab" class="tab-content hidden p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">My Bookings</h3>
                <div class="space-y-4">
                    @forelse(auth()->user()->bookings()->with('trip')->latest()->get() as $booking)
                        <div class="flex items-start justify-between p-5 border border-gray-200 rounded-lg hover:shadow-md transition">
                            <div class="flex-1">
                                <div class="flex items-center space-x-4">
                                    <img src="{{ $booking->trip->image }}" alt="{{ $booking->trip->title }}" class="w-20 h-20 rounded-lg object-cover flex-shrink-0">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-gray-900">{{ $booking->trip->title }}</h4>
                                        <p class="text-sm text-gray-600">{{ $booking->trip->duration_days }} Hari • {{ $booking->participants }} Peserta</p>
                                        <p class="text-xs text-gray-500 mt-1">Order: {{ $booking->order_id }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right ml-4 flex-shrink-0">
                                <div class="mb-2">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ 
                                        $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' :
                                        $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                        $booking->status === 'completed' ? 'bg-blue-100 text-blue-800' :
                                        'bg-red-100 text-red-800'
                                    }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </div>
                                <p class="font-bold text-gray-900">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                <a href="{{ route('booking.show', $booking->id) }}" class="text-pink-600 hover:text-pink-900 text-sm font-medium">Detail →</a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-gray-50 rounded-lg">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-gray-500 mb-2">Belum ada pemesanan</p>
                            <a href="/" class="text-pink-600 hover:text-pink-900 font-medium">Cari paket wisata →</a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Wishlist Tab -->
            <div id="wishlist-tab" class="tab-content hidden p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">My Wishlist</h3>
                <div class="space-y-4">
                    @forelse(auth()->user()->wishlists()->with('trip')->latest()->get() as $wishlist)
                        <div class="flex items-start justify-between p-5 border border-gray-200 rounded-lg hover:shadow-md transition">
                            <div class="flex-1">
                                <div class="flex items-center space-x-4">
                                    <img src="{{ $wishlist->trip->image }}" alt="{{ $wishlist->trip->title }}" class="w-20 h-20 rounded-lg object-cover flex-shrink-0">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-gray-900">{{ $wishlist->trip->title }}</h4>
                                        <p class="text-sm text-gray-600">{{ $wishlist->trip->duration_days }} Hari</p>
                                        <p class="text-sm font-semibold text-pink-600">Rp {{ number_format($wishlist->trip->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="ml-4 flex-shrink-0 space-y-2">
                                <a href="{{ route('trip.detail', $wishlist->trip->id) }}" class="block text-pink-600 hover:text-pink-900 text-sm font-medium px-3 py-1 border border-pink-600 rounded-lg text-center">Lihat</a>
                                <form action="/wishlist/{{ $wishlist->id }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="block w-full text-red-600 hover:text-red-900 text-sm font-medium px-3 py-1 border border-red-600 rounded-lg text-center">Hapus</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-gray-50 rounded-lg">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            <p class="text-gray-500 mb-2">Wishlist kosong</p>
                            <a href="/" class="text-pink-600 hover:text-pink-900 font-medium">Jelajahi destinasi →</a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Profile Tab -->
            <div id="profile-tab" class="tab-content hidden p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6">My Profile & Settings</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Profile Info -->
                    <div>
                        <h4 class="font-semibold text-lg text-gray-900 mb-4">Account Information</h4>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" value="{{ auth()->user()->name }}" disabled class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-900">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" value="{{ auth()->user()->email }}" disabled class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-900">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Member Since</label>
                                <input type="text" value="{{ auth()->user()->created_at->format('d M Y') }}" disabled class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-900">
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div>
                        <h4 class="font-semibold text-lg text-gray-900 mb-4">Actions</h4>
                        <div class="space-y-3">
                            <button class="w-full px-4 py-3 bg-pink-600 text-white rounded-lg hover:bg-pink-700 font-medium transition flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.192 5.965A5.992 5.992 0 0110 16a5.992 5.992 0 00-1.808-4.035A6 6 0 1121 9z"></path>
                                </svg>
                                <span>Change Password</span>
                            </button>
                            <button class="w-full px-4 py-3 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 font-medium transition flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <span>Privacy Settings</span>
                            </button>
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button type="submit" class="w-full px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium transition flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function switchTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden');
    });
    document.querySelectorAll('.tab-link').forEach(link => {
        link.classList.remove('border-pink-600', 'text-gray-900');
        link.classList.add('border-transparent', 'text-gray-700');
    });

    // Show selected tab
    document.getElementById(tabName + '-tab').classList.remove('hidden');
    event.target.classList.add('border-pink-600', 'text-gray-900');
    event.target.classList.remove('border-transparent', 'text-gray-700');
}
</script>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
                    <h3 class="font-bold text-lg mb-2">👤 My Profile</h3>
                    <p class="text-gray-600 mb-4">{{ auth()->user()->email }}</p>
                    <a href="#" class="text-blue-600 hover:text-blue-800 font-semibold">Edit Profile →</a>
                </div>
                <div class="bg-green-50 p-6 rounded-lg border border-green-200">
                    <h3 class="font-bold text-lg mb-2">📅 My Bookings</h3>
                    <p class="text-gray-600 mb-4">View your travel bookings</p>
                    <a href="#bookings" class="text-green-600 hover:text-green-800 font-semibold">View Bookings →</a>
                </div>
                <div class="bg-purple-50 p-6 rounded-lg border border-purple-200">
                    <h3 class="font-bold text-lg mb-2">❤️ My Wishlist</h3>
                    <p id="wishlist-count" class="text-gray-600 mb-4">Loading...</p>
                    <a href="#wishlist" class="text-purple-600 hover:text-purple-800 font-semibold">View Wishlist →</a>
                </div>
            </div>

            <!-- Wishlist Section -->
            <div id="wishlist" class="bg-gray-50 rounded-lg p-8 border border-gray-200">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">❤️ Wishlist Saya</h3>
                <div id="wishlist-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <p class="col-span-full text-gray-500 text-center py-8">Memuat wishlist...</p>
                </div>
            </div>

            <!-- Bookings Section -->
            <div id="bookings" class="bg-gray-50 rounded-lg p-8 border border-gray-200 mt-12">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">📅 Bookings Saya</h3>
                <p class="text-gray-600">Fitur bookings akan segera hadir</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadWishlists();
        });

        async function loadWishlists() {
            try {
                const response = await fetch('/api/wishlists');
                const wishlists = await response.json();

                const container = document.getElementById('wishlist-container');
                const count = document.getElementById('wishlist-count');

                count.textContent = `${wishlists.length} item dalam wishlist`;

                if (wishlists.length === 0) {
                    container.innerHTML = '<p class="col-span-full text-gray-500 text-center py-8">Belum ada item di wishlist</p>';
                    return;
                }

                container.innerHTML = wishlists.map(item => {
                    const wishlistable = item.wishlistable;
                    const isTrip = item.wishlistable_type === 'App\\Models\\Trip';
                    const link = isTrip ? `/trip/${wishlistable.id}` : `/destination/${wishlistable.id}`;
                    const image = isTrip ? wishlistable.image : wishlistable.image;
                    const title = isTrip ? wishlistable.title : wishlistable.name;
                    const subtitle = isTrip ? `${wishlistable.destination} - Rp ${parseInt(wishlistable.price).toLocaleString('id-ID')}` : wishlistable.location;

                    return `
                        <div class="bg-white rounded-lg overflow-hidden border border-gray-200 hover:shadow-lg transition">
                            <img src="${image}" alt="${title}" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h4 class="font-semibold text-gray-900 mb-1">${title}</h4>
                                <p class="text-sm text-gray-600 mb-4">${subtitle}</p>
                                <div class="flex gap-2">
                                    <a href="${link}" class="flex-1 px-3 py-2 bg-teal-600 text-white rounded text-sm font-semibold text-center hover:bg-teal-700 transition">
                                        Lihat Detail
                                    </a>
                                    <button onclick="removeFromWishlist(${item.id}, '${item.wishlistable_type}', ${item.wishlistable_id})" class="px-3 py-2 bg-red-100 text-red-600 rounded text-sm font-semibold hover:bg-red-200 transition">
                                        ❌
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                }).join('');
            } catch (error) {
                console.error('Error loading wishlists:', error);
                document.getElementById('wishlist-container').innerHTML = '<p class="col-span-full text-red-500 text-center py-8">Error memuat wishlist</p>';
            }
        }

        async function removeFromWishlist(id, type, itemId) {
            if (!confirm('Hapus dari wishlist?')) return;

            try {
                const response = await fetch(`/api/wishlists/${id}`, {
                    method: 'DELETE',
                });

                if (response.ok) {
                    loadWishlists();
                } else {
                    alert('Gagal menghapus dari wishlist');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Gagal menghapus dari wishlist');
            }
        }
    </script>
