<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Trip - PinkTravel Admin</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style></style>
    @endif
</head>
<body class="font-poppins bg-gray-50 text-gray-900">
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 bg-white border-b border-gray-200 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="/" class="text-2xl font-bold text-gray-900">
                    ✈️ PinkTravel Admin
                </a>
            </div>
        </div>
    </nav>

    <div class="pt-20">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('admin.dashboard') }}" class="text-teal-600 hover:text-teal-800 font-medium">
                    ← Kembali ke Dashboard
                </a>
            </div>

            <div class="bg-white rounded-lg shadow p-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-6">Tambah Trip Baru</h1>

                <form method="POST" action="{{ route('admin.trips.store') }}">
                    @csrf

                    <!-- Title -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Judul Trip</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-600" required>
                        @error('title')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <!-- Departure City -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Kota Keberangkatan</label>
                            <input type="text" name="departure_city" value="{{ old('departure_city') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-600" required>
                            @error('departure_city')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Tujuan</label>
                            <input type="text" name="destination" value="{{ old('destination') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-600" required>
                            @error('destination')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
                        <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-600" required>{{ old('description') }}</textarea>
                        @error('description')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <!-- Overview -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Overview</label>
                        <textarea name="overview" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-600" required>{{ old('overview') }}</textarea>
                        @error('overview')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <!-- Meeting Point -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Titik Kumpul</label>
                        <input type="text" name="meeting_point" value="{{ old('meeting_point') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-600" required>
                        @error('meeting_point')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <!-- Meeting Address -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Alamat Kumpul</label>
                        <input type="text" name="meeting_address" value="{{ old('meeting_address') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-600" required>
                        @error('meeting_address')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <!-- Price & Duration -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Harga (Rp)</label>
                            <input type="number" name="price" value="{{ old('price') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-600" required>
                            @error('price')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Durasi (Hari)</label>
                            <input type="number" name="duration_days" value="{{ old('duration_days') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-600" required>
                            @error('duration_days')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <!-- Image URL -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Image URL</label>
                        <input type="url" name="image" value="{{ old('image') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-600" required>
                        @error('image')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <!-- Status -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Status</label>
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-600" required>
                            <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <hr class="my-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Itinerary</h2>

                    <!-- Itinerary Days -->
                    <div id="itineraries" class="mb-8">
                        <div class="itinerary-item bg-gray-50 p-6 rounded-lg mb-4">
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Hari ke-</label>
                                    <input type="number" name="itineraries[0][day_number]" value="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Judul Hari</label>
                                    <input type="text" name="itineraries[0][title]" placeholder="e.g. Keberangkatan & Tiba" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
                                <textarea name="itineraries[0][description]" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg"></textarea>
                            </div>
                            <button type="button" onclick="removeItinerary(this)" class="text-red-600 hover:text-red-800 font-medium text-sm">
                                Hapus Hari
                            </button>
                        </div>
                    </div>
                    <button type="button" onclick="addItinerary()" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition mb-8">
                        + Tambah Hari
                    </button>

                    <hr class="my-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Included Items</h2>

                    <!-- Includes -->
                    <div id="includes" class="mb-8">
                        <div class="include-item bg-gray-50 p-6 rounded-lg mb-4">
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Item</label>
                                    <input type="text" name="includes[0][item_name]" placeholder="e.g. Tiket Pesawat" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Kategori</label>
                                    <input type="text" name="includes[0][category]" placeholder="e.g. Flights" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                                </div>
                            </div>
                            <button type="button" onclick="removeInclude(this)" class="text-red-600 hover:text-red-800 font-medium text-sm">
                                Hapus Item
                            </button>
                        </div>
                    </div>
                    <button type="button" onclick="addInclude()" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition mb-8">
                        + Tambah Include
                    </button>

                    <hr class="my-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Excluded Items</h2>

                    <!-- Excludes -->
                    <div id="excludes" class="mb-8">
                        <div class="exclude-item bg-gray-50 p-6 rounded-lg mb-4">
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Item</label>
                                    <input type="text" name="excludes[0][item_name]" placeholder="e.g. Tips Guide" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Kategori</label>
                                    <input type="text" name="excludes[0][category]" placeholder="e.g. Gratuity" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                                </div>
                            </div>
                            <button type="button" onclick="removeExclude(this)" class="text-red-600 hover:text-red-800 font-medium text-sm">
                                Hapus Item
                            </button>
                        </div>
                    </div>
                    <button type="button" onclick="addExclude()" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition mb-8">
                        + Tambah Exclude
                    </button>

                    <!-- Submit -->
                    <div class="flex gap-4">
                        <button type="submit" class="bg-teal-600 text-white px-8 py-3 rounded-lg hover:bg-teal-700 transition font-semibold">
                            Tambah Trip
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="bg-gray-300 text-gray-900 px-8 py-3 rounded-lg hover:bg-gray-400 transition font-semibold">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let itineraryCount = 1;
        let includeCount = 1;
        let excludeCount = 1;

        function addItinerary() {
            const container = document.getElementById('itineraries');
            const html = `
                <div class="itinerary-item bg-gray-50 p-6 rounded-lg mb-4">
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Hari ke-</label>
                            <input type="number" name="itineraries[${itineraryCount}][day_number]" value="${itineraryCount + 1}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Judul Hari</label>
                            <input type="text" name="itineraries[${itineraryCount}][title]" placeholder="e.g. Keberangkatan & Tiba" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
                        <textarea name="itineraries[${itineraryCount}][description]" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg"></textarea>
                    </div>
                    <button type="button" onclick="removeItinerary(this)" class="text-red-600 hover:text-red-800 font-medium text-sm">
                        Hapus Hari
                    </button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
            itineraryCount++;
        }

        function removeItinerary(btn) {
            btn.closest('.itinerary-item').remove();
        }

        function addInclude() {
            const container = document.getElementById('includes');
            const html = `
                <div class="include-item bg-gray-50 p-6 rounded-lg mb-4">
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Item</label>
                            <input type="text" name="includes[${includeCount}][item_name]" placeholder="e.g. Tiket Pesawat" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Kategori</label>
                            <input type="text" name="includes[${includeCount}][category]" placeholder="e.g. Flights" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                        </div>
                    </div>
                    <button type="button" onclick="removeInclude(this)" class="text-red-600 hover:text-red-800 font-medium text-sm">
                        Hapus Item
                    </button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
            includeCount++;
        }

        function removeInclude(btn) {
            btn.closest('.include-item').remove();
        }

        function addExclude() {
            const container = document.getElementById('excludes');
            const html = `
                <div class="exclude-item bg-gray-50 p-6 rounded-lg mb-4">
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Item</label>
                            <input type="text" name="excludes[${excludeCount}][item_name]" placeholder="e.g. Tips Guide" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Kategori</label>
                            <input type="text" name="excludes[${excludeCount}][category]" placeholder="e.g. Gratuity" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                        </div>
                    </div>
                    <button type="button" onclick="removeExclude(this)" class="text-red-600 hover:text-red-800 font-medium text-sm">
                        Hapus Item
                    </button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
            excludeCount++;
        }

        function removeExclude(btn) {
            btn.closest('.exclude-item').remove();
        }
    </script>
</body>
</html>
