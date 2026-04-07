<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Trip - PinkTravel Admin</title>
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
                <h1 class="text-3xl font-bold text-gray-900 mb-6">Edit Trip</h1>

                <form method="POST" action="{{ route('admin.trips.update', $trip->id) }}">
                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Judul Trip</label>
                        <input type="text" name="title" value="{{ old('title', $trip->title) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-600" required>
                        @error('title')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <!-- Departure City -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Kota Keberangkatan</label>
                            <input type="text" name="departure_city" value="{{ old('departure_city', $trip->departure_city) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-600" required>
                            @error('departure_city')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Tujuan</label>
                            <input type="text" name="destination" value="{{ old('destination', $trip->destination) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-600" required>
                            @error('destination')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
                        <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-600" required>{{ old('description', $trip->description) }}</textarea>
                        @error('description')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <!-- Overview -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Overview</label>
                        <textarea name="overview" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-600" required>{{ old('overview', $trip->overview) }}</textarea>
                        @error('overview')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <!-- Meeting Point -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Titik Kumpul</label>
                        <input type="text" name="meeting_point" value="{{ old('meeting_point', $trip->meeting_point) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-600" required>
                        @error('meeting_point')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <!-- Meeting Address -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Alamat Kumpul</label>
                        <input type="text" name="meeting_address" value="{{ old('meeting_address', $trip->meeting_address) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-600" required>
                        @error('meeting_address')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <!-- Price & Duration -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Harga (Rp)</label>
                            <input type="number" name="price" value="{{ old('price', $trip->price) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-600" required>
                            @error('price')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Durasi (Hari)</label>
                            <input type="number" name="duration_days" value="{{ old('duration_days', $trip->duration_days) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-600" required>
                            @error('duration_days')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <!-- Image URL -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Image URL</label>
                        <input type="url" name="image" value="{{ old('image', $trip->image) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-600" required>
                        @error('image')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <!-- Status -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Status</label>
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-600" required>
                            <option value="active" {{ old('status', $trip->status) === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $trip->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <!-- Submit -->
                    <div class="flex gap-4">
                        <button type="submit" class="bg-teal-600 text-white px-8 py-3 rounded-lg hover:bg-teal-700 transition font-semibold">
                            Update Trip
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="bg-gray-300 text-gray-900 px-8 py-3 rounded-lg hover:bg-gray-400 transition font-semibold">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
