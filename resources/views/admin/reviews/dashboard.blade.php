@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-4xl font-bold text-gray-900">Review Management</h1>
                <p class="text-gray-600 mt-2">Moderate and manage user reviews</p>
            </div>
            <div class="text-right">
                <div class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded-lg">
                    <p class="text-sm">Pending Reviews</p>
                    <p class="text-2xl font-bold">{{ \App\Models\Review::where('status', 'pending')->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="bg-white border-b border-gray-200 rounded-t-lg mb-6">
            <div class="flex space-x-1 px-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex-shrink-0">
                    <a href="/" class="text-2xl font-bold text-gray-900">
                        ✈️ PinkTravel Admin
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="pt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900">💬 Kelola Review & Testimonial</h1>
                    <p class="text-gray-600 mt-2">Approve atau tolak review dari traveler</p>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('admin.dashboard') }}" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition font-semibold">
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Tabs -->
            <div class="flex gap-4 mb-8 border-b">
                <button onclick="switchTab('pending')" id="tab-pending" class="px-4 py-2 border-b-2 border-teal-600 text-teal-600 font-semibold">
                    ⏳ Menunggu Persetujuan
                </button>
                <button onclick="switchTab('approved')" id="tab-approved" class="px-4 py-2 text-gray-600 hover:text-teal-600 font-semibold">
                    ✅ Disetujui
                </button>
                <button onclick="switchTab('rejected')" id="tab-rejected" class="px-4 py-2 text-gray-600 hover:text-teal-600 font-semibold">
                    ❌ Ditolak
                </button>
            </div>

            <!-- Reviews List -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div id="reviews-list" class="divide-y">
                    <p class="text-gray-500 text-center py-8">Memuat reviews...</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        let allReviews = {
            pending: [],
            approved: [],
            rejected: [],
        };
        let currentTab = 'pending';

        document.addEventListener('DOMContentLoaded', function() {
            loadReviews();
        });

        function switchTab(tab) {
            currentTab = tab;
            
            // Update button styles
            document.querySelectorAll('[id^="tab-"]').forEach(btn => btn.classList.remove('border-b-2', 'border-teal-600', 'text-teal-600'));
            document.getElementById(`tab-${tab}`).classList.add('border-b-2', 'border-teal-600', 'text-teal-600');
            
            renderReviews();
        }

        async function loadReviews() {
            try {
                const response = await fetch('/api/reviews');
                const reviews = await response.json();

                // Group by status
                allReviews = {
                    pending: reviews.filter(r => r.status === 'pending'),
                    approved: reviews.filter(r => r.status === 'approved'),
                    rejected: reviews.filter(r => r.status === 'rejected'),
                };

                renderReviews();
            } catch (error) {
                console.error('Error loading reviews:', error);
            }
        }

        function renderReviews() {
            const reviews = allReviews[currentTab];
            const container = document.getElementById('reviews-list');

            if (reviews.length === 0) {
                container.innerHTML = '<p class="text-gray-500 text-center py-8">Tidak ada review</p>';
                return;
            }

            container.innerHTML = reviews.map(review => `
                <div class="p-6 hover:bg-gray-50 transition">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="font-semibold text-gray-900">${review.user.name}</p>
                            <p class="text-sm text-gray-500">${new Date(review.created_at).toLocaleDateString('id-ID')}</p>
                            <p class="text-sm text-gray-600 mt-1">
                                ${review.reviewable_type.includes('Trip') ? '✈️ Trip' : '📍 Destination'}: 
                                ${review.reviewable_type.includes('Trip') ? review.reviewable?.title : review.reviewable?.name}
                            </p>
                        </div>
                        <div class="text-2xl">${'⭐'.repeat(review.rating)}</div>
                    </div>
                    
                    <p class="text-gray-700 mb-4">"${review.comment || 'Tidak ada komentar'}"</p>

                    ${currentTab === 'pending' ? `
                        <div class="flex gap-3">
                            <button onclick="updateReviewStatus(${review.id}, 'approved')" class="px-4 py-2 bg-green-600 text-white rounded font-semibold hover:bg-green-700 transition">
                                ✅ Setujui
                            </button>
                            <button onclick="updateReviewStatus(${review.id}, 'rejected')" class="px-4 py-2 bg-red-600 text-white rounded font-semibold hover:bg-red-700 transition">
                                ❌ Tolak
                            </button>
                        </div>
                    ` : ''}
                </div>
            `).join('');
        }

        async function updateReviewStatus(reviewId, status) {
            try {
                const response = await fetch(`/api/reviews/${reviewId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                    },
                    body: JSON.stringify({
                        status: status,
                    }),
                });

                if (response.ok) {
                    alert(`Review ${status === 'approved' ? 'disetujui' : 'ditolak'}!`);
                    loadReviews();
                } else {
                    alert('Gagal update review');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Gagal update review');
            }
        }
    </script>
</body>
</html>
