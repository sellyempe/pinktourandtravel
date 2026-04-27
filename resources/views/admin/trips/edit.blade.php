<x-admin-layout title="Edit Trip" active="trips">

    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-white transition">Dashboard</a>
        <span>/</span>
        <span class="text-gray-300">Edit: {{ Str::limit($trip->title, 40) }}</span>
    </nav>

    {{-- Leaflet CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>


    <form method="POST" action="{{ route('admin.trips.update', $trip->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            {{-- ── Kiri ─────────────────────────────────────────────── --}}
            <div class="xl:col-span-2 space-y-5">

                <div class="bg-gray-900 border border-white/5 rounded-2xl p-6">
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-5">Informasi Trip</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Judul Trip <span class="text-pink-500">*</span></label>
                            <input type="text" name="title" value="{{ old('title', $trip->title) }}"
                                   class="w-full px-4 py-3 bg-gray-800 border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition" required>
                            @error('title')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1.5">Kota Keberangkatan <span class="text-pink-500">*</span></label>
                                <input type="text" name="departure_city" value="{{ old('departure_city', $trip->departure_city) }}"
                                       class="w-full px-4 py-3 bg-gray-800 border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1.5">Destinasi <span class="text-pink-500">*</span></label>
                                <input type="text" name="destination" value="{{ old('destination', $trip->destination) }}"
                                       class="w-full px-4 py-3 bg-gray-800 border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Deskripsi <span class="text-pink-500">*</span></label>
                            <textarea name="description" rows="3"
                                      class="w-full px-4 py-3 bg-gray-800 border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition resize-none" required>{{ old('description', $trip->description) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Overview <span class="text-pink-500">*</span></label>
                            <textarea name="overview" rows="4"
                                      class="w-full px-4 py-3 bg-gray-800 border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition resize-none" required>{{ old('overview', $trip->overview) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-900 border border-white/5 rounded-2xl p-6">
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Titik Kumpul</h3>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Nama Titik Kumpul</label>
                            <input type="text" name="meeting_point" value="{{ old('meeting_point', $trip->meeting_point) }}"
                                   class="w-full px-4 py-3 bg-gray-800 border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Alamat Lengkap</label>
                            <input type="text" name="meeting_address" value="{{ old('meeting_address', $trip->meeting_address) }}"
                                   class="w-full px-4 py-3 bg-gray-800 border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1.5">Pin Lokasi Peta <span class="text-xs text-gray-500 font-normal">(Cari nama tempat atau geser pin merah)</span></label>
                        
                        <!-- Pencarian Peta -->
                        <div class="flex gap-2 mb-3">
                            <input type="text" id="map-search-input" placeholder="Ketik nama tempat/kota untuk mencari..." class="flex-1 px-4 py-2.5 bg-gray-800 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition" autocomplete="off">
                            <button type="button" id="map-search-btn" class="px-5 py-2.5 bg-gray-800 hover:bg-gray-700 border border-white/10 text-white text-sm font-medium rounded-xl transition flex items-center gap-2 whitespace-nowrap">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                Cari Lokasi
                            </button>
                        </div>

                        <div id="map" class="w-full h-72 rounded-xl border border-white/10 mb-3 relative z-0 shadow-inner"></div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Latitude</label>
                                <input type="text" id="latitude" name="latitude" value="{{ old('latitude', $trip->latitude) }}" readonly
                                       class="w-full px-3 py-2 bg-gray-800/50 border border-white/5 rounded-lg text-gray-400 text-sm focus:outline-none cursor-not-allowed font-mono">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Longitude</label>
                                <input type="text" id="longitude" name="longitude" value="{{ old('longitude', $trip->longitude) }}" readonly
                                       class="w-full px-3 py-2 bg-gray-800/50 border border-white/5 rounded-lg text-gray-400 text-sm focus:outline-none cursor-not-allowed font-mono">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ── Kanan ────────────────────────────────────────────── --}}
            <div class="space-y-5">

                {{-- Gambar --}}
                <div class="bg-gray-900 border border-white/5 rounded-2xl p-6">
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Foto Trip</h3>
                    <div class="relative rounded-xl overflow-hidden bg-gray-800 cursor-pointer group"
                         onclick="document.getElementById('imageInput').click()">
                        @if($trip->image)
                            <img id="imagePreview" src="{{ $trip->image }}" alt="{{ $trip->title }}"
                                 class="w-full h-44 object-cover">
                        @else
                            <div id="imagePreview" class="w-full h-44 flex items-center justify-center bg-gray-800">
                                <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition">
                            <p class="text-white text-sm font-medium">🖼 Ganti Foto</p>
                        </div>
                    </div>
                    <input type="file" id="imageInput" name="image" accept="image/*" class="hidden"
                           onchange="previewImage(this)">
                    <p class="text-xs text-gray-600 mt-2 text-center">Biarkan kosong untuk mempertahankan foto lama</p>
                    @error('image')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Harga & Kapasitas --}}
                <div class="bg-gray-900 border border-white/5 rounded-2xl p-6">
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Harga & Kapasitas</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Harga per Orang (Rp) <span class="text-pink-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm">Rp</span>
                                <input type="number" name="price" value="{{ old('price', $trip->price) }}" min="0"
                                       class="w-full pl-10 pr-4 py-3 bg-gray-800 border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Durasi (Hari) <span class="text-pink-500">*</span></label>
                            <input type="number" name="duration_days" value="{{ old('duration_days', $trip->duration_days) }}" min="1"
                                   class="w-full px-4 py-3 bg-gray-800 border border-white/10 rounded-xl text-white focus:outline-none focus:border-pink-500 transition" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Kuota <span class="text-pink-500">*</span></label>
                            <input type="number" name="kuota" value="{{ old('kuota', $trip->kuota) }}" min="1"
                                   placeholder="e.g. 20"
                                   class="w-full px-4 py-3 bg-gray-800 border border-white/10 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:border-pink-500 transition" required>
                        </div>
                    </div>
                </div>

                {{-- Status --}}
                <div class="bg-gray-900 border border-white/5 rounded-2xl p-6">
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Publikasi</h3>
                    <div class="space-y-2">
                        <label class="flex items-center gap-3 p-3 rounded-xl border border-white/10 cursor-pointer has-[:checked]:border-emerald-500/50 has-[:checked]:bg-emerald-500/5 transition">
                            <input type="radio" name="status" value="active" {{ old('status', $trip->status) === 'active' ? 'checked' : '' }} class="accent-emerald-500">
                            <div>
                                <p class="text-sm font-medium text-white">Aktif</p>
                                <p class="text-xs text-gray-500">Tampil di website</p>
                            </div>
                        </label>
                        <label class="flex items-center gap-3 p-3 rounded-xl border border-white/10 cursor-pointer has-[:checked]:border-gray-500/50 has-[:checked]:bg-gray-500/5 transition">
                            <input type="radio" name="status" value="inactive" {{ old('status', $trip->status) === 'inactive' ? 'checked' : '' }} class="accent-gray-500">
                            <div>
                                <p class="text-sm font-medium text-white">Nonaktif</p>
                                <p class="text-xs text-gray-500">Disembunyikan</p>
                            </div>
                        </label>
                    </div>
                </div>

                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-6 py-3.5 bg-pink-600 hover:bg-pink-500 text-white font-semibold rounded-xl transition shadow-lg shadow-pink-600/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.dashboard') }}"
                   class="block w-full text-center px-6 py-3 bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white font-medium rounded-xl transition">
                    Batal
                </a>
            </div>
        </div>
    </form>

    <script>
    function previewImage(input) {
        if (!input.files[0]) return;
        const reader = new FileReader();
        reader.onload = e => {
            const preview = document.getElementById('imagePreview');
            if (preview.tagName === 'IMG') {
                preview.src = e.target.result;
            } else {
                preview.outerHTML = `<img id="imagePreview" src="${e.target.result}" alt="Preview" class="w-full h-44 object-cover">`;
            }
        };
        reader.readAsDataURL(input.files[0]);
    }

    // --- Peta Interaktif Leaflet ---
    document.addEventListener('DOMContentLoaded', function() {
        // Default center point: Jakarta (Monas)
        const defaultLat = -6.1753924;
        const defaultLng = 106.8271528;
        
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');

        // Initialize map
        const map = L.map('map').setView([
            latInput.value ? latInput.value : defaultLat, 
            lngInput.value ? lngInput.value : defaultLng
        ], 13);

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // Create draggable marker
        const marker = L.marker([
            latInput.value ? latInput.value : defaultLat, 
            lngInput.value ? lngInput.value : defaultLng
        ], { draggable: true }).addTo(map);

        // Update inputs when marker is dragged
        marker.on('dragend', function(event) {
            const position = marker.getLatLng();
            latInput.value = position.lat.toFixed(8);
            lngInput.value = position.lng.toFixed(8);
        });

        // Update marker when map is clicked
        map.on('click', function(event) {
            marker.setLatLng(event.latlng);
            latInput.value = event.latlng.lat.toFixed(8);
            lngInput.value = event.latlng.lng.toFixed(8);
        });

        // Search Location Logic
        const searchBtn = document.getElementById('map-search-btn');
        const searchInput = document.getElementById('map-search-input');

        async function searchLocation() {
            const query = searchInput.value.trim();
            if (!query) return;

            const btnOriginalHTML = searchBtn.innerHTML;
            searchBtn.innerHTML = '<span class="animate-pulse">Mencari...</span>';
            searchBtn.disabled = true;

            try {
                // Gunakan Nominatim API dari OpenStreetMap
                const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`);
                const data = await response.json();

                if (data && data.length > 0) {
                    const lat = parseFloat(data[0].lat);
                    const lon = parseFloat(data[0].lon);
                    
                    // Fly to location with animation
                    map.flyTo([lat, lon], 16, { duration: 1.5 });
                    marker.setLatLng([lat, lon]);
                    
                    latInput.value = lat.toFixed(8);
                    lngInput.value = lon.toFixed(8);
                } else {
                    alert('Lokasi tidak ditemukan. Coba gunakan nama kota atau jalan yang lebih spesifik.');
                }
            } catch (error) {
                console.error('Error searching location:', error);
                alert('Terjadi kesalahan saat mencari lokasi.');
            } finally {
                searchBtn.innerHTML = btnOriginalHTML;
                searchBtn.disabled = false;
            }
        }

        searchBtn.addEventListener('click', searchLocation);
        
        // Prevent form submission when pressing enter on search input
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchLocation();
            }
        });

        // Fix leaflet map rendering bug in hidden/flex layouts
        setTimeout(() => map.invalidateSize(), 500);
    });
    </script>

    {{-- Leaflet JS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</x-admin-layout>