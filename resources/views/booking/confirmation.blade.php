<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Konfirmasi Booking - PinkTravel</title>
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
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Booking Details -->
                        <div class="lg:col-span-2">
                            <div class="bg-white rounded-lg p-8 border border-gray-200 mb-8">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h1 class="text-2xl font-bold text-gray-900">Booking Berhasil Dibuat</h1>
                                        <p class="text-gray-600">Silakan selesaikan pembayaran untuk mengkonfirmasi booking Anda</p>
                                    </div>
                                </div>

                                <!-- Order Details -->
                                <div class="bg-gray-50 rounded-lg p-6 mb-8">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Pesanan</h3>
                                    
                                    <div class="space-y-4">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Nomor Pesanan</span>
                                            <span class="font-semibold text-gray-900">{{ $booking->order_id }}</span>
                                        </div>
                                        
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Nama Paket</span>
                                            <span class="font-semibold text-gray-900">{{ $booking->trip->title }}</span>
                                        </div>
                                        
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Durasi</span>
                                            <span class="font-semibold text-gray-900">{{ $booking->trip->duration_days }} Hari</span>
                                        </div>
                                        
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
                                        
                                        <div class="border-t border-gray-200 pt-4">
                                            <div class="flex justify-between items-center">
                                                <span class="text-lg font-semibold text-gray-900">Total Pembayaran</span>
                                                <span class="text-3xl font-bold text-pink-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Booking Info -->
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                                    <h4 class="font-semibold text-blue-900 mb-3">ℹ️ Informasi Penting</h4>
                                    <ul class="space-y-2 text-sm text-blue-900">
                                        <li>• Pembayaran harus diselesaikan dalam waktu 24 jam</li>
                                        <li>• Booking akan otomatis dibatalkan jika tidak ada pembayaran</li>
                                        <li>• Konfirmasi booking akan dikirim ke email Anda setelah pembayaran berhasil</li>
                                        <li>• Silakan hubungi customer service jika ada pertanyaan</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Guest Info -->
                            <div class="bg-white rounded-lg p-8 border border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Pemesan</h3>
                                
                                <div class="space-y-3">
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

                        <!-- Payment Section -->
                        <div class="lg:col-span-1">
                            <div class="bg-white rounded-lg p-6 border border-gray-200 sticky top-24">
                                <h3 class="text-lg font-bold text-gray-900 mb-6">Lanjutkan Pembayaran</h3>
                                
                                <div class="bg-pink-50 border border-pink-200 rounded-lg p-4 mb-6">
                                    <p class="text-gray-600 text-sm mb-2">Total Pembayaran</p>
                                    <p class="text-2xl font-bold text-pink-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                </div>

                                <button 
                                    id="pay-button"
                                    class="w-full bg-pink-600 text-white py-3 rounded-lg font-semibold hover:bg-pink-700 transition mb-3"
                                >
                                    Bayar Sekarang
                                </button>

                                <a 
                                    href="{{ route('booking.index') }}" 
                                    class="w-full block text-center py-3 border border-gray-300 rounded-lg font-semibold text-gray-900 hover:bg-gray-50 transition"
                                >
                                    Lihat Booking Saya
                                </a>

                                <div class="mt-6 p-4 bg-gray-50 rounded-lg text-sm text-gray-600">
                                    <p class="font-semibold text-gray-900 mb-2">Metode Pembayaran:</p>
                                    <p>✓ Kartu Kredit</p>
                                    <p>✓ Transfer Bank</p>
                                    <p>✓ E-Wallet</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Footer -->
            <x-footer></x-footer>
        </div>

        <!-- Midtrans Snap Script -->
        <script src="{{ $snapUrl }}" data-client-key="{{ $clientKey }}"></script>
        <script>
            document.getElementById('pay-button').addEventListener('click', function () {
                snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result) {
                        // Pembayaran berhasil - redirect ke halaman sukses atau booking details
                        window.location.href = "{{ route('booking.show', $booking->id) }}";
                    },
                    onPending: function(result) {
                        // Menunggu pembayaran
                        console.log('Pending', result);
                    },
                    onError: function(result) {
                        // Pembayaran gagal
                        alert('Pembayaran gagal. Silakan coba lagi.');
                        console.log('Error', result);
                    },
                    onClose: function() {
                        console.log('Customer menutup popup tanpa menyelesaikan pembayaran');
                    }
                });
            });
        </script>
    </body>
</html>
