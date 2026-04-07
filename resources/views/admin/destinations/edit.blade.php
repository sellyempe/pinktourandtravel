<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Destinasi - PinkTravel Admin</title>
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
                <a href="{{ route('admin.destinations.dashboard') }}" class="text-teal-600 hover:text-teal-800 font-medium">
                    ← Kembali ke Destinasi
                </a>
            </div>

            <div class="bg-white rounded-lg shadow p-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-6">Edit Destinasi</h1>

                <form method="POST" action="{{ route('admin.destinations.update', $destination->id) }}">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Nama Destinasi</label>
                        <input type="text" name="name" value="{{ old('name', $destination->name) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-600" required>
                        @error('name')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <!-- Location -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Lokasi</label>
                        <input type="text" name="location" value="{{ old('location', $destination->location) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-600" required>
                        @error('location')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
                        <textarea name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-600" required>{{ old('description', $destination->description) }}</textarea>
                        @error('description')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <!-- Image URL -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Image URL</label>
                        <input type="url" name="image" value="{{ old('image', $destination->image) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-600" required>
                        @error('image')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <!-- Status -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Status</label>
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-600" required>
                            <option value="active" {{ old('status', $destination->status) === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $destination->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <!-- Submit -->
                    <div class="flex gap-4">
                        <button type="submit" class="bg-teal-600 text-white px-8 py-3 rounded-lg hover:bg-teal-700 transition font-semibold">
                            Update Destinasi
                        </button>
                        <a href="{{ route('admin.destinations.dashboard') }}" class="bg-gray-300 text-gray-900 px-8 py-3 rounded-lg hover:bg-gray-400 transition font-semibold">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
