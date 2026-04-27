<x-admin-layout title="Dashboard" active="trips">

    {{-- ── Stat Cards ──────────────────────────────────────────────────── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @php
        $cards = [
            ['label' => 'Total Trip',     'value' => $counts['trips'],        'icon' => '✈️',  'color' => 'pink'],
            ['label' => 'Destinasi',      'value' => $counts['destinations'], 'icon' => '📍', 'color' => 'violet'],
            ['label' => 'Total Booking',  'value' => $counts['bookings'],     'icon' => '📋', 'color' => 'blue'],
            ['label' => 'Pending Bayar',  'value' => $counts['pending'],      'icon' => '⏳', 'color' => 'amber'],
        ];
        @endphp
        @foreach($cards as $card)
        <div class="bg-gray-900 border border-white/5 rounded-2xl p-5 hover:border-{{ $card['color'] }}-500/30 transition-colors">
            <div class="flex items-center justify-between mb-3">
                <span class="text-2xl">{{ $card['icon'] }}</span>
                <span class="px-2.5 py-1 bg-{{ $card['color'] }}-500/15 text-{{ $card['color'] }}-400 text-xs font-semibold rounded-full">Live</span>
            </div>
            <p class="text-3xl font-bold text-white mb-1">{{ $card['value'] }}</p>
            <p class="text-sm text-gray-500">{{ $card['label'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- ── Header Actions ───────────────────────────────────────────────── --}}
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="text-lg font-bold text-white">Daftar Trip</h2>
            <p class="text-sm text-gray-500">{{ $trips->count() }} trip terdaftar</p>
        </div>
        <a href="{{ route('admin.trips.create') }}"
           class="flex items-center gap-2 px-5 py-2.5 bg-pink-600 hover:bg-pink-500 text-white text-sm font-semibold rounded-xl transition shadow-lg shadow-pink-600/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Trip
        </a>
    </div>

    {{-- ── Trips Table ──────────────────────────────────────────────────── --}}
    <div class="bg-gray-900 border border-white/5 rounded-2xl overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-white/5 text-left">
                    <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Trip</th>
                    <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Rute</th>
                    <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Harga</th>
                    <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Durasi</th>
                    <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Booking</th>
                    <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/[0.03]">
                @forelse($trips as $trip)
                <tr class="hover:bg-white/[0.02] transition-colors group">
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-800 flex-shrink-0">
                                @if($trip->image)
                                    <img src="{{ $trip->image }}" alt="{{ $trip->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-600 text-xl">✈️</div>
                                @endif
                            </div>
                            <div>
                                <p class="font-semibold text-white">{{ $trip->title }}</p>
                                <p class="text-xs text-gray-500">{{ $trip->duration_days }} hari</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4">
                        <p class="text-gray-300 font-medium">{{ $trip->departure_city }}</p>
                        <p class="text-xs text-gray-500 flex items-center gap-1 mt-0.5">
                            <span>→</span> {{ $trip->destination }}
                        </p>
                    </td>
                    <td class="px-5 py-4">
                        <p class="font-semibold text-white">Rp {{ number_format($trip->price, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-500">per orang</p>
                    </td>
                    <td class="px-5 py-4">
                        <span class="px-2.5 py-1 bg-blue-500/10 text-blue-400 text-xs font-semibold rounded-full">
                            {{ $trip->duration_days }}H
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        <span class="font-semibold text-white">{{ $trip->bookings_count }}</span>
                        <span class="text-gray-500 text-xs ml-1">/ {{ $trip->kuota ?? '∞' }}</span>
                    </td>
                    <td class="px-5 py-4">
                        @if($trip->status === 'active')
                            <span class="flex items-center gap-1.5 w-fit px-2.5 py-1 bg-emerald-500/10 text-emerald-400 text-xs font-semibold rounded-full">
                                <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse"></span>
                                Aktif
                            </span>
                        @else
                            <span class="px-2.5 py-1 bg-gray-500/10 text-gray-400 text-xs font-semibold rounded-full">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.trips.edit', $trip->id) }}"
                               class="p-2 rounded-lg bg-white/5 hover:bg-blue-500/20 text-gray-400 hover:text-blue-400 transition"
                               title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('admin.trips.destroy', $trip->id) }}"
                                  onsubmit="return confirm('Hapus trip ini? Tindakan tidak dapat dibatalkan.')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="p-2 rounded-lg bg-white/5 hover:bg-red-500/20 text-gray-400 hover:text-red-400 transition"
                                        title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-5 py-16 text-center">
                        <div class="text-5xl mb-4">✈️</div>
                        <p class="text-gray-500 font-medium">Belum ada trip</p>
                        <a href="{{ route('admin.trips.create') }}" class="inline-block mt-3 text-pink-400 hover:text-pink-300 text-sm font-medium">
                            + Tambah trip pertama
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-admin-layout>