<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - PinkTravel</title>
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
                    <h1 class="text-4xl font-bold text-gray-900">Kelola Trips</h1>
                    <p class="text-gray-600 mt-2">Manage semua trip packages</p>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('admin.reviews.dashboard') }}" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition font-semibold">
                        💬 Reviews
                    </a>
                    <a href="{{ route('admin.settings.dashboard') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                        ⚙️ Pengaturan
                    </a>
                    <a href="{{ route('admin.destinations.dashboard') }}" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition font-semibold">
                        Kelola Destinasi
                    </a>
                    <a href="{{ route('admin.trips.create') }}" class="bg-teal-600 text-white px-6 py-3 rounded-lg hover:bg-teal-700 transition font-semibold">
                        + Tambah Trip
                    </a>
                </div>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Trips Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold">Title</th>
                            <th class="px-6 py-4 text-left font-semibold">Keberangkatan</th>
                            <th class="px-6 py-4 text-left font-semibold">Tujuan</th>
                            <th class="px-6 py-4 text-left font-semibold">Harga</th>
                            <th class="px-6 py-4 text-left font-semibold">Status</th>
                            <th class="px-6 py-4 text-left font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($trips as $trip)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-semibold">{{ $trip->title }}</td>
                                <td class="px-6 py-4">{{ $trip->departure_city }}</td>
                                <td class="px-6 py-4">{{ $trip->destination }}</td>
                                <td class="px-6 py-4 font-semibold">Rp {{ number_format($trip->price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $trip->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ ucfirst($trip->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.trips.edit', $trip->id) }}" class="text-teal-600 hover:text-teal-800 font-medium mr-4">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.trips.destroy', $trip->id) }}" class="inline" onsubmit="return confirm('Yakin hapus trip ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    Belum ada trip
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
