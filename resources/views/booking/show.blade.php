<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Detail Booking - PinkTravel</title>
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

            <!-- Main Content -->
            <section class="py-20 px-4 bg-gray-50 min-h-screen">
                <div class="max-w-4xl mx-auto">
                    <!-- Back Button -->
                    <a href="{{ route('booking.index') }}" class="text-pink-600 hover:text-pink-700 font-semibold mb-6 inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Kembali ke Booking Saya
                    </a>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Main Content -->
                        <div class="lg:col-span-2 space-y-6">
                            <!-- Status Card -->
                            <div class="bg-white rounded-lg p-8 border border-gray-200">
                                <div class="flex items-center justify-between mb-6">
                                    <h1 class="text-3xl font-bold text-gray-900">Detail Booking</h1>
                                    
                                    @if ($booking->status === 'pending')
                                        <span class="px-4 py-2 bg-yellow-100 text-yellow-800 font-semibold rounded-full">Menunggu Pembayaran</span>
                                    @elseif ($booking->status === 'confirmed')
                                        <span class="px-4 py-2 bg-green-100 text-green-800 font-semibold rounded-full">Dikonfirmasi</span>
                                    @elseif ($booking->status === 'completed')
                                        <span class="px-4 py-2 bg-blue-100 text-blue-800 font-semibold rounded-full">Selesai</span>
                                    @elseif ($booking->status === 'cancelled')
                                        <span class="px-4 py-2 bg-red-100 text-red-800 font-semibold rounded-full">Dibatalkan</span>
                                    @endif
                                </div>

                                <div class="space-y-4">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Nomor Pesanan</span>
                                        <span class="font-semibold text-gray-900">{{ $booking->order_id }}</span>
                                    </div>
                                    
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Tanggal Booking</span>
                                        <span class="font-semibold text-gray-900">{{ $booking->created_at->format('d F Y H:i') }}</span>
                                    </div>

                                    @if ($booking->confirmed_at)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Tanggal Konfirmasi</span>
                                            <span class="font-semibold text-gray-900">{{ $booking->confirmed_at->format('d F Y H:i') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Trip Details -->
                            <div class="bg-white rounded-lg p-8 border border-gray-200">
                                <h2 class="text-2xl font-bold text-gray-900 mb-6">Paket Wisata</h2>
                                
                                <div class="mb-6">
                                    <img src="{{ $booking->trip->image }}" alt="{{ $booking->trip->title }}" class="w-full h-48 object-cover rounded-lg">
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <p class="text-gray-600 text-sm">Nama Paket</p>
                                        <p class="text-lg font-semibold text-gray-900">{{ $booking->trip->title }}</p>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-gray-600 text-sm">Durasi</p>
                                            <p class="font-semibold text-gray-900">{{ $booking->trip->duration_days }} Hari</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600 text-sm">Destinasi</p>
                                            <p class="font-semibold text-gray-900">{{ $booking->trip->destination }}</p>
                                        </div>
                                    </div>

                                    <div>
                                        <p class="text-gray-600 text-sm">Kota Keberangkatan</p>
                                        <p class="font-semibold text-gray-900">{{ $booking->trip->departure_city }}</p>
                                    </div>

                                    <div>
                                        <p class="text-gray-600 text-sm">Titik Pemberangkatan</p>
                                        <p class="font-semibold text-gray-900">{{ $booking->trip->meeting_point }}</p>
                                        <p class="text-gray-600 text-sm">{{ $booking->trip->meeting_address }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Booking Details -->
                            <div class="bg-white rounded-lg p-8 border border-gray-200">
                                <h2 class="text-2xl font-bold text-gray-900 mb-6">Detail Pesanan</h2>
                                
                                <div class="space-y-4">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Jumlah Peserta</span>
                                        <span class="font-semibold text-gray-900">{{ $booking->participants }} orang</span>
                                    </div>
                                    
                                    @if ($booking->preferred_date)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Tanggal Perjalanan</span>
                                        <span class="font-semibold text-gray-900">{{ $booking->preferred_date->format('d F Y') }}</span>
                                    </div>
                                    @endif
                                    
                                    @if ($booking->phone)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Nomor Telepon</span>
                                        <span class="font-semibold text-gray-900">{{ $booking->phone }}</span>
                                    </div>
                                    @endif
                                    
                                    @if ($booking->special_request)
                                    <div>
                                        <span class="text-gray-600">Catatan Khusus</span>
                                        <p class="font-semibold text-gray-900 mt-1">{{ $booking->special_request }}</p>
                                    </div>
                                    @endif
                                    
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Harga per Orang</span>
                                        <span class="font-semibold text-gray-900">Rp {{ number_format($booking->trip->price, 0, ',', '.') }}</span>
                                    </div>

                                    <div class="border-t border-gray-200 pt-4">
                                        <div class="flex justify-between items-center">
                                            <span class="text-lg font-semibold text-gray-900">Total Pembayaran</span>
                                            <span class="text-3xl font-bold text-pink-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Guest Info -->
                            <div class="bg-white rounded-lg p-8 border border-gray-200">
                                <h2 class="text-2xl font-bold text-gray-900 mb-6">Data Pemesan</h2>
                                
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-gray-600 text-sm">Nama</p>
                                        <p class="font-semibold text-gray-900">{{ $booking->user->name }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-gray-600 text-sm">Email</p>
                                        <p class="font-semibold text-gray-900">{{ $booking->user->email }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="lg:col-span-1">
                            <!-- Payment Status -->
                            <div class="bg-white rounded-lg p-6 border border-gray-200 sticky top-24 space-y-4">
                                <h3 class="text-lg font-bold text-gray-900">Status Pembayaran</h3>
                                
                                @if ($booking->status === 'pending')
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                        <p class="text-yellow-800 font-semibold mb-3">Pembayaran Belum Dilakukan</p>
                                        <p class="text-yellow-700 text-sm mb-4">Silakan selesaikan pembayaran untuk mengkonfirmasi booking Anda.</p>
                                        <a 
                                            href="{{ route('booking.confirmation', $booking->id) }}"
                                            class="w-full block text-center bg-yellow-600 text-white py-2 rounded-lg font-semibold hover:bg-yellow-700 transition"
                                        >
                                            Selesaikan Pembayaran
                                        </a>
                                    </div>
                                @elseif ($booking->status === 'confirmed')
                                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                        <p class="text-green-800 font-semibold mb-2">✓ Pembayaran Berhasil</p>
                                        <p class="text-green-700 text-sm">Booking Anda telah dikonfirmasi. Cek email Anda untuk detail lebih lanjut.</p>
                                    </div>
                                @elseif ($booking->status === 'completed')
                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                        <p class="text-blue-800 font-semibold mb-2">✓ Perjalanan Selesai</p>
                                        <p class="text-blue-700 text-sm">Terima kasih telah memilih PinkTravel. Kami harap Anda menikmati perjalanan ini!</p>
                                    </div>
                                @elseif ($booking->status === 'cancelled')
                                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                        <p class="text-red-800 font-semibold mb-2">✗ Booking Dibatalkan</p>
                                        <p class="text-red-700 text-sm">Booking ini telah dibatalkan. Hubungi customer service untuk informasi lebih lanjut.</p>
                                    </div>
                                @endif

                                @if ($booking->paymentTransaction)
                                    <div class="border-t border-gray-200 pt-4 mt-4">
                                        <p class="text-sm text-gray-600 mb-2">Transaksi Pembayaran</p>
                                        <p class="text-xs text-gray-600">Reference: {{ $booking->paymentTransaction->reference_id }}</p>
                                        <p class="text-xs text-gray-600">Status: <span class="font-semibold capitalize">{{ $booking->paymentTransaction->status }}</span></p>
                                    </div>
                                @endif

                                @if ($booking->status === 'pending' || $booking->status === 'confirmed')
                                    <button 
                                        onclick="if(confirm('Apakah Anda yakin ingin membatalkan booking ini?')) { document.getElementById('cancel-form').submit(); }"
                                        class="w-full border border-red-300 text-red-600 py-2 rounded-lg font-semibold hover:bg-red-50 transition text-sm"
                                    >
                                        Batalkan Booking
                                    </button>
                                    <form id="cancel-form" action="{{ route('booking.cancel', $booking->id) }}" method="POST" class="hidden">
                                        @csrf
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Footer -->
            <x-footer></x-footer>
        </div>
    </body>
</html>
