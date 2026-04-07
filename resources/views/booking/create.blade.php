<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Booking {{ $trip->title }} - PinkTravel</title>
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
                        <!-- Booking Form -->
                        <div class="lg:col-span-2">
                            <div class="bg-white rounded-lg p-8 border border-gray-200">
                                <h1 class="text-3xl font-bold text-gray-900 mb-2">Pesan Paket Wisata</h1>
                                <p class="text-gray-600 mb-8">Isi form di bawah untuk melakukan pemesanan</p>

                                @if ($errors->any())
                                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                                        <p class="text-red-800 font-semibold mb-2">Terjadi kesalahan:</p>
                                        <ul class="list-disc list-inside text-red-700 space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                                        <p class="text-red-800">{{ session('error') }}</p>
                                    </div>
                                @endif

                                <form action="{{ route('booking.store') }}" method="POST" class="space-y-6">
                                    @csrf

                                    <input type="hidden" name="trip_id" value="{{ $trip->id }}">

                                    <!-- Trip Info -->
                                    <div class="bg-pink-50 border border-pink-200 rounded-lg p-6">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Paket</h3>
                                        <div class="space-y-3">
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Paket Wisata</span>
                                                <span class="font-semibold text-gray-900">{{ $trip->title }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Durasi</span>
                                                <span class="font-semibold text-gray-900">{{ $trip->duration_days }} Hari</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Harga per Orang</span>
                                                <span class="font-semibold text-gray-900">Rp {{ number_format($trip->price, 0, ',', '.') }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Tempat Tersedia</span>
                                                <span class="font-semibold text-pink-600">{{ $availableSeats }} kursi</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Participants -->
                                    <div>
                                        <label for="participants" class="block text-sm font-semibold text-gray-900 mb-3">Jumlah Peserta</label>
                                        <input 
                                            type="number" 
                                            id="participants" 
                                            name="participants" 
                                            min="1" 
                                            max="{{ $availableSeats }}" 
                                            value="{{ old('participants', 1) }}"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 @error('participants') border-red-500 @enderror"
                                            required
                                        >
                                        @error('participants')
                                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                        @enderror
                                        <p class="text-gray-500 text-sm mt-2">Maksimal {{ $availableSeats }} peserta</p>
                                    </div>

                                    <!-- Preferred Date -->
                                    <div>
                                        <label for="preferred_date" class="block text-sm font-semibold text-gray-900 mb-3">Tanggal Perjalanan yang Diinginkan</label>
                                        <input 
                                            type="date" 
                                            id="preferred_date" 
                                            name="preferred_date" 
                                            value="{{ old('preferred_date') }}"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 @error('preferred_date') border-red-500 @enderror"
                                        >
                                        @error('preferred_date')
                                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                        @enderror
                                        <p class="text-gray-500 text-sm mt-2">Minimal hari ini atau lebih</p>
                                    </div>

                                    <!-- Phone Number -->
                                    <div>
                                        <label for="phone" class="block text-sm font-semibold text-gray-900 mb-3">Nomor Telepon Kontak</label>
                                        <input 
                                            type="tel" 
                                            id="phone" 
                                            name="phone" 
                                            placeholder="Contoh: 08123456789"
                                            value="{{ old('phone') }}"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 @error('phone') border-red-500 @enderror"
                                            required
                                        >
                                        @error('phone')
                                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                        @enderror
                                        <p class="text-gray-500 text-sm mt-2">Untuk konfirmasi dan komunikasi perjalanan</p>
                                    </div>

                                    <!-- Special Request -->
                                    <div>
                                        <label for="special_request" class="block text-sm font-semibold text-gray-900 mb-3">Catatan atau Permintaan Khusus</label>
                                        <textarea 
                                            id="special_request" 
                                            name="special_request" 
                                            rows="4"
                                            placeholder="Contoh: Ada yang alergi makanan tertentu, atau permintaan lain"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 @error('special_request') border-red-500 @enderror"
                                        >{{ old('special_request') }}</textarea>
                                        @error('special_request')
                                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                        @enderror
                                        <p class="text-gray-500 text-sm mt-2">Opsional - Beri tahu kami jika ada kebutuhan khusus</p>
                                    </div>

                                    <!-- Total Price Display -->
                                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-600">Subtotal</span>
                                            <span id="subtotal" class="text-2xl font-bold text-pink-600">Rp {{ number_format($trip->price, 0, ',', '.') }}</span>
                                        </div>
                                    </div>

                                    <!-- Terms -->
                                    <div>
                                        <label class="flex items-start gap-3 cursor-pointer">
                                            <input 
                                                type="checkbox" 
                                                name="terms" 
                                                class="mt-1 rounded border-gray-300 text-pink-600 focus:ring-pink-500"
                                                required
                                            >
                                            <span class="text-sm text-gray-600">
                                                Saya setuju dengan 
                                                <a href="#" class="text-pink-600 hover:text-pink-700 font-semibold">syarat dan ketentuan</a>
                                                yang berlaku
                                            </span>
                                        </label>
                                    </div>

                                    <!-- Submit Button -->
                                    <button 
                                        type="submit" 
                                        class="w-full bg-pink-600 text-white py-3 rounded-lg font-semibold hover:bg-pink-700 transition"
                                    >
                                        Lanjut ke Pembayaran
                                    </button>

                                    <!-- Back Button -->
                                    <a 
                                        href="{{ route('trip.detail', $trip->id) }}" 
                                        class="w-full block text-center py-3 border border-gray-300 rounded-lg font-semibold text-gray-900 hover:bg-gray-50 transition"
                                    >
                                        Kembali ke Paket
                                    </a>
                                </form>
                            </div>
                        </div>

                        <!-- Trip Info Sidebar -->
                        <div class="lg:col-span-1">
                            <div class="bg-white rounded-lg p-6 border border-gray-200 sticky top-24">
                                <img src="{{ $trip->image }}" alt="{{ $trip->title }}" class="w-full h-48 object-cover rounded-lg mb-4">
                                
                                <h3 class="text-lg font-bold text-gray-900 mb-3">{{ $trip->title }}</h3>
                                
                                <div class="space-y-3 text-sm">
                                    <div class="flex items-center gap-2 text-gray-600">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $trip->destination }}
                                    </div>
                                    
                                    <div class="flex items-center gap-2 text-gray-600">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path>
                                        </svg>
                                        {{ $trip->duration_days }} Hari
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Footer -->
            <x-footer></x-footer>
        </div>

        <!-- Script untuk calculate total -->
        <script>
            const pricePerPerson = {{ $trip->price }};
            const maxParticipants = {{ $availableSeats }};
            const participantsInput = document.getElementById('participants');
            const subtotalDisplay = document.getElementById('subtotal');

            participantsInput.addEventListener('change', function() {
                let participants = parseInt(this.value) || 1;
                if (participants < 1) participants = 1;
                if (participants > maxParticipants) {
                    participants = maxParticipants;
                    this.value = maxParticipants;
                }
                
                const total = pricePerPerson * participants;
                subtotalDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID', { minimumFractionDigits: 0 });
            });
        </script>
    </body>
</html>
