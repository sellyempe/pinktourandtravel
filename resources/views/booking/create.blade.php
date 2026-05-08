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
    <body class="font-poppins bg-gray-50/50 text-gray-900">
        <!-- Navbar Component -->
        <div>
            <x-navbar :always-scrolled="true"></x-navbar>

            <!-- Main Content -->
            <section class="pt-32 pb-24 px-4 min-h-screen">
                <div class="max-w-5xl mx-auto">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                        <!-- Booking Form -->
                        <div class="lg:col-span-2">
                            <div class="bg-white rounded-[2rem] p-8 md:p-10 border border-gray-100 shadow-sm relative overflow-hidden">
                                <div class="absolute top-0 right-0 w-64 h-64 bg-pink-100/30 rounded-full blur-3xl -mt-20 -mr-20 pointer-events-none"></div>
                                <h1 class="text-3xl font-extrabold text-gray-900 mb-2 relative z-10 tracking-tight">Pesan <span class="text-pink-600">Paket Wisata</span></h1>
                                <p class="text-gray-500 mb-10 relative z-10 text-lg">Lengkapi data di bawah untuk memproses pesanan Anda</p>

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
                                    <div class="bg-gradient-to-br from-pink-50 to-rose-50 border border-pink-100 rounded-[1.5rem] p-6 mb-8 relative overflow-hidden">
                                        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-pink-200/50 rounded-full blur-xl pointer-events-none"></div>
                                        <h3 class="text-lg font-extrabold text-gray-900 mb-4 flex items-center gap-2 relative z-10">
                                            <span class="w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-sm text-pink-500 text-sm">✨</span>
                                            Informasi Paket
                                        </h3>
                                        <div class="space-y-4 relative z-10">
                                            <div class="flex justify-between items-center border-b border-pink-100/50 pb-3">
                                                <span class="text-gray-600 font-medium">Paket Wisata</span>
                                                <span class="font-bold text-gray-900">{{ $trip->title }}</span>
                                            </div>
                                            <div class="flex justify-between items-center border-b border-pink-100/50 pb-3">
                                                <span class="text-gray-600 font-medium">Durasi</span>
                                                <span class="font-bold text-gray-900">{{ $trip->duration_days }} Hari</span>
                                            </div>
                                            <div class="flex justify-between items-center border-b border-pink-100/50 pb-3">
                                                <span class="text-gray-600 font-medium">Harga per Orang</span>
                                                <span class="font-bold text-pink-600 bg-white px-3 py-1 rounded-full text-sm shadow-sm">Rp {{ number_format($trip->price, 0, ',', '.') }}</span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <span class="text-gray-600 font-medium">Sisa Kuota (<span id="quota-date-label">Pilih Tanggal</span>)</span>
                                                <span class="font-bold text-gray-900 flex items-center gap-1">
                                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    <span id="available-seats-display">{{ $availableSeats }}</span> kursi
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Participants -->
                                    <div>
                                        <label for="participants" class="block text-sm font-bold text-gray-700 mb-3">Jumlah Peserta</label>
                                        <input 
                                            type="number" 
                                            id="participants" 
                                            name="participants" 
                                            min="1" 
                                            max="{{ $availableSeats }}" 
                                            value="{{ old('participants', 1) }}"
                                            class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:bg-white transition-all @error('participants') border-red-500 @enderror disabled:opacity-50"
                                            required
                                        >
                                        @error('participants')
                                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                        @enderror
                                        <p id="max-participants-text" class="text-gray-500 text-sm mt-2 font-medium">Pilih tanggal untuk melihat sisa kuota (Maksimal trip ini: {{ $availableSeats }})</p>
                                    </div>

                                    <!-- Preferred Date -->
                                    <div>
                                        <label for="preferred_date" class="block text-sm font-bold text-gray-700 mb-3">Tanggal Perjalanan yang Diinginkan</label>
                                        <input 
                                            type="date" 
                                            id="preferred_date" 
                                            name="preferred_date" 
                                            value="{{ old('preferred_date') }}"
                                            min="{{ date('Y-m-d') }}"
                                            class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:bg-white transition-all @error('preferred_date') border-red-500 @enderror"
                                            required
                                        >
                                        @error('preferred_date')
                                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                        @enderror
                                        <p class="text-gray-500 text-sm mt-2 font-medium">Pilih tanggal untuk mengecek ketersediaan kursi.</p>
                                    </div>

                                    <!-- Phone Number -->
                                    <div>
                                        <label for="phone" class="block text-sm font-bold text-gray-700 mb-3">Nomor Telepon Kontak</label>
                                        <input 
                                            type="tel" 
                                            id="phone" 
                                            name="phone" 
                                            placeholder="Contoh: 08123456789"
                                            value="{{ old('phone') }}"
                                            class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:bg-white transition-all @error('phone') border-red-500 @enderror"
                                            required
                                        >
                                        @error('phone')
                                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                        @enderror
                                        <p class="text-gray-500 text-sm mt-2 font-medium">Untuk konfirmasi dan komunikasi perjalanan</p>
                                    </div>

                                    <!-- Special Request -->
                                    <div>
                                        <label for="special_request" class="block text-sm font-bold text-gray-700 mb-3">Catatan atau Permintaan Khusus</label>
                                        <textarea 
                                            id="special_request" 
                                            name="special_request" 
                                            rows="4"
                                            placeholder="Contoh: Ada yang alergi makanan tertentu, atau permintaan lain"
                                            class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:bg-white transition-all resize-none @error('special_request') border-red-500 @enderror"
                                        >{{ old('special_request') }}</textarea>
                                        @error('special_request')
                                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                        @enderror
                                        <p class="text-gray-500 text-sm mt-2 font-medium">Opsional - Beri tahu kami jika ada kebutuhan khusus</p>
                                    </div>

                                    <!-- Total Price Display -->
                                    <div class="bg-gray-50 border border-gray-200 rounded-[1.5rem] p-6 mb-6">
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-600 font-bold">Subtotal Estimasi</span>
                                            <span id="subtotal" class="text-3xl font-extrabold text-pink-600">Rp {{ number_format($trip->price, 0, ',', '.') }}</span>
                                        </div>
                                    </div>

                                    <!-- Terms -->
                                    <div class="mb-6">
                                        <label class="flex items-start gap-3 cursor-pointer group">
                                            <div class="relative flex items-center justify-center mt-1">
                                                <input 
                                                    type="checkbox" 
                                                    name="terms" 
                                                    class="peer appearance-none w-5 h-5 border-2 border-gray-300 rounded bg-white checked:bg-pink-600 checked:border-pink-600 focus:outline-none focus:ring-2 focus:ring-pink-500 transition-all cursor-pointer"
                                                    required
                                                >
                                                <svg class="absolute w-3 h-3 text-white pointer-events-none opacity-0 peer-checked:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                            <span class="text-sm text-gray-600 group-hover:text-gray-900 transition-colors">
                                                Saya setuju dengan 
                                                <a href="#" class="text-pink-600 hover:text-pink-700 font-bold underline decoration-pink-300 underline-offset-4">syarat dan ketentuan</a>
                                                yang berlaku
                                            </span>
                                        </label>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex gap-4">
                                        <!-- Back Button -->
                                        <a 
                                            href="{{ route('trip.detail', $trip->id) }}" 
                                            class="w-1/3 flex items-center justify-center py-4 px-6 border-2 border-gray-200 rounded-2xl font-bold text-gray-600 hover:text-gray-900 hover:bg-gray-50 hover:border-gray-300 transition-all"
                                        >
                                            Batal
                                        </a>

                                        <!-- Submit Button -->
                                        <button 
                                            type="submit" 
                                            id="submit-btn"
                                            class="w-2/3 flex items-center justify-center py-4 px-6 bg-pink-600 text-white rounded-2xl font-bold hover:bg-pink-500 transition-all shadow-lg shadow-pink-600/30 hover:-translate-y-1 gap-2 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0"
                                        >
                                            Lanjut ke Pembayaran
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Trip Info Sidebar -->
                        <div class="lg:col-span-1">
                            <div class="bg-white rounded-[2rem] p-6 md:p-8 border border-gray-100 shadow-xl shadow-gray-100/50 sticky top-28">
                                <div class="relative rounded-[1.5rem] overflow-hidden mb-6 group">
                                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 to-transparent z-10"></div>
                                    <img src="{{ $trip->image }}" alt="{{ $trip->title }}" class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-700">
                                    <div class="absolute bottom-4 left-4 z-20">
                                        <span class="px-3 py-1 bg-pink-600/90 backdrop-blur-md text-white text-xs font-bold rounded-full shadow-sm">{{ $trip->duration_days }} Hari</span>
                                    </div>
                                </div>
                                
                                <h3 class="text-2xl font-extrabold text-gray-900 mb-4 tracking-tight">{{ $trip->title }}</h3>
                                
                                <div class="space-y-4">
                                    <div class="flex items-center gap-3 text-gray-600 bg-gray-50 p-3 rounded-xl border border-gray-100">
                                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm text-pink-500">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.242-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-0.5">Destinasi</p>
                                            <p class="font-bold text-gray-900">{{ $trip->destination }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center gap-3 text-gray-600 bg-gray-50 p-3 rounded-xl border border-gray-100">
                                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm text-pink-500">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-0.5">Keberangkatan</p>
                                            <p class="font-bold text-gray-900">{{ $trip->departure_city }}</p>
                                        </div>
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

        <!-- Script untuk calculate total & availability -->
        <script>
            const tripId = {{ $trip->id }};
            const pricePerPerson = {{ $trip->price }};
            const maxTripCapacity = {{ $availableSeats }};
            let currentMaxParticipants = maxTripCapacity;

            const participantsInput = document.getElementById('participants');
            const subtotalDisplay = document.getElementById('subtotal');
            const dateInput = document.getElementById('preferred_date');
            const seatsDisplay = document.getElementById('available-seats-display');
            const quotaDateLabel = document.getElementById('quota-date-label');
            const maxParticipantsText = document.getElementById('max-participants-text');
            const submitBtn = document.getElementById('submit-btn');

            // Format date for display
            function formatDate(dateString) {
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                return new Date(dateString).toLocaleDateString('id-ID', options);
            }

            // Hitung subtotal
            function calculateTotal() {
                let participants = parseInt(participantsInput.value) || 1;
                if (participants < 1) participants = 1;
                
                // Limit to current maximum
                if (participants > currentMaxParticipants) {
                    participants = currentMaxParticipants;
                    participantsInput.value = currentMaxParticipants;
                }
                
                const total = pricePerPerson * participants;
                subtotalDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID', { minimumFractionDigits: 0 });
            }

            participantsInput.addEventListener('input', calculateTotal);

            // Fetch ketersediaan kursi saat tanggal berubah
            dateInput.addEventListener('change', async function() {
                const selectedDate = this.value;
                if (!selectedDate) return;

                // Set loading state
                seatsDisplay.innerHTML = '<span class="animate-pulse">⏳ Mengecek...</span>';
                quotaDateLabel.textContent = formatDate(selectedDate);
                submitBtn.disabled = true;

                try {
                    const response = await fetch(`/booking/check-availability?trip_id=${tripId}&date=${selectedDate}`);
                    const data = await response.json();
                    
                    currentMaxParticipants = data.available_seats;
                    
                    // Update UI
                    seatsDisplay.textContent = currentMaxParticipants;
                    participantsInput.max = currentMaxParticipants;
                    maxParticipantsText.textContent = `Sisa kuota untuk tanggal ini: ${currentMaxParticipants} peserta`;

                    // Jika kuota habis
                    if (currentMaxParticipants === 0) {
                        seatsDisplay.classList.add('text-red-500');
                        seatsDisplay.classList.remove('text-gray-900');
                        maxParticipantsText.classList.add('text-red-500');
                        maxParticipantsText.classList.remove('text-gray-500');
                        participantsInput.disabled = true;
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = 'Kouta Penuh untuk Tanggal Ini';
                    } else {
                        seatsDisplay.classList.remove('text-red-500');
                        seatsDisplay.classList.add('text-gray-900');
                        maxParticipantsText.classList.remove('text-red-500');
                        maxParticipantsText.classList.add('text-gray-500');
                        participantsInput.disabled = false;
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = `
                            Lanjut ke Pembayaran
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        `;
                        
                        // Recalculate if current input exceeds new max
                        calculateTotal();
                    }
                } catch (error) {
                    console.error('Failed to check availability:', error);
                    seatsDisplay.textContent = 'Error';
                    submitBtn.disabled = false;
                }
            });

            // Jalankan cek kuota jika di awal udah ada value tanggal (misal kena validation error)
            if (dateInput.value) {
                dateInput.dispatchEvent(new Event('change'));
            }
        </script>
    </body>
</html>